<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionLimit
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->clinic) {
            $clinic = Auth::user()->clinic;
            $subscription = $clinic->activeSubscription;

            if (!$subscription || !$subscription->isActive()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['error' => 'No active subscription'], 403);
                }

                return redirect()->route('dashboard')
                    ->with('error', 'Your subscription has expired. Please renew to continue.');
            }

            $plan = $subscription->subscriptionPlan;

            if ($plan) {
                $patientCount = $clinic->patients()->count();
                $userCount = $clinic->users()->count();

                if ($plan->patient_limit && $patientCount >= $plan->patient_limit) {
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json(['error' => 'Patient limit reached'], 403);
                    }

                    return redirect()->route('dashboard')
                        ->with('error', "Patient limit ({$plan->patient_limit}) reached. Please upgrade your plan.");
                }

                if ($plan->user_limit && $userCount >= $plan->user_limit) {
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json(['error' => 'User limit reached'], 403);
                    }

                    return redirect()->route('dashboard')
                        ->with('error', "User limit ({$plan->user_limit}) reached. Please upgrade your plan.");
                }
            }

            view()->share('currentSubscription', $subscription);
            view()->share('currentPlan', $plan);
        }

        return $next($request);
    }
}
