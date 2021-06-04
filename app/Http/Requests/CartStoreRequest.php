<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartStoreRequest extends FormRequest
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
            'size' => 'required|in:XS,S,M,L,XL',
            'colour_code' => 'required|exists:cores,codigo',
            'stamp_id' => 'required|exists:estampas,id',
            'quantity' => 'required|integer|min:1'
        ];
    }
}
