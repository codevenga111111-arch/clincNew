@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Edit Role: {{ $role->name }}</h2>
            <p class="text-sm text-gray-500 mt-1">Update role and permissions</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <form method="POST" action="{{ route('admin.roles.update', $role) }}">
            @csrf @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Role Name</label>
                <input type="text" name="name" value="{{ old('name', $role->name) }}" required autofocus class="w-full max-w-md px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="border-t border-gray-100 pt-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Permissions</h3>

                @if ($errors->has('permissions'))
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3 mb-4">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        {{ $errors->first('permissions') }}
                    </div>
                @endif

                <div class="space-y-6">
                    @foreach ($permissions as $group => $groupPermissions)
                        <div class="bg-gray-50 rounded-xl p-4">
                            <h4 class="text-sm font-semibold text-gray-600 mb-3 capitalize">{{ $group }}</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                @foreach ($groupPermissions as $permission)
                                    <label class="inline-flex items-center gap-2 cursor-pointer group">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 transition-colors" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-600 group-hover:text-gray-900 transition-colors">{{ $permission->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.roles.index') }}" class="px-5 py-2.5 border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors font-medium text-sm">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-colors font-medium text-sm shadow-sm">
                    Update Role
                </button>
            </div>
        </form>
    </div>
@endsection
