<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required|regex:/^[a-zA-ZÀ-ÿ ]{1,255}$/',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->id),
            ],
            'password' => 'nullable|confirmed|min:8',
            'photo' => 'nullable|image|max:8192',
            'tipo' => 'required|in:C,A,F',
            'bloqueado' => 'required|in:0,1'
        ];
    }
}
