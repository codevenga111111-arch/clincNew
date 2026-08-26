<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class ClinicController extends Controller
{
    public function index(Request $request): View
    {
        $query = Clinic::withCount(['users', 'patients', 'appointments']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('city', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $clinics = $query->latest()->paginate(15);

        return view('admin.clinics.index', compact('clinics'));
    }

    public function create(): View
    {
        return view('admin.clinics.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clinics'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        Clinic::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'description' => $request->description,
            'is_active' => true,
        ]);

        return redirect()->route('admin.clinics.index')
            ->with('success', 'Clinic created successfully.');
    }

    public function show(Clinic $clinic): View
    {
        $clinic->loadCount(['users', 'patients', 'appointments', 'invoices']);
        $clinic->load('subscription.plan');

        return view('admin.clinics.show', compact('clinic'));
    }

    public function edit(Clinic $clinic): View
    {
        return view('admin.clinics.edit', compact('clinic'));
    }

    public function update(Request $request, Clinic $clinic): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clinics,email,' . $clinic->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['required', 'boolean'],
        ]);

        $clinic->update($request->only([
            'name', 'email', 'phone', 'address', 'city', 'description', 'is_active'
        ]));

        return redirect()->route('admin.clinics.index')
            ->with('success', 'Clinic updated successfully.');
    }

    public function destroy(Clinic $clinic): RedirectResponse
    {
        $clinic->delete();

        return redirect()->route('admin.clinics.index')
            ->with('success', 'Clinic deleted successfully.');
    }

    public function toggleActive(Clinic $clinic): RedirectResponse
    {
        $clinic->update([
            'is_active' => !$clinic->is_active,
        ]);

        $status = $clinic->is_active ? 'activated' : 'suspended';

        return redirect()->route('admin.clinics.index')
            ->with('success', "Clinic has been {$status}.");
    }

    public function impersonate(Clinic $clinic): RedirectResponse
    {
        $doctor = $clinic->doctors()->first();

        if (!$doctor) {
            return redirect()->route('admin.clinics.index')
                ->with('error', 'No doctor found for this clinic.');
        }

        \Illuminate\Support\Facades\Auth::loginUsingId($doctor->id);

        \App\Models\AuditLog::create([
            'clinic_id' => $clinic->id,
            'user_id' => auth()->id(),
            'action' => 'impersonate',
            'auditable_type' => App\Models\User::class,
            'auditable_id' => $doctor->id,
            'old_values' => [],
            'new_values' => ['impersonated_by' => auth()->id()],
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('doctor.dashboard');
    }
}
