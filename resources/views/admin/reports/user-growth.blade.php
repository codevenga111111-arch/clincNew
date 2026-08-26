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

        <h1 class="text-2xl font-bold text-gray-900 mb-8">User Growth</h1>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Total Users</h3>
                <span class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Monthly Registrations</h3>
            @if($growth->count() > 0)
                <div class="space-y-4">
                    @foreach($growth as $item)
                    <div class="flex items-center gap-4">
                        <div class="w-24 text-sm text-gray-500">{{ Carbon\Carbon::create($item->year, $item->month)->format('M Y') }}</div>
                        <div class="flex-1">
                            <div class="w-full bg-gray-200 rounded-full h-6">
                                <div class="bg-blue-500 h-6 rounded-full flex items-center justify-end pr-2" style="width: {{ $totalUsers > 0 ? ($item->count / $totalUsers * 100) : 0 }}%">
                                    <span class="text-xs text-white font-medium">{{ $item->count }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-16 text-right font-medium text-gray-900">{{ $item->count }}</div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <p class="text-gray-500 mt-4">No user data available</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
