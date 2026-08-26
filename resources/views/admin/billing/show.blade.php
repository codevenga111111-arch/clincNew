@extends('layouts.admin')

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ route('admin.billing.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to Billing
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900">Subscription Details</h2>
            </div>

            <div class="p-6 space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $subscription->clinic->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $subscription->clinic->email }}</p>
                    </div>
                    @php
                        $statusColors = [
                            'active' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                            'expired' => 'bg-yellow-100 text-yellow-800',
                            'suspended' => 'bg-gray-100 text-gray-800',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$subscription->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($subscription->status) }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Plan</p>
                        <p class="font-medium text-gray-900">{{ $subscription->subscriptionPlan->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Amount Paid</p>
                        <p class="font-medium text-gray-900">{{ $subscription->amount_paid ? number_format($subscription->amount_paid, 2) . ' ' . $subscription->subscriptionPlan->currency : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Start Date</p>
                        <p class="font-medium text-gray-900">{{ $subscription->starts_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">End Date</p>
                        <p class="font-medium text-gray-900">{{ $subscription->ends_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Payment Method</p>
                        <p class="font-medium text-gray-900">{{ $subscription->payment_method ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Transaction ID</p>
                        <p class="font-medium text-gray-900">{{ $subscription->transaction_id ?: '-' }}</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Plan Limits</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-xl p-3">
                            <p class="text-xs text-gray-500">Patient Limit</p>
                            <p class="font-medium text-gray-900">{{ $subscription->subscriptionPlan->patient_limit }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3">
                            <p class="text-xs text-gray-500">User Limit</p>
                            <p class="font-medium text-gray-900">{{ $subscription->subscriptionPlan->user_limit }}</p>
                        </div>
                    </div>
                </div>

                @if($subscription->subscriptionPlan->features && count($subscription->subscriptionPlan->features) > 0)
                <div class="pt-4 border-t border-gray-100">
                    <h4 class="text-sm font-medium text-gray-700 mb-3">Features</h4>
                    <ul class="space-y-2">
                        @foreach($subscription->subscriptionPlan->features as $feature)
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm text-gray-700">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
