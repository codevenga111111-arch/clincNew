<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClinicSubscription;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillingController extends Controller
{
    public function index(Request $request): View
    {
        $query = ClinicSubscription::with(['clinic', 'subscriptionPlan']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('clinic', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $subscriptions = $query->latest()->paginate(15);

        $stats = [
            'total' => ClinicSubscription::count(),
            'active' => ClinicSubscription::where('status', 'active')->count(),
            'cancelled' => ClinicSubscription::where('status', 'cancelled')->count(),
            'expired' => ClinicSubscription::where('status', 'expired')->count(),
            'revenue' => ClinicSubscription::where('status', 'active')->sum('amount_paid'),
        ];

        return view('admin.billing.index', compact('subscriptions', 'stats'));
    }

    public function show(ClinicSubscription $subscription): View
    {
        $subscription->load(['clinic', 'subscriptionPlan']);

        return view('admin.billing.show', compact('subscription'));
    }
}
