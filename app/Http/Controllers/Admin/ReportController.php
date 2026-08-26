<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\ClinicSubscription;
use App\Models\User;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('admin.reports.index');
    }

    public function clinicsByStatus(): View
    {
        $data = [
            'active' => Clinic::where('is_active', true)->count(),
            'suspended' => Clinic::where('is_active', false)->count(),
        ];

        return view('admin.reports.clinics-status', compact('data'));
    }

    public function revenue(Request $request): View
    {
        $months = $request->get('months', 6);
        $startDate = Carbon::now()->subMonths($months);

        $revenue = ClinicSubscription::where('status', 'active')
            ->where('created_at', '>=', $startDate)
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(amount_paid) as total')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $totalRevenue = ClinicSubscription::where('status', 'active')->sum('amount_paid');

        return view('admin.reports.revenue', compact('revenue', 'totalRevenue', 'months'));
    }

    public function subscriptions(): View
    {
        $data = [
            'by_plan' => ClinicSubscription::with('subscriptionPlan')
                ->selectRaw('subscription_plan_id, COUNT(*) as count')
                ->groupBy('subscription_plan_id')
                ->get(),
            'by_status' => ClinicSubscription::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get(),
        ];

        return view('admin.reports.subscriptions', compact('data'));
    }

    public function userGrowth(): View
    {
        $months = 6;
        $startDate = Carbon::now()->subMonths($months);

        $growth = User::where('created_at', '>=', $startDate)
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $totalUsers = User::count();

        return view('admin.reports.user-growth', compact('growth', 'totalUsers', 'months'));
    }

    public function exportClinics(): \Illuminate\Http\Response
    {
        $clinics = Clinic::withCount('users', 'patients')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="clinics_report.csv"',
        ];

        $callback = function () use ($clinics) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'City', 'Status', 'Users', 'Patients', 'Created At']);

            foreach ($clinics as $clinic) {
                fputcsv($file, [
                    $clinic->id,
                    $clinic->name,
                    $clinic->email,
                    $clinic->phone,
                    $clinic->city,
                    $clinic->is_active ? 'Active' : 'Suspended',
                    $clinic->users_count,
                    $clinic->patients_count,
                    $clinic->created_at->format('Y-m-d'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportSubscriptions(): \Illuminate\Http\Response
    {
        $subscriptions = ClinicSubscription::with(['clinic', 'subscriptionPlan'])->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="subscriptions_report.csv"',
        ];

        $callback = function () use ($subscriptions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Clinic', 'Plan', 'Status', 'Amount', 'Start Date', 'End Date', 'Payment Method']);

            foreach ($subscriptions as $sub) {
                fputcsv($file, [
                    $sub->id,
                    $sub->clinic->name,
                    $sub->subscriptionPlan->name,
                    ucfirst($sub->status),
                    $sub->amount_paid,
                    $sub->starts_at->format('Y-m-d'),
                    $sub->ends_at->format('Y-m-d'),
                    $sub->payment_method,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
