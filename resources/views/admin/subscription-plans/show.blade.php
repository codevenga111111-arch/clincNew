@extends('layouts.admin')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ route('admin.subscription-plans.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to Plans
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-8">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $plan->name }}</h1>
                    @if($plan->is_active)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Active</span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">Inactive</span>
                    @endif
                </div>
                <p class="text-sm text-gray-500 mt-1">{{ $plan->clinic_subscriptions_count }} clinic(s) subscribed</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.subscription-plans.edit', $plan) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-colors font-medium text-sm">Edit</a>
                <form action="{{ route('admin.subscription-plans.toggle-active', $plan) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 {{ $plan->is_active ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }} rounded-xl transition-colors font-medium text-sm">
                        {{ $plan->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Plan Details</h3>
                <dl class="space-y-4">
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Price</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ number_format($plan->price, 2) }} {{ $plan->currency }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Patient Limit</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $plan->patient_limit }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">User Limit</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $plan->user_limit }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Created</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $plan->created_at->format('M d, Y') }}</dd>
                    </div>
                </dl>
            </div>

            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Features</h3>
                @if($plan->features && count($plan->features) > 0)
                    <ul class="space-y-2">
                        @foreach($plan->features as $feature)
                        <li class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm text-gray-700">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500">No features defined</p>
                @endif
            </div>
        </div>

        @if($plan->clinicSubscriptions->count() > 0)
        <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Subscribed Clinics</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Clinic</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Start Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">End Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($plan->clinicSubscriptions as $sub)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.clinics.show', $sub->clinic) }}" class="font-medium text-blue-600 hover:text-blue-700">{{ $sub->clinic->name }}</a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sub->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($sub->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $sub->starts_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $sub->ends_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
