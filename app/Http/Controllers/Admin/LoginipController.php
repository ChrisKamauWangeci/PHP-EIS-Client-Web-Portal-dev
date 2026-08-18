<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loginip;
use Illuminate\Http\Request;

class LoginipController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Loginip::query()
            ->when($filters['ip_address'] ?? null, fn ($q, $v) => $q->where('ip_address', $v))
            ->when($filters['company'] ?? null, fn ($q, $v) => $q->where('company', $v))
            ->when($filters['username'] ?? null, fn ($q, $v) => $q->where('username', $v))
            ->when($filters['login_count'] ?? null, fn ($q, $v) => $q->where('login_count', $v))
            ->when($filters['created'] ?? null, fn ($q, $v) => $q->where('created', $v))
            ->when($filters['login_last'] ?? null, fn ($q, $v) => $q->where('login_last', $v));

        $sort_field = $request->query('sort_field', 'created');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $loginips = $query->paginate(200);

        return view('admin.loginips.index', compact('loginips', 'sort_direction'));
    }
}
