<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateReadySalesRequest extends FormRequest
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
            'customType' => [Rule::in([
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
            ])],
            'amount' => 'integer',
            'price' => 'integer',
            'paymentMethod' => 'string|in:كاش,بنكك',
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
