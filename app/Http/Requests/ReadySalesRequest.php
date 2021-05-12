<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;


class ReadySalesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'clientName' => 'required|string|max',
            'customType' => ['required', ['required', Rule::in([
                'جلابية',
                'على الله',
                'سروال',
                'سديري',
                'فنيلة',
                'عصاية',
                'طاقية',
                'بوكسر',
                'ساعة',
                'عطور',
                'قماش',
                'جزمة',
                'حذاء',
            ])],],
            'amount' => 'required|integer',
            'price' => 'required|integer',
            'paymentMethod' => 'required|string|in:كاش,بنكك',
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
