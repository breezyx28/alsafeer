<?php

namespace App\Http\Controllers;

use App\Models\NewMeasure;
use App\Helper\ResponseMessage as Resp;
use App\Http\Requests\NewMeasuresRequest;
use Illuminate\Http\Request;

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

        foreach ($validate as $key => $value) {
            $measures->$key = $value;
        }

        try {
            $measures->save();
            return Resp::Success('تم المقاسات بنجاج', $measures);
        } catch (\Throwable $th) {
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
    public function update(Request $request, NewMeasure $newMeasure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewMeasure  $newMeasure
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewMeasure $newMeasure)
    {
        //
    }
}
