<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateNewMeasuresRequest extends FormRequest
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
            'clientName' => 'string|max:191',
            'clientPhone' => 'string|max:191',
            'customType' => 'string|in:جلابية,على الله,سروال,سديري',
            'shoulderHeight' => 'integer',
            'height' => 'text',
            'armHeight' => 'text',
            'sides' => 'text',
            'goba' => 'text',
            'buttonsType' => 'string|in:داخلي,خارجي,مقفول',
            'kafaType' => 'string|in:برمة,عادي,7 سنتمتر',
            'pantsType' => 'string|in:لستك,تكة',
            'amount' => 'required_with:price|integer',
            'price' => 'required_with:amount|integer',
            'paymentMethod' => 'string|in:كاش,بنكك',
            'paid' => 'required_with:price|integer',
            'rest' => 'required_with:paid|integer',
            'dateOfRecive' => 'date',
            'shiftUser' => 'string|exists:users,username',
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
