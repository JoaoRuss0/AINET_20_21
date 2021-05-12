<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cliente;
use App\Http\Requests\ClienteStoreRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
{
    public function create()
    {
        return view('clientes.create')->with("title","Register now!");
    }

    public function store(ClienteStoreRequest $request)
    {
        try
        {
            $user = new User();
            $cliente = new Cliente();

            $validated = $request->validated();

            $user->fill($validated);
            $cliente->fill($validated);

            DB::beginTransaction();

            $user->save();
            $cliente->id = $user->id;
            $cliente->save();

            if($request->hasFile('photo') != null)
            {
                $photo_path = $request->file('photo')->store('public/fotos');
                $old_name = explode("/", $photo_path);
                $new_name =  $old_name[0] . "/" . $old_name[1] . "/" . $user->id . "_" . $old_name[2];
                Storage::move($photo_path, $new_name);
                $user->foto_url= $user->id . "_" . $old_name[2];
            }

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
}
