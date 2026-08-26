@extends('layouts.admin')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Subscription Plans</h1>
                <p class="text-sm text-gray-500 mt-1">Manage subscription plans offered to clinics</p>
            </div>
            <a href="{{ route('admin.subscription-plans.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-5 rounded-xl transition-colors flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Plan
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($plans as $plan)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden {{ !$plan->is_active ? 'opacity-60' : '' }}">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $plan->name }}</h3>
                        @if($plan->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inactive</span>
                        @endif
                    </div>

                    <div class="mb-6">
                        <span class="text-3xl font-bold text-gray-900">{{ number_format($plan->price, 2) }}</span>
                        <span class="text-sm text-gray-500">/{{ $plan->currency }}</span>
                    </div>

                    <div class="space-y-3 mb-6">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm text-gray-600">{{ $plan->patient_limit }} Patients</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-sm text-gray-600">{{ $plan->user_limit }} Users</span>
                        </div>
                        @if($plan->features)
                            @foreach($plan->features as $feature)
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span class="text-sm text-gray-600">{{ $feature }}</span>
                            </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="text-xs text-gray-500 mb-4">
                        {{ $plan->clinic_subscriptions_count }} clinic(s) subscribed
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.subscription-plans.show', $plan) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View</a>
                            <span class="text-gray-300">|</span>
                            <a href="{{ route('admin.subscription-plans.edit', $plan) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">Edit</a>
                        </div>
                        <div class="flex items-center gap-2">
                            <form action="{{ route('admin.subscription-plans.toggle-active', $plan) }}" method="POST">
                                @csrf
                                <button type="submit" class="{{ $plan->is_active ? 'text-red-600 hover:text-red-700' : 'text-green-600 hover:text-green-700' }} text-sm font-medium">
                                    {{ $plan->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            @if($plan->clinic_subscriptions_count == 0)
                                <form action="{{ route('admin.subscription-plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">Delete</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
                <p class="font-medium text-gray-900">No subscription plans</p>
                <p class="text-sm text-gray-500 mt-1">Get started by creating a new plan</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
