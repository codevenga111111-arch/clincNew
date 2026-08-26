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

        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Revenue Over Time</h1>
            <div class="flex gap-2">
                <a href="{{ route('admin.reports.revenue', ['months' => 3]) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ $months == 3 ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors">3 Months</a>
                <a href="{{ route('admin.reports.revenue', ['months' => 6]) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ $months == 6 ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors">6 Months</a>
                <a href="{{ route('admin.reports.revenue', ['months' => 12]) }}" class="px-4 py-2 rounded-xl text-sm font-medium {{ $months == 12 ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition-colors">12 Months</a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Total Revenue</h3>
                <span class="text-3xl font-bold text-green-600">{{ number_format($totalRevenue, 2) }} EGP</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Monthly Revenue</h3>
            @if($revenue->count() > 0)
                <div class="space-y-4">
                    @foreach($revenue as $item)
                    <div class="flex items-center gap-4">
                        <div class="w-24 text-sm text-gray-500">{{ Carbon\Carbon::create($item->year, $item->month)->format('M Y') }}</div>
                        <div class="flex-1">
                            <div class="w-full bg-gray-200 rounded-full h-6">
                                <div class="bg-green-500 h-6 rounded-full flex items-center justify-end pr-2" style="width: {{ $totalRevenue > 0 ? ($item->total / $totalRevenue * 100) : 0 }}%">
                                    <span class="text-xs text-white font-medium">{{ number_format($item->total, 0) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-32 text-right font-medium text-gray-900">{{ number_format($item->total, 2) }}</div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <p class="text-gray-500 mt-4">No revenue data available</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
