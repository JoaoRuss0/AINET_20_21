<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class EstampaUpdateRequest extends FormRequest
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
            'cliente_id' => [
                Rule::requiredIf(Auth::user()->tipo == 'C'),
                'in:' . Auth::user()->id,
            ],
            'categoria_id' => 'required_without:cliente_id|exists:categorias,id',
            'nome' => 'required|regex:/^[a-zA-ZÀ-ÿ 0-9]{1,255}$/',
            'descricao' => 'nullable',
            'photo' => 'nullable|image|max:8192',
        ];
    }
}
