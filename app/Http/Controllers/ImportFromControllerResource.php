<?php

namespace App\Http\Controllers;

use App\Models\ImportFrom;
use App\Helper\ResponseMessage as Resp;
use App\Http\Requests\ImportFromRequest;
use Illuminate\Http\Request;

class ImportFromControllerResource extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $importFrom = \App\Models\ImportFrom::all();

        return Resp::Success('تم', $importFrom);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImportFromRequest $request)
    {
        $validate = $request->validated();

        $importFrom = new ImportFrom();

        foreach ($validate as $key => $value) {
            $importFrom->$key = $value;
        }

        try {
            $importFrom->save();
            return Resp::Success('تمت العملية بنجاح', $importFrom);
        } catch (\Throwable $th) {
            return Resp::Success('حدث خطأ', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ImportFrom  $importFrom
     * @return \Illuminate\Http\Response
     */
    public function show(ImportFrom $importFrom)
    {
        return Resp::Success('تم', $importFrom);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ImportFrom  $importFrom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImportFrom $importFrom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ImportFrom  $importFrom
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImportFrom $importFrom)
    {
        $importFrom->delete();
        return Resp::Success('تم', $importFrom);
    }
}
