<?php

namespace App\Http\Controllers;

use App\Models\Preco;
use App\Http\Requests\PrecosPostRequest;
use Exception;

class PrecoController extends Controller
{
    public function index()
    {
        return view('precos.index')
            ->with('title', 'Prices')
            ->with('prices', Preco::first());
    }

    public function update(PrecosPostRequest $request, Preco $preco)
    {
        try
        {
            $validated = $request->validated();
            $preco->update($validated);

            return back()
                ->with('message', "Prices successfully updated!")
                ->with('message_type', "message_success");
        }
        catch(Exception $e)
        {
            // WithInput() is used in case request goes through validators without a problem but fails to create user
            return back()->withInput()
                ->with('message', "Error updating prices.")
                ->with('message_type', "message_error");
        }
    }
}
