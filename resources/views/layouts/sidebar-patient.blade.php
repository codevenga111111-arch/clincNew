<aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen bg-gray-900 transition-transform -translate-x-full lg:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto">
        <a href="{{ route('patient.dashboard') }}" class="flex items-center pl-2.5 mb-5">
            <span class="self-center text-xl font-semibold whitespace-nowrap text-white">Clinic SaaS</span>
        </a>

        <ul class="space-y-2 font-medium">
            <li>
                <a href="{{ route('patient.dashboard') }}" class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-gray-700 group {{ request()->routeIs('patient.dashboard') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('patient.appointments.index') }}" class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-gray-700 group {{ request()->routeIs('patient.appointments.*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
                    <span class="ms-3">Appointments</span>
                </a>
            </li>
            <li>
                <a href="{{ route('patient.pregnancy.show') }}" class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-gray-700 group {{ request()->routeIs('patient.pregnancy.*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    <span class="ms-3">Pregnancy</span>
                </a>
            </li>
            <li>
                <a href="{{ route('patient.prescriptions.index') }}" class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-gray-700 group {{ request()->routeIs('patient.prescriptions.*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    <span class="ms-3">Prescriptions</span>
                </a>
            </li>
            <li>
                <a href="{{ route('patient.invoices.index') }}" class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-gray-700 group {{ request()->routeIs('patient.invoices.*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/></svg>
                    <span class="ms-3">Invoices</span>
                </a>
            </li>
            <li>
                <a href="{{ route('patient.medical-profile.edit') }}" class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-gray-700 group {{ request()->routeIs('patient.medical-profile.*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    <span class="ms-3">Medical Profile</span>
                </a>
            </li>
            <li>
                <a href="{{ route('patient.settings.index') }}" class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-gray-700 group {{ request()->routeIs('patient.settings.*') ? 'bg-gray-700 text-white' : '' }}">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.07.62-.07.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg>
                    <span class="ms-3">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
