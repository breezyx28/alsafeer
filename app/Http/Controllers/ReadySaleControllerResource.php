<?php

namespace App\Http\Controllers;

use App\Models\ReadySale;
use App\Helper\ResponseMessage as Resp;
use App\Http\Requests\ReadySalesRequest;
use Illuminate\Http\Request;

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

        foreach ($validate as $key => $value) {
            $readySale->$key = $value;
        }

        try {
            $readySale->save();
            return Resp::Success('تمت العملية بنجاح', $readySale);
        } catch (\Throwable $th) {
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
    public function update(Request $request, ReadySale $readySale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReadySale  $readySale
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReadySale $readySale)
    {
        //
    }
}
