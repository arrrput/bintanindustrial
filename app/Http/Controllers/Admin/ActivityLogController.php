<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $request = request();
        $query = ActivityLog::with('user')->orderBy('created_at', 'desc');

        // Filter by Name (Search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%");
                })->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by Module
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        // Filter by Action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        $logs = $query->take(100)->get();

        if ($request->ajax()) {
            return response()->json([
                'table' => view('cms.logs._table_rows', compact('logs'))->render(),
                'pagination' => ''
            ]);
        }

        $modules = ActivityLog::distinct()->pluck('module');
        $actions = ActivityLog::distinct()->pluck('action');

        return view('cms.logs.index', compact('logs', 'modules', 'actions'));
    }
}
