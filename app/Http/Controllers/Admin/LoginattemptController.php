<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loginattempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginattemptController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Loginattempt::query()
            ->when($filters['username'] ?? null, fn ($q, $v) => $q->where('username', 'LIKE', "%{$v}%"))
            ->when($filters['ip_address'] ?? null, fn ($q, $v) => $q->where('ip_address', 'LIKE', "%{$v}%"));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $loginattempts = $query->paginate(200);

        return view('admin.loginattempts.index', compact('loginattempts', 'sort_direction'));
    }

    public function stats()
    {
        $loginattempts = Loginattempt::query()
            ->select(DB::raw('count(*) as counter'), 'ip_address')
            ->groupBy('ip_address')
            ->orderBy('counter', 'desc')
            ->limit(200)
            ->get();

        return view('admin.loginattempts.stats', compact('loginattempts'));
    }
}
