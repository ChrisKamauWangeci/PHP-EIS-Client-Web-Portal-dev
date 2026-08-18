<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Docusigndocument;
use App\Models\Facilityform;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocusigndocumentController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Docusigndocument::query()
            ->when($filters['db'] ?? null, fn ($q, $v) => $q->where('db', 'LIKE', "%{$v}%"))
            ->when($filters['signingtype'] ?? null, fn ($q, $v) => $q->where('signingtype', 'LIKE', "%{$v}%"))
            ->when($filters['envelopeid'] ?? null, fn ($q, $v) => $q->where('envelopeid', 'LIKE', "%{$v}%"))
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('workorder_id', 'LIKE', "%{$v}%"))
            ->when($filters['facility'] ?? null, fn ($q, $v) => $q->where('facility', 'LIKE', "%{$v}%"))
            ->when($filters['client'] ?? null, fn ($q, $v) => $q->where('client', 'LIKE', "%{$v}%"))
            ->when($filters['company'] ?? null, fn ($q, $v) => $q->where('company', 'LIKE', "%{$v}%"))
            ->when($filters['requestor'] ?? null, fn ($q, $v) => $q->where('requestor', 'LIKE', "%{$v}%"))
            ->when($filters['first_name'] ?? null, fn ($q, $v) => $q->where('first_name', 'LIKE', "%{$v}%"))
            ->when($filters['last_name'] ?? null, fn ($q, $v) => $q->where('last_name', 'LIKE', "%{$v}%"))
            ->when($filters['created_at_from'] ?? null, fn ($q, $v) => $q->where('created_at', '>=', $v . ' 00:00:00'))
            ->when($filters['created_at_to'] ?? null, fn ($q, $v) => $q->where('created_at', '<=', $v . ' 23:59:59'));

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $docusigndocuments = $query->paginate(100);

        return view('admin.docusigndocuments.index', compact('docusigndocuments', 'sort_direction'));
    }

    public function stats(Request $request)
    {
        $docusigndocuments = Docusigndocument::query()
            ->select(DB::raw('count(*) as counter'), DB::raw('DATEPART(year, created_at) as year'), DB::raw('DATEPART(month, created_at) as month'))
            ->groupby(DB::raw('DATEPART(year, created_at)'), DB::raw('DATEPART(month, created_at)'))
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $docusigndocumentsforms = Docusigndocument::query()
            ->select(DB::raw('count(*) as counter'), 'slug')
            ->groupby('slug')
            ->orderBy('counter', 'desc')
            ->limit(300)
            ->get();

        foreach ($docusigndocumentsforms as $docusigndocumentsform) {
            $facilityform = Facilityform::query()
                ->where('slug', $docusigndocumentsform->slug)
                ->first();
            if ($facilityform) {
                $facilityform->usage_count = $docusigndocumentsform->counter;
                $facilityform->save();
            }
        }

        return view('admin.docusigndocuments.stats', compact('docusigndocuments', 'docusigndocumentsforms'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Docusigndocument $docusigndocument)
    {
        return view('admin.docusigndocuments.show', compact('docusigndocument'));
    }

    public function edit(Docusigndocument $docusigndocument)
    {
        //
    }

    public function update(Request $request, Docusigndocument $docusigndocument)
    {
        //
    }

    public function destroy(Docusigndocument $docusigndocument)
    {
        //
    }
}
