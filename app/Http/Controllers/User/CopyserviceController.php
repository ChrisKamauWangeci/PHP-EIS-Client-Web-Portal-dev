<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCopyserviceRequest;
use App\Http\Requests\UpdateCopyserviceRequest;
use App\Models\Copyservice;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CopyserviceController extends Controller
{
    public function index(Request $request)
    {
        $postname = trim($request->query('postname') ?? '') ?? null;

        $filters = $request->query();

        $query = Copyservice::query()
            ->when($filters['C_CopyService'] ?? null, fn ($q, $v) => $q->where('C_CopyService', 'LIKE', '%' . $v . '%'))
            ->when($filters['C_Phone'] ?? null, fn ($q, $v) => $q->where('C_Phone', 'LIKE', '%' . $v . '%'))
            ->when($filters['C_Address'] ?? null, fn ($q, $v) => $q->where('C_Address', 'LIKE', '%' . $v . '%'))
            ->when($filters['C_City'] ?? null, fn ($q, $v) => $q->where('C_City', 'LIKE', '%' . $v . '%'))
            ->when($filters['C_State'] ?? null, fn ($q, $v) => $q->where('C_State', 'LIKE', '%' . $v . '%'))
            ->when($filters['C_Zip'] ?? null, fn ($q, $v) => $q->where('C_Zip', 'LIKE', '%' . $v . '%'));

        $sort_field = $request->query('sort_field', 'C_CopyService');
        $sort_direction = $request->query('sort_direction', 'asc');
        $query->orderBy($sort_field, $sort_direction);
        $sort_direction = $sort_direction === 'asc' ? 'desc' : 'asc';

        $copyservices = $query->paginate(100);

        // Copyservice::query()->update([
        //     'attestation_file' => null,
        // ]);

        // foreach ($copyservices as $copyservice) {
        //     if (empty($copyservice->attestation_file)) {
        //         $copyservice->attestation_file = Str::slug(strtolower($copyservice->C_CopyService), '-') . '.pdf';
        //         $copyservice->timestamps = false;
        //         $copyservice->save();
        //     }
        // }

        return view('user.copyservices.index', compact('copyservices', 'sort_direction', 'postname'));
    }

    public function create()
    {
        return view('user.copyservices.create');
    }

    public function store(StoreCopyserviceRequest $request)
    {
        $copyservice = new Copyservice($request->validated());
        $copyservice->C_UpdateBy = session('user.contractor.C_Name');
        $copyservice->save();

        return redirect()
            ->route('user.copyservices.show', $copyservice->C_ID)
            ->with('success', 'Data has been saved');
    }

    public function show(Copyservice $copyservice)
    {
        // $hospitals = Hospital::where('H_CopyService', $copyservice->C_CopyService)->limit(100)->get();
        $hospitals = [];

        return view('user.copyservices.show', compact('copyservice', 'hospitals'));
    }

    public function edit(Copyservice $copyservice)
    {
        return view('user.copyservices.edit', compact('copyservice'));
    }

    public function update(UpdateCopyserviceRequest $request, Copyservice $copyservice)
    {
        $copyservice->update($request->validated() + [
            'C_UpdateBy' => session('user.contractor.C_Name'),
        ]);

        return redirect()
            ->route('user.copyservices.show', $copyservice->C_ID)
            ->with('success', 'Data has been saved');
    }

    public function fileupload(Request $request, Copyservice $copyservice)
    {
        $file = $request->file('uploadfile');
        $filetype = $request->input('filetype');
        $filename = $request->input('filename');
        $clientfilename = $file->getClientOriginalName();

        if (! empty($clientfilename)) {

            $extension = $file->getClientOriginalExtension();

            if (! in_array($extension, ['pdf'])) {
                $request->session()->flash('danger', 'Uploaded file has an invalid file extension');

                return back();
            }

            $directory = '\\\\ftpserver\\documents\\copyservices\\';

            $filename = $directory . $filename;

            $file->move($directory, basename($filename));

            if (is_file($filename)) {
                $request->session()->flash('success', 'File is uploaded: ' . $filename);

                return back();
            }

            return back()->with('danger', 'File was not uploaded');
        }
    }

    public function destroy(Copyservice $copyservice)
    {
        //
    }
}
