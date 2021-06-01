<?php

namespace App\Http\Controllers;

use App\Models\ReadySale;
use App\Models\Invoice;
use App\Helper\ResponseMessage as Resp;
use App\Http\Requests\ReadySalesRequest;
use App\Http\Requests\UpdateReadySalesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReadySaleControllerResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $readySale = \App\Models\ReadySale::all();

        return Resp::Success('تم', $readySale);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReadySalesRequest $request)
    {
        $validate = $request->validated();

        $readySale = new ReadySale();
        $invoice = new Invoice();

        foreach ($validate as $key => $value) {
            $readySale->$key = $value;
        }

        DB::beginTransaction();
        try {
            $readySale->save();

            $invoice->invoiceNumber = random_int(1, 9) . strtotime("now");
            $invoice->clientName = $readySale->clientName;
            $invoice->total = $readySale->price * $readySale->amount;
            $invoice->products = $readySale->customType;
            $invoice->discount = 0;
            $invoice->paymentMethod = $readySale->paymentMethod;
            $invoice->paid = $readySale->price * $readySale->amount;
            $invoice->rest = 0;
            $invoice->receiptDate = \Carbon\Carbon::now()->format('Y-m-d');
            $invoice->status = 'الدفع مكتمل';
            $invoice->shiftUser = auth()->user()->username;

            $invoice->save();

            DB::commit();
            return Resp::Success('تم بنجاج', ['readySales' => $readySale, 'invoice' => $invoice]);
        } catch (\Throwable $th) {
            DB::rollback();
            return Resp::Success('حدث خطأ', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReadySale  $readySale
     * @return \Illuminate\Http\Response
     */
    public function show(ReadySale $readySale)
    {
        return Resp::Success('تم', $readySale);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReadySale  $readySale
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReadySalesRequest $request, ReadySale $readySale)
    {
        $validate = $request->validated();

        foreach ($validate as $key => $value) {
            $readySale->$key = $value;
        }

        try {
            $readySale->save();
            return Resp::Success('تمت التحديث بنجاح', $readySale);
        } catch (\Throwable $th) {
            return Resp::Success('حدث خطأ', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReadySale  $readySale
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReadySale $readySale)
    {
        $readySale->delete();

        return Resp::Success('تم الحذف', $readySale);
    }
}
