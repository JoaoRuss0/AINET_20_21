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
    public function show(Cliente $cliente)
    {
        return view('clientes.show')
            ->with('title',"Users")
            ->with('user', $cliente->user)
            ->with('cliente', $cliente);
    }

    public function create()
    {
        return view('clientes.create')
            ->with('title',"Register now!");
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

            $user->sendEmailVerificationNotification();

            return redirect()->route('login')
                ->with('message', "Client account successfully created!")
                ->with('message_type', "message_success");
        }
        catch(Exception $e)
        {
            DB::rollback();

            // WithInput() is used in case request goes through validators without a problem but fails to create user
            return back()->withInput()
                ->with('message', "Error creating client account.")
                ->with('message_type', "message_error");
        }
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit')
            ->with('title', "Edit Account")
            ->with('cliente', $cliente)
            ->with('user', $cliente->user);
    }

    public function update(ClienteUpdateRequest $request, Cliente $cliente)
    {
        DB::beginTransaction();

        try
        {
            $validated = $request->validated();

            if($request->filled('password'))
            {
                $validated['password'] = Hash::make($request->password);
            }
            else
            {
                $validated['password'] = $cliente->user->password;
            }

            if($request->tipo_pagamento == 'PAYPAL')
            {
                $validated['ref_pagamento'] = $request->email;
            }


            $cliente->user->fill($validated);

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

            return back()
                ->with('message', "Client account updated successfully!")
                ->with('message_type', "message_success");
        }
        catch(Exception $e)
        {
            DB::rollback();

            // WithInput() is used in case request goes through validators without a problem but fails to create user
            return back()->wihtInput()
                ->with('message', "Error updating client account.")
                ->with('message_type', "message_error");
        }
    }

    public function destroy(Cliente $cliente)
    {
        DB::beginTransaction();

        try
        {
            $old_id = $cliente->id;
            $cliente->delete();
            User::destroy($old_id);

            DB::commit();

            return back()
                ->with('message', "User #$old_id successfully deleted!")
                ->with('message_type', "message_success");
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return back()
                ->with('message', "Failed to delete user #$old_id.")
                ->with('message_type', "message_error");
        }
    }
}
