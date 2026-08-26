<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocusigndocumentRequest;
use App\Http\Requests\UpdateDocusigndocumentRequest;
use App\Models\Docusigndocument;
use App\Services\DocusignService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocusigndocumentController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Docusigndocument::query();

        $query->select([
            'id',
            'environment',
            'db',
            'signingtype',
            'envelopeid',
            'workorder_id',
            'slug',
            'client',
            'facility',
            'requestor',
            'first_name',
            'last_name',
            'email',
            'status',
            'created_at',
        ]);

        $query->when($filters['environment'] ?? null, fn ($q, $v) => $q->where('environment', $v))
            ->when($filters['db'] ?? null, fn ($q, $v) => $q->where('db', $v))
            ->when($filters['signingtype'] ?? null, fn ($q, $v) => $q->where('signingtype', $v))
            ->when($filters['envelopeid'] ?? null, fn ($q, $v) => $q->where('envelopeid', $v))
            ->when($filters['workorder_id'] ?? null, fn ($q, $v) => $q->where('workorder_id', $v))
            ->when($filters['slug'] ?? null, fn ($q, $v) => $q->where('slug', $v))
            ->when($filters['client'] ?? null, fn ($q, $v) => $q->where('client', 'LIKE', '%' . $v . '%'))
            ->when($filters['facility'] ?? null, fn ($q, $v) => $q->where('facility', 'LIKE', '%' . $v . '%'))
            ->when($filters['requestor'] ?? null, fn ($q, $v) => $q->where('requestor', 'LIKE', '%' . $v . '%'))
            ->when($filters['first_name'] ?? null, fn ($q, $v) => $q->where('first_name', 'LIKE', '%' . $v . '%'))
            ->when($filters['last_name'] ?? null, fn ($q, $v) => $q->where('last_name', 'LIKE', '%' . $v . '%'))
            ->when($filters['email'] ?? null, fn ($q, $v) => $q->where('email', $v))
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('status', $v))
            ->when($filters['created_at_from'] ?? null, fn ($q, $v) => $q->where('created_at', '>=', Carbon::parse($v)->startOfDay()))
            ->when($filters['created_at_to'] ?? null, fn ($q, $v) => $q->where('created_at', '<', Carbon::parse($v)->addDay()->startOfDay()));

        $query->when($filters['W_Status'] ?? null, function ($q, $v) {
            $q->whereHas(
                'workorder',
                fn ($q2) => $q2->where('W_Status', $v)
            );
        });

        $query->with(['workorder:W_WorkOrder,W_Status,W_CompletedDate']);

        $sort_field = $request->query('sort_field', 'created_at');
        $sort_direction = $request->query('sort_direction', 'desc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $docusigndocuments = $query->paginate(100);

        return view('user.docusigndocuments.index', compact('docusigndocuments', 'sort_direction'));
    }

    public function stats(Request $request)
    {
        $from = $request->query('from') ?? date('Y-m-d');
        $to = $request->query('to') ?? date('Y-m-d');

        $filters = $request->query();

        $fromdate = new \DateTime($from);
        $todate = new \DateTime($to);

        $days_difference = $fromdate->diff($todate)->format('%R%a');

        if ($days_difference < 0) {
            return redirect()
                ->route('user.docusigndocuments.stats')
                ->with('danger', 'Invalid dates selected');
        }

        if ($days_difference > 365) {
            return back()->with('danger', 'Maximum 1 year of date difference allowed.');
        }

        $query = Docusigndocument::query();

        $query->select([
            'client',
            DB::raw('count(*) as document'),
            DB::raw("count(case when status = 'envelope-sent' then 1 end) as envelopesent"),
            DB::raw("count(case when status = 'envelope-resent' then 1 end) as enveloperesent"),
            DB::raw("count(case when status = 'envelope-delivered' then 1 end) as envelopedelivered"),
            DB::raw("count(case when status = 'envelope-completed' then 1 end) as envelopecompleted"),
            DB::raw("count(case when status = 'envelope-voided' then 1 end) as envelopevoided"),
            DB::raw('avg(datediff(day, created_at, signed_at)) as turnaround'),
        ]);

        $query->when($filters['client'] ?? null, fn ($q, $v) => $q->where('client', $v));
        $query->when($filters['from'] ?? date('Y-m-d'), fn ($q, $v) => $q->where('created_at', '>=', $v . ' 00:00:00'));
        $query->when($filters['to'] ?? date('Y-m-d'), fn ($q, $v) => $q->where('created_at', '<=', $v . ' 23:59:59'));

        $query->groupBy('client');

        $query->limit(500);

        $docusigndocuments = $query->get();

        return view('user.docusigndocuments.stats', compact('docusigndocuments'));
    }

    public function create()
    {
        return view('user.docusigndocuments.create');
    }

    public function store(StoreDocusigndocumentRequest $request)
    {
        //
    }

    public function show(Docusigndocument $docusigndocument)
    {
        return view('user.docusigndocuments.show', compact('docusigndocument'));
    }

    public function download(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:eis.docusigndocuments,id',
        ]);

        $docusigndocument = Docusigndocument::find($request->query('id'));

        if (! $docusigndocument) {
            return back()->with('danger', 'record not found');
        }

        $docusignService = app(DocusignService::class);

        $docusigndocument = $docusignService->download($docusigndocument);

        if ($docusigndocument->downloaded_at) {
            return back()->with('success', 'file downloaded successfully');
        }

        return back()->with('danger', 'file download failed');
    }

    public function edit(Docusigndocument $docusigndocument)
    {
        //
    }

    public function update(UpdateDocusigndocumentRequest $request, Docusigndocument $docusigndocument)
    {
        //
    }

    public function destroy(Docusigndocument $docusigndocument)
    {
        //
    }
}
