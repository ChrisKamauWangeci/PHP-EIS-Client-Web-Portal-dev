<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Passwordreset;
use Illuminate\Http\Request;

class PasswordresetController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Passwordreset::query()
            ->when($filters['email'] ?? null, fn ($q, $v) => $q->where('email', 'LIKE', "%{$v}%"))
            ->when($filters['ip_address'] ?? null, fn ($q, $v) => $q->where('ip_address', 'LIKE', "%{$v}%"));

        $sort_field = $request->query('sort_field', 'id');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $passwordresets = $query->paginate(200);

        return view('admin.passwordresets.index', compact('passwordresets', 'sort_direction'));
    }
}
