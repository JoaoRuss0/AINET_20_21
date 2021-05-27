<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Estampa;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EstampaStoreRequest;
use App\Http\Requests\EstampaUpdateRequest;

class EstampaController extends Controller
{
    public function index()
    {
        return view('estampas.index')
            ->with('title',"Catalog")
            ->with('categories', Categoria::all()->sortBy('nome'))
            ->with('stamps', Estampa::all());
    }

    public function show(Estampa $estampa)
    {
        return view('estampas.show')
            ->with('title',"Estampa $estampa->id")
            ->with('stamp', $estampa)
            ->with('category', $estampa->categoria->nome);
    }

    public function filter(Request $request)
    {
        $stamp_querry = Estampa::query();
        $last_filter = [];
        $NO_PARAMETERS = TRUE;

        if(!empty($request->categoria_id))
        {
            $stamp_querry = $stamp_querry->where('categoria_id', $request->categoria_id);
            $last_filter['categoria'] = Categoria::find($request->categoria_id);
            $NO_PARAMETERS = FALSE;
        }

        if(!empty($request->nome))
        {
            $stamp_querry = $stamp_querry->where('nome', 'LIKE', "%$request->nome%");
            $last_filter['nome'] = $request->nome;
            $NO_PARAMETERS = FALSE;
        }

        if(!empty($request->descricao))
        {
            $stamp_querry = $stamp_querry->where('descricao', 'LIKE', "%$request->descricao%");
            $last_filter['descricao'] = $request->descricao;
            $NO_PARAMETERS = FALSE;
        }

        if(!$NO_PARAMETERS)
        {
            $query_result = $stamp_querry->get();
            $last_filter['querry_count'] = $query_result->count();

            return view('estampas.index')
                ->with('title',"Catalog")
                ->with('categories', Categoria::all()->sortBy('nome'))
                ->with('stamps', $query_result)
                ->with('last_filter', $last_filter);
        }

        return view('estampas.index')
            ->with('title',"Catalog")
            ->with('categories', Categoria::all()->sortBy('nome'))
            ->with('stamps', Estampa::all())
            ->with('last_filter', $last_filter);
    }

    public function create()
    {
        return view('estampas.create')
            ->with('title',"Create Stamp")
            ->with('categories', Categoria::all()->sortBy('nome'));
    }

    public function store(EstampaStoreRequest $request)
    {
        try
        {
            $validated = $request->validated();
            $estampa = new Estampa();

            $estampa->fill($validated);

            if($request->hasFile('photo') != null)
            {
                $photo_path = $request->file('photo')->store("public/estampas");
                $estampa->imagem_url = basename($photo_path);
            }

            $estampa->save();

            return redirect()->route('estampas.index')
                ->with('message', "Stamp successfully created!")
                ->with('message_type', "message_success");

        }
        catch(Exception $e)
        {
            // WithInput() is used in case request goes through validators without a problem but fails to create user
            return back()->withInput()
                ->with('message', "Error creating stamp.")
                ->with('message_type', "message_error");
        }
    }

    public function edit(Estampa $estampa)
    {
        return view('estampas.edit')
            ->with('title', "Edit Stamp")
            ->with('categories', Categoria::all()->sortBy('nome'))
            ->with('stamp', $estampa);
    }

    public function update(EstampaUpdateRequest $request, Estampa $estampa)
    {
        try
        {
            $validated = $request->validated();
            $estampa->fill($validated);

            if($request->hasFile('photo') != null)
            {
                Storage::delete("public/estampas/" . $estampa->imagem_url);
                $photo_path = $request->file('photo')->store("public/estampas");
                $estampa->imagem_url = basename($photo_path);
            }

            $estampa->update();

            return back()
                ->with('message', "Stamp successfully updated!")
                ->with('message_type', "message_success");
        }
        catch(Exception $e)
        {
            // WithInput() is used in case request goes through validators without a problem but fails to create user
            return back()->withInput()
                ->with('message', "Error updating stamp.")
                ->with('message_type', "message_error");
        }
    }

    public function destroy(Estampa $estampa)
    {
        try
        {
            $old_id = $estampa->id;
            $estampa->delete();

            return back()
                ->with('message', "Stamp #$old_id successfully deleted!")
                ->with('message_type', "message_success");
        }
        catch (Exception $e)
        {
            return back()
                ->with('message', "Failed to delete stamp #$old_id.")
                ->with('message_type', "message_error");
        }
    }
}
