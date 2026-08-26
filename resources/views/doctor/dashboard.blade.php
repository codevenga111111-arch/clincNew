@extends('layouts.doctor')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ __('Doctor Dashboard') }}</h2>
            <p class="text-sm text-gray-500 mt-1">Welcome back, Dr. {{ Auth::user()->name ?? '' }}! Here's your overview.</p>
        </div>
    </div>

    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">My Patients</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">0</p>
                        <p class="text-xs text-gray-500 mt-2">Assigned patients</p>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Today's Appointments</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">0</p>
                        <p class="text-xs text-gray-500 mt-2">Scheduled today</p>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pending Prescriptions</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">0</p>
                        <p class="text-xs text-gray-500 mt-2">To be issued</p>
                    </div>
                    <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Active Pregnancies</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">0</p>
                        <p class="text-xs text-gray-500 mt-2">Being monitored</p>
                    </div>
                    <div class="w-14 h-14 bg-pink-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-pink-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Upcoming Appointments</h3>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
                </div>
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-gray-500 mt-4">No upcoming appointments</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Patients</h3>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
                </div>
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <p class="text-gray-500 mt-4">No patients yet</p>
                </div>
            </div>
        </div>
    </div>
@endsection
