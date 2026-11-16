<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index(Request $r)
    {
        $q = ActivityLog::query();
        if ($r->filled('user')) {
            $q->where('user_name', $r->query('user'));
        }
        if (array_key_exists($r->query('action'), ActivityLog::ACTIONS)) {
            $q->where('action', $r->query('action'));
        }
        if ($r->filled('from')) {
            $q->where('created_at', '>=', $r->date('from')->startOfDay());
        }
        if ($r->filled('to')) {
            $q->where('created_at', '<=', $r->date('to')->endOfDay());
        }
        if ($s = trim((string) $r->query('q'))) {
            $q->where('description', 'like', '%'.$s.'%');
        }

        return view('admin.audit.index', [
            'items' => $q->latest()->latest('id')->paginate(30)->withQueryString(),
            'users' => ActivityLog::select('user_name')->distinct()->orderBy('user_name')->pluck('user_name'),
        ]);
    }
}
