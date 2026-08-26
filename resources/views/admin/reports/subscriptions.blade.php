@extends('layouts.admin')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ route('admin.reports.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to Reports
            </a>
        </div>

        <h1 class="text-2xl font-bold text-gray-900 mb-8">Subscription Distribution</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">By Plan</h3>
                @if($data['by_plan']->count() > 0)
                    <div class="space-y-3">
                        @foreach($data['by_plan'] as $item)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">{{ $item->subscriptionPlan->name ?? 'Unknown' }}</span>
                            <span class="font-medium text-gray-900">{{ $item->count }}</span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500 text-center py-4">No data</p>
                @endif
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">By Status</h3>
                @if($data['by_status']->count() > 0)
                    <div class="space-y-3">
                        @foreach($data['by_status'] as $item)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">{{ ucfirst($item->status) }}</span>
                            <span class="font-medium text-gray-900">{{ $item->count }}</span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500 text-center py-4">No data</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
