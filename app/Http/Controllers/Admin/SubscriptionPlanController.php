<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class SubscriptionPlanController extends Controller
{
    public function index(): View
    {
        $plans = SubscriptionPlan::withCount('clinicSubscriptions')->latest()->get();

        return view('admin.subscription-plans.index', compact('plans'));
    }

    public function create(): View
    {
        return view('admin.subscription-plans.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'patient_limit' => ['required', 'integer', 'min:1'],
            'user_limit' => ['required', 'integer', 'min:1'],
            'features' => ['nullable', 'array'],
            'features.*' => ['string'],
        ]);

        SubscriptionPlan::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'currency' => $request->currency,
            'patient_limit' => $request->patient_limit,
            'user_limit' => $request->user_limit,
            'features' => $request->features ?? [],
            'is_active' => true,
        ]);

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Subscription plan created successfully.');
    }

    public function show(SubscriptionPlan $subscriptionPlan): View
    {
        $subscriptionPlan->loadCount('clinicSubscriptions');
        $subscriptionPlan->load('clinicSubscriptions.clinic');

        return view('admin.subscription-plans.show', ['plan' => $subscriptionPlan]);
    }

    public function edit(SubscriptionPlan $subscriptionPlan): View
    {
        return view('admin.subscription-plans.edit', ['plan' => $subscriptionPlan]);
    }

    public function update(Request $request, SubscriptionPlan $subscriptionPlan): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'patient_limit' => ['required', 'integer', 'min:1'],
            'user_limit' => ['required', 'integer', 'min:1'],
            'features' => ['nullable', 'array'],
            'features.*' => ['string'],
            'is_active' => ['required', 'boolean'],
        ]);

        $subscriptionPlan->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'currency' => $request->currency,
            'patient_limit' => $request->patient_limit,
            'user_limit' => $request->user_limit,
            'features' => $request->features ?? [],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Subscription plan updated successfully.');
    }

    public function destroy(SubscriptionPlan $subscriptionPlan): RedirectResponse
    {
        if ($subscriptionPlan->clinicSubscriptions()->count() > 0) {
            return redirect()->route('admin.subscription-plans.index')
                ->with('error', 'Cannot delete plan with active subscriptions.');
        }

        $subscriptionPlan->delete();

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', 'Subscription plan deleted successfully.');
    }

    public function toggleActive(SubscriptionPlan $subscriptionPlan): RedirectResponse
    {
        $subscriptionPlan->update([
            'is_active' => !$subscriptionPlan->is_active,
        ]);

        $status = $subscriptionPlan->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.subscription-plans.index')
            ->with('success', "Plan has been {$status}.");
    }
}
