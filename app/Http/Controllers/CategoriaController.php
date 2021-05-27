<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\CategoriaPostRequest;
use Exception;

class CategoriaController extends Controller
{
    public function index()
    {
        return view('categorias.index')
            ->with('title',"Categories")
            ->with('categories', Categoria::all()->sortBy('nome'));
    }

    public function store(CategoriaPostRequest $request)
    {
        try
        {
            $validated = $request->validated();
            $categoria = new Categoria();
            $categoria->fill($validated);
            $categoria->save();

            return redirect()->route('categorias.index')
                ->with('message', "Category successfully created!")
                ->with('message_type', "message_success");

        }
        catch(Exception $e)
        {
            // WithInput() is used in case request goes through validators without a problem but fails to create user
            return back()->withInput()
                ->with('message', "Error creating category.")
                ->with('message_type', "message_error");
        }
    }

    public function update(CategoriaPostRequest $request, Categoria $categoria)
    {
        try
        {
            $validated = $request->validated();
            $categoria->update($validated);

            return redirect()->route('categorias.index')
                ->with('message', "Category #$categoria->id successfully updated!")
                ->with('message_type', "message_success");

        }
        catch(Exception $e)
        {
            // WithInput() is used in case request goes through validators without a problem but fails to create user
            return back()->withInput()
                ->with('message', "Error updating category #$categoria->id.")
                ->with('message_type', "message_error");
        }
    }

    public function destroy(Categoria $categoria)
    {
        if($categoria->estampas_not_trashed->count() > 0)
        {
            return back()
                ->with('message', "Failed to delete category #$categoria->id. There are still associated stamps.")
                ->with('message_type', "message_error");
        }

        try
        {
            $old_id = $categoria->id;
            $categoria->delete();

            return back()
                ->with('message', "Category #$old_id successfully deleted!")
                ->with('message_type', "message_success");
        }
        catch (Exception $e)
        {
            return back()
                ->with('message', "Failed to delete category #$old_id.")
                ->with('message_type', "message_error");
        }
    }
}
