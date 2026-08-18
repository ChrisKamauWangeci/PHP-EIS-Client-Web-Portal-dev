<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCreditcardRequest;
use App\Http\Requests\UpdateCreditcardRequest;
use App\Models\Creditcard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CreditcardController extends Controller
{
    public function __construct()
    {
        Gate::authorize('admin.creditcards.index');
    }

    public function index(Request $request)
    {
        $query = Creditcard::query();
        $creditcards = $query->paginate(100);

        return view('admin.creditcards.index', compact('creditcards'));
    }

    public function create()
    {
        return view('admin.creditcards.create');
    }

    public function store(StoreCreditcardRequest $request)
    {
        $creditcard = new Creditcard($request->validated());
        $creditcard->save();

        return redirect()
            ->route('admin.creditcards.show', $creditcard->id)
            ->with('success', 'Data has been saved');
    }

    public function show(Creditcard $creditcard)
    {
        return view('admin.creditcards.show', compact('creditcard'));
    }

    public function edit(Creditcard $creditcard)
    {
        return view('admin.creditcards.edit', compact('creditcard'));
    }

    public function update(UpdateCreditcardRequest $request, Creditcard $creditcard)
    {
        $creditcard->update($request->validated());

        return redirect()
            ->route('admin.creditcards.show', $creditcard->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(Creditcard $creditcard)
    {
        $creditcard->delete();

        return redirect()
            ->route('admin.creditcards.index')
            ->with('success', 'Record has been deleted');
    }
}
