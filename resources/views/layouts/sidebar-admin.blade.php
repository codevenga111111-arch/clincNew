<aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen bg-gradient-to-b from-[#60A5FA] to-[#2563EB] transition-transform -translate-x-full lg:translate-x-0 shadow-xl" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center pl-2.5 mb-8">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-md">
                <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-1.99.9-1.99 2L3 19c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 11h-4v4h-4v-4H6v-4h4V6h4v4h4v4z"/></svg>
            </div>
            <span class="self-center text-xl font-bold whitespace-nowrap text-white ms-3">Clinic SaaS</span>
        </a>

        <ul class="space-y-1 font-medium">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 text-white/80 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white shadow-lg' : '' }}">
                    <div class="w-8 h-8 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'bg-white/10' }} flex items-center justify-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                    </div>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="flex items-center p-3 text-white/80 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-white/20 text-white shadow-lg' : '' }}">
                    <div class="w-8 h-8 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-white/20' : 'bg-white/10' }} flex items-center justify-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                    </div>
                    <span class="ms-3">Users</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.roles.index') }}" class="flex items-center p-3 text-white/80 rounded-xl hover:bg-white/10 transition-all duration-200 {{ request()->routeIs('admin.roles.*') ? 'bg-white/20 text-white shadow-lg' : '' }}">
                    <div class="w-8 h-8 rounded-lg {{ request()->routeIs('admin.roles.*') ? 'bg-white/20' : 'bg-white/10' }} flex items-center justify-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
                    </div>
                    <span class="ms-3">Roles & Permissions</span>
                </a>
            </li>

            <li class="pt-4 pb-2">
                <span class="text-xs font-semibold text-white/40 uppercase tracking-wider ms-3">Management</span>
            </li>

            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 text-white/80 rounded-xl hover:bg-white/10 transition-all duration-200">
                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
                    </div>
                    <span class="ms-3">Clinics</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 text-white/80 rounded-xl hover:bg-white/10 transition-all duration-200">
                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/></svg>
                    </div>
                    <span class="ms-3">Subscription Plans</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 text-white/80 rounded-xl hover:bg-white/10 transition-all duration-200">
                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/></svg>
                    </div>
                    <span class="ms-3">Reports</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 text-white/80 rounded-xl hover:bg-white/10 transition-all duration-200">
                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.07.62-.07.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg>
                    </div>
                    <span class="ms-3">Settings</span>
                </a>
            </li>
        </ul>

        <div class="absolute bottom-4 left-0 right-0 px-3">
            <div class="bg-white/10 rounded-xl p-3">
                <div class="flex items-center">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-bold">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="ms-3">
                        <p class="text-sm font-medium text-white">{{ Auth::user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-white/60">Super Admin</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>
