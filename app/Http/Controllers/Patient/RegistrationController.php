<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RegistrationController extends Controller
{
    public function showForm(): View
    {
        return view('patient.register');
    }

    public function sendOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $otp = rand(100000, 999999);

        Session::put('patient_registration', [
            'phone' => $request->phone,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        // In production, send OTP via SMS API
        // For now, we'll just flash it to the session for testing
        return redirect()->route('patient.verify-otp')
            ->with('success', "OTP sent to {$request->phone}. (Debug: {$otp})");
    }

    public function showOtpForm(): View
    {
        return view('patient.verify-otp');
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $registration = Session::get('patient_registration');

        if (!$registration) {
            return redirect()->route('patient.register')
                ->with('error', 'Registration session expired. Please start again.');
        }

        if (now()->isAfter($registration['expires_at'])) {
            Session::forget('patient_registration');
            return redirect()->route('patient.register')
                ->with('error', 'OTP expired. Please request a new one.');
        }

        if ($request->otp != $registration['otp']) {
            return redirect()->route('patient.verify-otp')
                ->with('error', 'Invalid OTP. Please try again.');
        }

        return redirect()->route('patient.complete-registration')
            ->with('success', 'OTP verified. Please complete your registration.');
    }

    public function showCompleteForm(): View
    {
        $registration = Session::get('patient_registration');

        if (!$registration) {
            return view('patient.register')
                ->withErrors(['error' => 'Session expired.']);
        }

        return view('patient.complete-registration', ['phone' => $registration['phone']]);
    }

    public function completeRegistration(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:male,female'],
        ]);

        $registration = Session::get('patient_registration');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'patient',
            'phone' => $registration['phone'],
            'is_active' => true,
        ]);

        $user->assignRole('patient');

        Session::forget('patient_registration');

        return redirect()->route('login')
            ->with('success', 'Registration successful. Please login.');
    }
}
