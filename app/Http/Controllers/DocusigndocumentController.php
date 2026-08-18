<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Mail\DocusignaccesscodeEmail;
use App\Models\Docusigndocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DocusigndocumentController extends Controller
{
    protected $environment = 'test';

    public function index()
    {
        return view('docusigndocuments.index');
    }

    public function dst(Request $request)
    {
        try {
            $encryptedId = $request->query('id');
            $id = decrypt(rawurldecode($encryptedId));
            $docusigndocument = Docusigndocument::find($id);
            if ($docusigndocument && ! $docusigndocument->email_opened_at) {
                $docusigndocument->email_opened_at = now();
                $docusigndocument->save();
            }
        } catch (\Exception $e) {
        }

        return response(base64_decode('R0lGODdhAQABAIAAAPxqbAAAACwAAAAAAQABAAACAkQBADs='))
            ->header('Content-Type', 'image/gif')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    public function sendcode(Request $request)
    {
        $email = $request->input('email');

        $docusigndocument = Docusigndocument::query()
            ->where('signingtype', 'email')
            ->where('status', '!=', 'envelope-completed')
            ->where('email', $email)
            ->orderBy('created_at', 'desc')
            ->first();

        if (! $docusigndocument) {
            return back()->with('danger', 'record not found');
        }

        $sara['data'] = [
            'patient_first_name' => $docusigndocument->first_name,
            'patient_last_name' => $docusigndocument->last_name,
            'access_code' => $docusigndocument->access_code,
        ];

        $data['from'] = 'sign@expressimagingservices.com';
        $data['subject'] = 'Docusign Access Code Reminder';
        $data['data'] = $sara;
        $data['view'] = 'emails.docusignaccesscode';
        Mail::mailer('smtprelaygmail')->to($docusigndocument->email)->send(new DocusignaccesscodeEmail($data));

        return back()->with('success', 'The Docusign security code was sent to your email.');
    }
}
