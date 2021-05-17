<?php

namespace App\Http\Controllers;

use App\Models\Buy;
use App\Helper\ResponseMessage as Resp;
use App\Http\Requests\BuysRequest;
use Illuminate\Http\Request;

class BuyControllerResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buy = \App\Models\Buy::all();

        return Resp::Success('تم', $buy);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BuysRequest $request)
    {
        $validate = $request->validated();

        $buy = new Buy();

        foreach ($validate as $key => $value) {
            $buy->$key = $value;
        }

        try {
            $buy->save();
            return Resp::Success('تمت العملية بنجاح', $buy);
        } catch (\Throwable $th) {
            return Resp::Success('حدث خطأ', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Buy  $buy
     * @return \Illuminate\Http\Response
     */
    public function show(Buy $buy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Buy  $buy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Buy $buy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Buy  $buy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buy $buy)
    {
        //
    }
}
