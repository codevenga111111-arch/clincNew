<?php

use App\Http\Controllers\Admin\BillingController;
use App\Http\Controllers\Admin\ClinicController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
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
    Route::resource('clinics', ClinicController::class);
    Route::post('clinics/{clinic}/toggle-active', [ClinicController::class, 'toggleActive'])->name('clinics.toggle-active');
    Route::post('clinics/{clinic}/impersonate', [ClinicController::class, 'impersonate'])->name('clinics.impersonate');
    Route::resource('subscription-plans', SubscriptionPlanController::class);
    Route::post('subscription-plans/{subscriptionPlan}/toggle-active', [SubscriptionPlanController::class, 'toggleActive'])->name('subscription-plans.toggle-active');
    Route::get('billing', [BillingController::class, 'index'])->name('billing.index');
    Route::get('billing/{subscription}', [BillingController::class, 'show'])->name('billing.show');
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/clinics-status', [ReportController::class, 'clinicsByStatus'])->name('reports.clinics-status');
    Route::get('reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
    Route::get('reports/subscriptions', [ReportController::class, 'subscriptions'])->name('reports.subscriptions');
    Route::get('reports/user-growth', [ReportController::class, 'userGrowth'])->name('reports.user-growth');
    Route::get('reports/export/clinics', [ReportController::class, 'exportClinics'])->name('reports.export.clinics');
    Route::get('reports/export/subscriptions', [ReportController::class, 'exportSubscriptions'])->name('reports.export.subscriptions');
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('audit-log', [SettingController::class, 'auditLog'])->name('settings.audit-log');
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
