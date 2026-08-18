<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Requestor;
use Illuminate\Http\Request;

class RequestorController extends Controller
{
    public function autocomplete(Request $request)
    {
        $validated = $request->validate([
            'W_Requestor' => 'required|string|max:255',
        ]);

        $query = trim($validated['W_Requestor']);

        if ($query == '' || strlen($query) < 2) {
            return response('', 204);
        }

        $requestors = Requestor::query()
            ->where('R_Name', 'like', '%' . $validated['W_Requestor'] . '%')
            ->where('R_Active', 1)
            ->orderBy('R_Name', 'asc')
            ->limit(20)
            ->get();

        return view('user.requestors.autocomplete', compact('requestors'));
    }
}
