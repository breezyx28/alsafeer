<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Helper\ResponseMessage as Resp;
use App\Http\Requests\ReceiptRequest;
use App\Http\Requests\UpdateReceiptsRequest;
use Illuminate\Http\Request;

class ReceiptControllerResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rec = \App\Models\Receipt::all();

        return Resp::Success('تم', $rec);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReceiptRequest $request)
    {
        $validate = $request->validated();

        $rec = new Receipt();

        foreach ($validate as $key => $value) {
            $rec->$key = $value;
        }

        try {
            $rec->save();
            return Resp::Success('تمت العملية بنجاح', $rec);
        } catch (\Throwable $th) {
            return Resp::Success('حدث خطأ', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function show(Receipt $receipt)
    {
        return Resp::Success('تم', $receipt);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReceiptsRequest $request, Receipt $receipt)
    {
        $validate = $request->validated();

        foreach ($validate as $key => $value) {
            $receipt->$key = $value;
        }

        try {
            $receipt->save();
            return Resp::Success('تمت التحديث بنجاح', $receipt);
        } catch (\Throwable $th) {
            return Resp::Success('حدث خطأ', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receipt $receipt)
    {
        $receipt->delete();

        return Resp::Success('تم الحذف', $receipt);
    }
}
