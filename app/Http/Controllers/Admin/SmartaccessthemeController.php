<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Smartaccesstheme;
use Illuminate\Http\Request;

class SmartaccessthemeController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->query();

        $query = Smartaccesstheme::query()
            ->when($filters['company_name'] ?? null, fn($q, $v) => $q->where('company_name', $v))
            ->when($filters['slug'] ?? null, fn($q, $v) => $q->where('slug', $v));

        $query->leftJoin('Company', 'smartaccessthemes.company_name', '=', 'Company.C_Name');
        $query->select([
            'smartaccessthemes.*',
            'Company.id as company_id',
            'Company.C_Name as companyname',
            'Company.smartaccess_active as smartaccess_active',
        ]);

        $sort_field = $request->query('sort_field', 'company_name');
        $sort_direction = $request->query('sort_direction', 'asc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $smartaccessthemes = $query->paginate(100);

        $companies = [
            'ASSUREDPARTNERS OF WA LLC',
            'BRIDGE LIFE LLC',
            'CAPFINANCIAL PARTNERS DBA STRATEGIC ADVISOR GROUP',
            'CHAFFEE AND ASSOCIATES',
            'CHAMBERLAIN GROUP',
            'CLARY EXECUTIVE BENEFITS LLC',
            'CORNERSTONE ADVISORS',
            'DBP WEALTH ADVISORY GROUP LLC',
            'FINANCIAL DESIGNS LTD',
            'GW FINANCIAL LLC DBA BOLICOLI',
            'HEIRMARK LTD',
            'HERITAGE STRATEGIES LLC',
            'JAMIESON FINANCIAL SERVICES',
            'JONES LOWRY',
            'KORNREICH INSURANCE BROKERAGE SERVICES',
            'KP USI INSURANCE SERVICES',
            'LEGACY ADVISORS LLC',
            'LINDBERG AND RIPPLE',
            'MOGUL INSURANCE AGENCY LLC',
            'MORRIS & BOYLE',
            'NEWTON ONE LLC',
            'ONE TEAM FINANCIAL LLC',
            'PECK FINANCIAL',
            'PFLEGER FINANCIAL',
            'PILLAR INTERNATIONAL INSURANCE ADVISORS',
            'THE COHN GROUP',
            'THE COYLE COMPANY',
            'TRC FINANCIAL',
            'VALLEY FORGE FINANCIAL GROUP',
            'VISO INSURANCE SERVICES LLC',
            'WINGED KEEL GROUP',
        ];

        return view('admin.smartaccessthemes.index', compact('smartaccessthemes', 'sort_direction'));
    }

    public function create(Request $request)
    {
        $isHtmx = $request->header('HX-Request');

        return view('admin.smartaccessthemes.create', compact('isHtmx'))->fragmentIf($isHtmx, 'formstore');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:50'],
            'slug' => ['required', 'string', 'max:50'],
            // 'fontcolor' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            // 'backgroundcolor' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            // 'headercolor' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            // 'logobackgroundcolor' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        $smartaccesstheme = new Smartaccesstheme($validated);
        $smartaccesstheme->created_by = session('admin.contractor.C_Name');
        $smartaccesstheme->updated_by = session('admin.contractor.C_Name');
        $smartaccesstheme->save();

        return redirect()
            ->route('admin.smartaccessthemes.show', $smartaccesstheme->id)
            ->with('success', 'Data has been saved');
    }

    public function show(Smartaccesstheme $smartaccesstheme)
    {
        return view('admin.smartaccessthemes.show', compact('smartaccesstheme'));
    }

    public function edit(Smartaccesstheme $smartaccesstheme)
    {
        return view('admin.smartaccessthemes.edit', compact('smartaccesstheme'));
    }

    public function update(Request $request, Smartaccesstheme $smartaccesstheme)
    {

        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:50'],
            'slug' => ['required', 'string', 'max:50'],
            'fontcolor' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'backgroundcolor' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'headercolor' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'logobackgroundcolor' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        $smartaccesstheme->update($validated + ['updated_by' => session('admin.contractor.C_Name')]);

        return redirect()
            ->route('admin.smartaccessthemes.show', $smartaccesstheme->id)
            ->with('success', 'Data has been saved');
    }

    public function destroy(Smartaccesstheme $smartaccesstheme)
    {
        $smartaccesstheme->delete();

        return redirect()
            ->route('admin.smartaccessthemes.index')
            ->with('success', 'Record has been deleted');
    }
}
