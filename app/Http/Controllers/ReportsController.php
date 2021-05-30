<?php

namespace App\Http\Controllers;

use App\Helper\ResponseMessage as Resp;
use App\Http\Requests\ReportBetweenRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function ReportBetween(ReportBetweenRequest $request)
    {
        $validate = (object) $request->validated();

        try {
            //code...
            $data = DB::table($validate->table)->whereBetween('created_at', [$validate->startDate, $validate->endDate])->get();
            Resp::Success('تم', $data);
        } catch (\Throwable $th) {
            //throw $th;
            Resp::Error('حدث خطأ ما في عملية المقارنة', $th);
        }
    }
}
