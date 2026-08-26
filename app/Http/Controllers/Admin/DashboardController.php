<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\ClinicSubscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalClinics = Clinic::count();
        $activeClinics = Clinic::where('is_active', true)->count();
        $totalUsers = User::count();
        $activeSubscriptions = ClinicSubscription::where('status', 'active')->count();
        $totalRevenue = ClinicSubscription::where('status', 'active')->sum('amount_paid');

        $lastMonthClinics = Clinic::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $lastMonthUsers = User::where('created_at', '>=', Carbon::now()->subMonth())->count();

        $clinicGrowth = $totalClinics > 0 ? round(($lastMonthClinics / $totalClinics) * 100) : 0;
        $userGrowth = $totalUsers > 0 ? round(($lastMonthUsers / $totalUsers) * 100) : 0;

        $recentClinics = Clinic::latest()->take(5)->get();
        $recentUsers = User::with('clinic')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalClinics',
            'activeClinics',
            'totalUsers',
            'activeSubscriptions',
            'totalRevenue',
            'clinicGrowth',
            'userGrowth',
            'recentClinics',
            'recentUsers'
        ));
    }
}
