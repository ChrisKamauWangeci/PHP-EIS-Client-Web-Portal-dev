<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEhrorderssearchresultsexclusionRequest;
use App\Http\Requests\UpdateEhrorderssearchresultsexclusionRequest;
use App\Models\Ehrorderssearchresultsexclusion;
use Illuminate\Http\Request;

class EhrorderssearchresultsexclusionController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $ehrorderssearchresultsexclusions = Ehrorderssearchresultsexclusion::query()
            ->when($filters['managing_organization'] ?? null, fn ($q, $v) => $q->where('managing_organization', 'like', "%$v%"))
            ->when($filters['created_at_from'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($filters['created_at_to'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '<=', $v))
            ->paginate(100);

        return view('user.ehrorderssearchresultsexclusions.index', compact('ehrorderssearchresultsexclusions'));
    }

    public function show(Ehrorderssearchresultsexclusion $ehrorderssearchresultsexclusion)
    {
        return view('user.ehrorderssearchresultsexclusions.show', compact('ehrorderssearchresultsexclusion'));
    }

    public function create()
    {
        return view('user.ehrorderssearchresultsexclusions.create');
    }

    public function store(StoreEhrorderssearchresultsexclusionRequest $request)
    {
        $ehrorderssearchresultsexclusion = new Ehrorderssearchresultsexclusion($request->validated());
        $ehrorderssearchresultsexclusion->created_by = session('user.contractor.C_Name');
        $ehrorderssearchresultsexclusion->updated_by = session('user.contractor.C_Name');
        $ehrorderssearchresultsexclusion->save();

        return redirect()
            ->route('user.ehrorderssearchresultsexclusions.show', $ehrorderssearchresultsexclusion->id)
            ->with('success', 'Data has been saved');
    }

    public function edit(Request $request, Ehrorderssearchresultsexclusion $ehrorderssearchresultsexclusion)
    {
        return view('user.ehrorderssearchresultsexclusions.edit', compact('ehrorderssearchresultsexclusion'));
    }

    public function update(UpdateEhrorderssearchresultsexclusionRequest $request, Ehrorderssearchresultsexclusion $ehrorderssearchresultsexclusion)
    {
        $ehrorderssearchresultsexclusion->update($request->validated() + [
            'updated_by' => session('user.contractor.C_Name'),
        ]);

        return redirect()
            ->route('user.ehrorderssearchresultsexclusions.show', $ehrorderssearchresultsexclusion->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(Ehrorderssearchresultsexclusion $ehrorderssearchresultsexclusion)
    {
        $ehrorderssearchresultsexclusion->delete();

        return redirect()
            ->route('user.ehrorderssearchresultsexclusions.index')
            ->with('success', 'Record has been deleted');
    }
}
