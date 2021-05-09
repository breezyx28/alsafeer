<?php

namespace App\Http\Requests;

use App\Rules\dateFormatRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UsersRequest extends FormRequest
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
            'empNumber' => 'required|numeric|max:100',
            'empName' => 'required|string|max:191',
            'phone' => 'required|unique:users,phone|digits:10',
            'address' => 'nullable|string|max:191',
            'perDay' => 'required|integer',
            'salary' => 'required|integer',
            'username' => 'required|unique:users|string|max:191',
            'password' => 'required|string|max:191',
            'role' => ['required', Rule::in(['مدير', 'مستخدم'])]
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
