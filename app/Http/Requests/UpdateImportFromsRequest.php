<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateImportFromsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()->role == 'مدير') {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'totalPrice' => 'required|integer',
            'jalabeya' => 'required_with:jalabeyaPrice|integer',
            'jalabeyaPrice' => 'required_with:jalabeya|integer',
            'alaalla' => 'required_with:alaallaPrice|integer',
            'alaallaPrice' => 'required_with:alaalla|integer',
            'pants' => 'required_with:pantsPrice|integer',
            'pantsPrice' => 'required_with:pants|integer',
            'tageeya' => 'required_with:tageeyaPrice|integer',
            'tageeyaPrice' => 'required_with:tageeya|integer',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $messages = [];
        foreach ($errors->all() as $message) {
            $messages[] = $message;
        }
        throw new HttpResponseException(response()->json(['success' => false, 'errors' => $messages], 200));
    }
}
