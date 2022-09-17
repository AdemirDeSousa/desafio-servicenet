<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'birthdate' => 'required',
            'email' => "required|email|unique:users,email,{$this->id}",
            'password' => 'nullable|confirmed|min:8'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Falha ao cadastrar usuario',
            'data' => $validator->getMessageBag()
        ], 400));
    }
}
