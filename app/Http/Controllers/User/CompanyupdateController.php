<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyupdateRequest;
use App\Http\Requests\UpdateCompanyupdateRequest;
use App\Models\Companyupdate;
use App\Models\Contractor;
use Illuminate\Support\Facades\DB;

class CompanyupdateController extends Controller
{
    public function index()
    {
        $query = Companyupdate::query();

        $query->orderBy('created_at', 'desc');

        $query->with('contractor:id');

        $companyupdates = $query->paginate(100);

        return view('user.companyupdates.index', compact('companyupdates'));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyupdateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Companyupdate $companyupdate)
    {
        $companyupdate->contractor()->syncWithoutDetaching(session('user.contractor.id'));

        if (session('user.contractor.company_updates')) {

            $cu = Companyupdate::count();
            $cc = DB::table('companyupdate_contractor')->where('contractor_id', session('user.contractor.id'))->count();

            // dump($cu);
            // dd($cc);

            if ($cu == $cc) {
                Contractor::query()
                    ->where('id', session('user.contractor.id'))
                    ->update(
                        ['company_updates' => 0],
                        ['timestamps' => false]
                    );

                session(['user.contractor.company_updates' => 0]);
            }
        }

        $file = '//ftpserver/documents/website/companyupdates/' . $companyupdate->filename;
        if (is_file($file)) {
            return response()->file($file);
        }

        return view('user.companyupdates.show', compact('companyupdate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Companyupdate $companyupdate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyupdateRequest $request, Companyupdate $companyupdate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Companyupdate $companyupdate)
    {
        //
    }
}
