@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ __('Roles & Permissions') }}</h2>
            <p class="text-sm text-gray-500 mt-1">Manage roles and their permissions</p>
        </div>
        <a href="{{ route('admin.roles.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2.5 px-5 rounded-xl transition-colors flex items-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Add Role
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3 mb-6">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3 mb-6">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($roles as $role)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center text-white font-bold text-lg shadow-md">
                            {{ strtoupper(substr($role->name, 0, 2)) }}
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $role->name }}</h3>
                            <p class="text-xs text-gray-500">{{ $role->permissions->count() }} permissions</p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Permissions</h4>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach ($role->permissions->take(5) as $permission)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                {{ $permission->name }}
                            </span>
                        @endforeach
                        @if ($role->permissions->count() > 5)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                +{{ $role->permissions->count() - 5 }} more
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.roles.edit', $role) }}" class="flex-1 text-center bg-purple-50 hover:bg-purple-100 text-purple-700 font-medium py-2 rounded-xl transition-colors text-sm">
                        Edit
                    </a>
                    @if ($role->name !== 'super-admin')
                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full bg-red-50 hover:bg-red-100 text-red-700 font-medium py-2 rounded-xl transition-colors text-sm" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
