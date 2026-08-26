<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = [
            'site_name' => config('app.name', 'Clinic SaaS'),
            'site_description' => config('app.description', 'Multi-clinic management platform'),
            'maintenance_mode' => app()->isDownForMaintenance(),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_description' => ['nullable', 'string', 'max:500'],
        ]);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    public function auditLog(Request $request): View
    {
        $query = AuditLog::with(['user', 'clinic']);

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('action', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $logs = $query->latest()->paginate(20);

        $actions = AuditLog::distinct()->pluck('action')->filter();

        return view('admin.settings.audit-log', compact('logs', 'actions'));
    }
}
