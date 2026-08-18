<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $directory = $request->query('directory');
        $W_WorkOrder = $request->query('W_WorkOrder');

        try {
            $listfiles = new \FilesystemIterator($directory, \FilesystemIterator::KEY_AS_FILENAME | \FilesystemIterator::SKIP_DOTS);
            $listfiles = new \RegexIterator($listfiles, "/$W_WorkOrder.*(\.pdf|\.tif)/i");
            $listfiles = array_reverse(iterator_to_array($listfiles));

            $files = [];
            $i = 0;

            foreach ($listfiles as $listfile) {
                $files[$i]['filename'] = $listfile->getFilename();
                $files[$i]['file'] = $directory . '\\' . $listfile->getFilename();
                $i++;
            }
        } catch (\Throwable $th) {
            $directory = '<span class="text-danger">directory error: ' . $directory . '</span>';
            $files = null;
        }

        return $files;
    }
}
