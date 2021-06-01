<?php

namespace App\Http\Controllers;

use App\Models\NewMeasure;
use App\Models\Invoice;
use App\Helper\ResponseMessage as Resp;
use App\Http\Requests\NewMeasuresRequest;
use App\Http\Requests\UpdateNewMeasuresRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewMeasureControllerResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = \App\Models\NewMeasure::all();

        return Resp::Success('تم', $states);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewMeasuresRequest $request)
    {
        $validate = $request->validated();

        $measures = new NewMeasure();
        $invoice = new Invoice();

        foreach ($validate as $key => $value) {
            $measures->$key = $value;
            $measures->receiptNumber = auth()->user()->id . strtotime("now");
        }

        DB::beginTransaction();
        try {
            $measures->save();

            $invoice->invoiceNumber = random_int(1, 9) . strtotime("now");
            $invoice->clientName = $measures->clientName;
            $invoice->clientPhone = $measures->clientPhone;
            $invoice->total = $measures->price;
            $invoice->products = $measures->customType;
            $invoice->discount = 0;
            $invoice->paymentMethod = $measures->paymentMethod;
            $invoice->paid = $measures->paid;
            $invoice->rest = $measures->rest;
            $invoice->receiptDate = $measures->dateOfRecive;
            $invoice->status = $measures->rest != 0 ? 'الدفع غير مكتمل' : 'الدفع مكتمل';
            $invoice->shiftUser = auth()->user()->username;

            $invoice->save();

            DB::commit();
            return Resp::Success('تم حفظ المقاسات بنجاج', ['measures' => $measures, 'invoice' => $invoice]);
        } catch (\Throwable $th) {
            DB::rollback();
            return Resp::Success('حدث خطأ', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NewMeasure  $newMeasure
     * @return \Illuminate\Http\Response
     */
    public function show(NewMeasure $newMeasure)
    {
        return Resp::Success('تم', $newMeasure);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NewMeasure  $newMeasure
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewMeasuresRequest $request, NewMeasure $newMeasure)
    {
        $validate = $request->validated();

        foreach ($validate as $key => $value) {
            $newMeasure->$key = $value;
        }

        try {
            $newMeasure->save();
            return Resp::Success('تمت التحديث بنجاح', $newMeasure);
        } catch (\Throwable $th) {
            return Resp::Success('حدث خطأ', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewMeasure  $newMeasure
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewMeasure $newMeasure)
    {
        $newMeasure->delete();

        return Resp::Success('تم الحذف', $newMeasure);
    }
}
