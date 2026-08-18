<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Login::query()
            ->when($filters['company'] ?? null, fn ($q, $v) => $q->where('company', 'LIKE', "%{$v}%"))
            ->when($filters['requestor'] ?? null, fn ($q, $v) => $q->where('requestor', 'LIKE', "%{$v}%"))
            ->when($filters['username'] ?? null, fn ($q, $v) => $q->where('username', 'LIKE', "%{$v}%"))
            ->when($filters['ip_address'] ?? null, fn ($q, $v) => $q->where('ip_address', 'LIKE', "%{$v}%"))
            ->when($filters['from'] ?? null, fn ($q, $v) => $q->where('created', '>=', "{$v} 00:00:00"))
            ->when($filters['to'] ?? null, fn ($q, $v) => $q->where('created', '<=', "{$v} 23:59:59"));

        $sort_field = $request->query('sort_field', 'created');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $logins = $query->paginate(200);

        return view('admin.logins.index', compact('logins', 'sort_direction'));
    }

    public function stats()
    {
        $logins = Login::query()
            ->select(DB::raw('count(*) as counter'), 'ip_address')
            ->groupBy('ip_address')
            ->orderBy('counter', 'desc')
            ->limit(200)
            ->get();

        return view('admin.logins.stats', compact('logins'));
    }
}
