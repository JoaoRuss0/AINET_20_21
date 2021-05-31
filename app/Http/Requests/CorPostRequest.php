<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorPostRequest extends FormRequest
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
            'nome' => 'required|regex:/^[a-zA-ZÀ-ÿ ]{1,255}$/',
            'codigo' => 'required|regex:/^[a-zA-Z0-9#]{1,50}$/'
        ];
    }
}
