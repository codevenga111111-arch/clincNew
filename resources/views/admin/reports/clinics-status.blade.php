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

        <h1 class="text-2xl font-bold text-gray-900 mb-8">Clinics by Status</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Active Clinics</h3>
                    <span class="text-3xl font-bold text-green-600">{{ $data['active'] }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="bg-green-500 h-4 rounded-full" style="width: {{ ($data['active'] + $data['suspended']) > 0 ? ($data['active'] / ($data['active'] + $data['suspended']) * 100) : 0 }}%"></div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Suspended Clinics</h3>
                    <span class="text-3xl font-bold text-red-600">{{ $data['suspended'] }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="bg-red-500 h-4 rounded-full" style="width: {{ ($data['active'] + $data['suspended']) > 0 ? ($data['suspended'] / ($data['active'] + $data['suspended']) * 100) : 0 }}%"></div>
                </div>
            </div>
        </div>

        <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Summary</h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="text-center">
                    <p class="text-sm text-gray-500">Total Clinics</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $data['active'] + $data['suspended'] }}</p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-500">Active Rate</p>
                    <p class="text-2xl font-bold text-green-600">{{ ($data['active'] + $data['suspended']) > 0 ? round($data['active'] / ($data['active'] + $data['suspended']) * 100) : 0 }}%</p>
                </div>
                <div class="text-center">
                    <p class="text-sm text-gray-500">Suspended Rate</p>
                    <p class="text-2xl font-bold text-red-600">{{ ($data['active'] + $data['suspended']) > 0 ? round($data['suspended'] / ($data['active'] + $data['suspended']) * 100) : 0 }}%</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
