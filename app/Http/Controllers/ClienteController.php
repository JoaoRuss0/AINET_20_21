<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ClienteStoreRequest;
use App\Http\Requests\ClienteUpdateRequest;

class ClienteController extends Controller
{
    public function create()
    {
        return view('clientes.create')->with('title',"Register now!");
    }

    public function store(ClienteStoreRequest $request)
    {
        DB::beginTransaction();

        try
        {
            $validated = $request->validated();

            if($request->tipo_pagamento == "PAYPAL")
            {
                $validated['ref_pagamento'] = $request->email;
            }


            $user = new User();
            $user->fill($validated);
            $user->save();

            $cliente = new Cliente();
            $cliente->fill($validated);
            $cliente->id = $user->id;
            $cliente->save();

            if($request->hasFile('photo') != null)
            {
                $photo_path = $request->file('photo')->store("public/fotos");
                $user->foto_url= basename($photo_path);
            }

            $user->password = Hash::make($user->password);
            $user->tipo = 'C';
            $user->bloqueado = 0;
            $user->update();

            DB::commit();

            return redirect()->route('login')
                ->with('message', "Client account created successfully!")
                ->with('message_type', "message_success");
        }
        catch(Exception $e)
        {
            DB::rollback();

            return back()->withInput()
                ->with('message', "Error creating client account.")
                ->with('message_type', "message_error");
        }
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit')
            ->with('title', "Edit account")
            ->with('cliente', $cliente)
            ->with('user', $cliente->user);
    }

    public function update(ClienteUpdateRequest $request, Cliente $cliente)
    {
        DB::beginTransaction();

        try
        {
            $validated = $request->validated();

            if($request->password == NULL)
            {
                $validated['password'] = $cliente->user->password;
            }
            else
            {
                $validated['password'] = Hash::make($request->password);
            }

            if($request->tipo_pagamento == 'PAYPAL')
            {
                $validated['ref_pagamento'] = $request->email;
            }


            $cliente->user->fill($validated);
            $cliente->user->update();

            $cliente->fill($validated);
            $cliente->update();

            if($request->hasFile('photo') != null)
            {
                Storage::delete("public/fotos/" . $cliente->user->foto_url);
                $photo_path = $request->file('photo')->store('public/fotos');
                $cliente->user->foto_url= basename($photo_path);
            }

            $cliente->user->update();

            DB::commit();

            return redirect()->route('login')
                ->with('message', "Client account created successfully!")
                ->with('message_type', "message_success");
        }
        catch(Exception $e)
        {
            DB::rollback();

            return back()->withInput()
                ->with('message', "Error creating client account.")
                ->with('message_type', "message_error");
        }
    }
}
