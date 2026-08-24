<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\Patient\RegistrationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'role.redirect'])->name('dashboard');

Route::middleware(['guest'])->prefix('patient')->name('patient.')->group(function () {
    Route::get('/register', [RegistrationController::class, 'showForm'])->name('register');
    Route::post('/register/send-otp', [RegistrationController::class, 'sendOtp'])->name('send-otp');
    Route::get('/verify-otp', [RegistrationController::class, 'showOtpForm'])->name('verify-otp');
    Route::post('/verify-otp', [RegistrationController::class, 'verifyOtp'])->name('verify-otp.submit');
    Route::get('/complete-registration', [RegistrationController::class, 'showCompleteForm'])->name('complete-registration');
    Route::post('/complete-registration', [RegistrationController::class, 'completeRegistration'])->name('complete-registration.submit');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::post('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
    Route::get('users/{user}/permissions', [UserController::class, 'permissions'])->name('users.permissions');
    Route::post('users/{user}/permissions', [UserController::class, 'updatePermissions'])->name('users.update-permissions');
    Route::resource('roles', RoleController::class);
});

Route::middleware(['auth', 'verified'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/', [DoctorDashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'verified', 'scope.clinic', 'clinic.active'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
