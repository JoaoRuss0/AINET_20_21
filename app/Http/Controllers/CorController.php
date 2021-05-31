<?php

namespace App\Http\Controllers;

use Exception;
use Throwable;
use App\Models\Cor;
use App\Http\Requests\CorPostRequest;

class CorController extends Controller
{
    public function index()
    {
        return view('cores.index')
            ->with('title',"Colours")
            ->with('colours', Cor::all()->sortBy('nome'));
    }

    public function store(CorPostRequest $request)
    {
        try
        {
            $validated = $request->validated();
            $cor = new Cor();
            $cor->fill($validated);
            $cor->save();

            return redirect()->route('cores.index')
                ->with('message', "Colour successfully created!")
                ->with('message_type', "message_success");
        }
        catch(\Throwable $th)
        {
            if($th->errorInfo[1] == 1062)
            {
                return back()->withInput()
                    ->with('message', "There is already a colour with colour code '$request->codigo'.")
                    ->with('message_type', "message_error");
            }

            // WithInput() is used in case request goes through validators without a problem but fails to create user
            return back()->withInput()
                ->with('message', "Error creating colour.")
                ->with('message_type', "message_error");
        }
    }

    public function edit(Cor $cor)
    {
        return view('cores.edit')
            ->with('title',"Edit Colour")
            ->with('colour', $cor);
    }

    public function update(CorPostRequest $request, Cor $cor)
    {
        try
        {
            $validated = $request->validated();
            $cor->update($validated);

            return redirect()->route('cores.index')
                ->with('message', "Colour $cor->codigo successfully updated!")
                ->with('message_type', "message_success");
        }
        catch(\Throwable $th)
        {
            if($th->errorInfo[1] == 1451)
            {
                return back()->withInput()
                    ->with('message', "Colour is in use, impossible to update.")
                    ->with('message_type', "message_error");
            }

            // WithInput() is used in case request goes through validators without a problem but fails to create user
            return back()->withInput()
                ->with('message', "Error updating colour $cor->codigo.")
                ->with('message_type', "message_error");
        }
    }

    public function destroy(Cor $cor)
    {
        try
        {
            $old_codigo = $cor->codigo;
            $cor->delete();

            return back()
                ->with('message', "Colour $old_codigo successfully deleted!")
                ->with('message_type', "message_success");
        }
        catch (Exception $e)
        {
            return back()
                ->with('message', "Failed to delete colour $old_codigo.")
                ->with('message_type', "message_error");
        }
    }
}
