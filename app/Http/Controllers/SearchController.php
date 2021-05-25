<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage as Resp;
use Illuminate\Http\Request;
use App\Rules\phoneRule;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $validated = (object) $request->validate([
            'phoneNumber' => ['required', 'numeric', new phoneRule()],
            'table' => 'required|in:invoices,new_measures,ready_sales,receipts,users,indebtedness'
        ]);

        // check for the phoneNummber in DB
        $check  = DB::table($validated->table)->where($validated->table == 'indebtedness' || 'users' ? 'phone' : 'clientPhone', $validated->phoneNumber)->first();

        return Resp::Success('ok', $check);
    }
}
