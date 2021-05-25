<?php

namespace App\Http\Requests;

use App\Rules\dateFormatRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class updateUsersRequest extends FormRequest
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
            'empNumber' => 'numeric',
            'empName' => 'string|max:191',
            'phone' => 'unique:users,phone|digits:10',
            'address' => 'nullable|string|max:191',
            'perDay' => 'integer',
            'salary' => 'integer',
            'username' => 'unique:users|string|max:191',
            'password' => 'string|max:191',
            'role' => [Rule::in(['مدير', 'مستخدم'])]
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
