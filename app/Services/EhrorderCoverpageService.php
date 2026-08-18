<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Company;
use App\Models\Ehrorder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Process;

class EhrorderCoverpageService
{
    public function generate(Ehrorder $ehrorder)
    {
        $data = [
            'ehrorder' => $ehrorder,
        ];

        $directory = '\\\\ftpserver2\\ftpserver\\eis\\coverpage_auth\\' . $ehrorder->created_at->format('Ymd') . '\\';

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $coverpagePath = $directory . $ehrorder->id . '-coverpage.pdf';

        $mergedPath = $directory . $ehrorder->id . '-coverpage_auth.pdf';

        $company = Company::query()
            ->select([
                'C_Name',
                'C_WebID',
                'C_LOR',
                'C_LORExpirationDate',
            ])
            ->where('C_Name', $ehrorder->company_name)
            ->first();

        $lorfile = $company?->C_LOR;

        if($ehrorder->company_name == 'USAA') {
            $lorfile = 'USAA_LOR.pdf';
        }

        $isPdf = $lorfile && str_ends_with(strtolower($lorfile), '.pdf');

        $lor = '\\\\ftpserver\\ftpserver\\lor\\' . $lorfile;

        // if(is_file($coverpagePath)) {
        //     unlink($coverpagePath);
        // }

        // if(is_file($mergedPath)) {
        //     unlink($mergedPath);
        // }

        $pdf = Pdf::loadView(
            'user/ehrorders/pdf/coverpage',
            $data
        );

        $pdf->save($coverpagePath);

        $command = [
            'C:\gs\bin\gswin64c.exe',
            '-dQUIET',
            '-q',
            '-dBATCH',
            '-dNOPAUSE',
            '-sPAPERSIZE=letter',
            '-dFitPage',
            '-sDEVICE=pdfwrite',
            '-dPDFSETTINGS=/printer',
            '-sOutputFile=' . $mergedPath,
        ];

        if (is_file($coverpagePath)) {
            $command[] = $coverpagePath;
        }

        if(is_file($lor) && $isPdf) {
            $command[] = $lor;
        }

        if (is_file($ehrorder->auth_file_path)) {
            $command[] = $ehrorder->auth_file_path;
        }

        Process::run($command);

        return $pdf;
    }
}