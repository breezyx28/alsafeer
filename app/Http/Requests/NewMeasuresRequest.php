<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;


class NewMeasuresRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'clientName' => 'required|string|max:191',
            'clientPhone' => 'required|string|max:191',
            'customType' => 'required|string|in:جلابية,على الله,سروال,سديري',
            'shoulderHeight' => 'nullable|string|max:191',
            'height' => 'nullable|string|max:191',
            'armHeight' => 'nullable|string|max:191',
            'sides' => 'nullable|string|max:191',
            'goba' => 'nullable|string|max:191',
            'buttonsType' => 'string|in:داخلي,خارجي,مقفول',
            'kafaType' => 'string|in:برمة,عادي,7 سنتمتر',
            'pantsType' => 'string|in:لستك,تكة',
            'amount' => 'required|integer',
            'price' => 'required|integer',
            'paymentMethod' => 'required|string|in:كاش,بنكك',
            'paid' => 'required|integer',
            'rest' => 'required|integer',
            'dateOfRecive' => 'required|date',
            'shiftUser' => 'required|string|exists:users,username',
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
