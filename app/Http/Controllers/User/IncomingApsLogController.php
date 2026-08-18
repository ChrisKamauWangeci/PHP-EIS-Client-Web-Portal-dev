<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\IncomingApsLog;
use Illuminate\Http\Request;

class IncomingApsLogController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = IncomingApsLog::query()
            ->when($filters['source'] ?? null, fn ($q, $v) => $q->where('source', $v))
            ->when($filters['workorder'] ?? null, fn ($q, $v) => $q->where('workorder', $v))
            ->when($filters['new_file'] ?? null, fn ($q, $v) => $q->where('new_file', 'like', "%$v%"))
            ->when($filters['created_at_from'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($filters['created_at_to'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '<=', $v));

        $query->orderBy('created_at', 'desc');

        $incomingApsLogs = $query->paginate(100);

        return view('user.incoming_aps_logs.index', compact('incomingApsLogs'));
    }

    public function show(IncomingApsLog $incomingApsLog)
    {
        return view('user.incoming_aps_logs.show', compact('incomingApsLog'));
    }
}
