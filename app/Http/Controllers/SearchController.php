<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage as Resp;
use Illuminate\Http\Request;
use App\Rules\phoneRule;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $validated = (object) $request->validate([
            'phoneNumber' => ['required', 'numeric', new phoneRule()]
        ]);

        // check for the phoneNummber in DB
        $check  = \App\Models\User::where('phone', $validated->phoneNumber)->firstOr(function () {
            return null;
        });

        return Resp::Success('ok', $check);
    }
}
