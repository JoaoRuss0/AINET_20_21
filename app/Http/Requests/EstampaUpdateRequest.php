<?php

namespace App\Http\Requests;

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
            'cliente_id' => 'nullable',
            'categoria_id' => 'required|exists:categorias,id',
            'nome' => 'required|regex:/^[a-zA-ZÀ-ÿ 0-9]{1,255}$/',
            'descricao' => 'nullable',
            'photo' => 'nullable|image|max:8192',
        ];
    }
}
