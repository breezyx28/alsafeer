<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use App\Helper\ResponseMessage as Resp;
use App\Http\Requests\ExpensesRequest;
use App\Http\Requests\UpdatEexpensesRequest;
use Illuminate\Http\Request;

class ExpensesControllerResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exp = \App\Models\Expenses::all();

        return Resp::Success('تم', $exp);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpensesRequest $request)
    {
        $validate = $request->validated();

        $exp = new Expenses();

        foreach ($validate as $key => $value) {
            $exp->$key = $value;
        }

        try {
            $exp->save();
            return Resp::Success('تمت العملية بنجاح', $exp);
        } catch (\Throwable $th) {
            return Resp::Success('حدث خطأ', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function show(Expenses $expense)
    {
        return Resp::Success('تم', $expense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatEexpensesRequest $request, Expenses $expenses)
    {
        $validate = $request->validated();

        foreach ($validate as $key => $value) {
            $expenses->$key = $value;
        }

        try {
            $expenses->save();
            return Resp::Success('تمت التحديث بنجاح', $expenses);
        } catch (\Throwable $th) {
            return Resp::Success('حدث خطأ', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expenses $expenses)
    {
        $expenses->delete();

        return Resp::Success('تم الحذف', $expenses);
    }
}
