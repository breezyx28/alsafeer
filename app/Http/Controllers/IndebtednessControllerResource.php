<?php

namespace App\Http\Controllers;

use App\Models\Indebtedness;
use App\Helper\ResponseMessage as Resp;
use App\Http\Requests\IndebtednessRequest;
use App\Http\Requests\UpdateIndebtednessRequest;
use Illuminate\Http\Request;

class IndebtednessControllerResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ind = \App\Models\Indebtedness::all();

        return Resp::Success('تم', $ind);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IndebtednessRequest $request)
    {
        $validate = $request->validated();

        $ind = new Indebtedness();

        foreach ($validate as $key => $value) {
            $ind->$key = $value;
        }

        try {
            $ind->save();
            return Resp::Success('تمت العملية بنجاح', $ind);
        } catch (\Throwable $th) {
            return Resp::Success('حدث خطأ', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Indebtedness  $indebtedness
     * @return \Illuminate\Http\Response
     */
    public function show(Indebtedness $indebtedness)
    {
        return Resp::Success('تم', $indebtedness);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Indebtedness  $indebtedness
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIndebtednessRequest $request, Indebtedness $indebtedness)
    {
        $validate = $request->validated();

        foreach ($validate as $key => $value) {
            $indebtedness->$key = $value;
        }

        try {
            $indebtedness->save();
            return Resp::Success('تمت التحديث بنجاح', $indebtedness);
        } catch (\Throwable $th) {
            return Resp::Success('حدث خطأ', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Indebtedness  $indebtedness
     * @return \Illuminate\Http\Response
     */
    public function destroy(Indebtedness $indebtedness)
    {
        $indebtedness->delete();

        return Resp::Success('تم الحذف', $indebtedness);
    }
}
