<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bankstatement;
use Illuminate\Http\Request;

class BankstatementController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Bankstatement::query()
            ->when($filters['B_Workorder'] ?? null, fn ($q, $v) => $q->where('B_Workorder', $v));

        $sort_field = $request->query('sort_field', 'B_Workorder');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $bankstatements = $query->paginate(100);
        // dd($bankstatements);

        return view('user.bankstatements.index', compact('bankstatements', 'sort_direction'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Bankstatement $bankstatement)
    {
        return view('user.bankstatements.show', compact('bankstatement'));
    }

    public function edit(Bankstatement $bankstatement)
    {
        //
    }

    public function update(Request $request, Bankstatement $bankstatement)
    {
        //
    }

    public function destroy(Bankstatement $bankstatement)
    {
        //
    }
}
