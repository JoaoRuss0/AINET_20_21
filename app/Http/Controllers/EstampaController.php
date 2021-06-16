<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Estampa;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EstampaStoreRequest;
use App\Http\Requests\EstampaUpdateRequest;

class EstampaController extends Controller
{
    public function index()
    {
        $estampas = Estampa::where('cliente_id', NULL)
        ->orderBy('id')
        ->paginate(30)
        ->onEachSide(2);

        return view('estampas.index')
            ->with('title',"Catalog")
            ->with('categories', Categoria::all()->sortBy('nome'))
            ->with('stamps', $estampas);
    }

    public function indexOwn()
    {
        $estampas = Estampa::where('cliente_id', Auth::user()->id)
        ->orderBy('nome')
        ->paginate(30)
        ->onEachSide(2);

        return view('estampas.indexOwn')
            ->with('title',"My Stamps")
            ->with('categories', Categoria::all()->sortBy('nome'))
            ->with('stamps', $estampas);
    }

    public function show(Estampa $estampa)
    {
        return view('estampas.show')
            ->with('title',"Estampa $estampa->id")
            ->with('stamp', $estampa)
            ->with('category', ($estampa->categoria) ? $estampa->categoria->nome : "No category");
    }

    public function filter(Request $request)
    {
        $stamp_querry = Estampa::query();
        $stamp_querry = $stamp_querry->where('cliente_id', NULL);

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
            $query_result = $stamp_querry
                ->orderBy('id')
                ->paginate(30)
                ->onEachSide(2)
                ->withQueryString();
            $last_filter['querry_count'] = $query_result->count();

            return view('estampas.index')
                ->with('title',"Catalog")
                ->with('categories', Categoria::all()->sortBy('nome'))
                ->with('last_filter', $last_filter)
                ->with('stamps', $query_result);
        }

        return view('estampas.index')
            ->with('title',"Catalog")
            ->with('categories', Categoria::all()->sortBy('nome'))
            ->with('last_filter', $last_filter)
            ->with('stamps', Estampa::where('cliente_id', NULL)
                ->orderBy('id')
                ->paginate(30)
                ->onEachSide(2));
    }

    public function create()
    {
        return view('estampas.create')
            ->with('title',"Create Stamp")
            ->with('categories', Categoria::all()->sortBy('nome'));
    }

    public function createOwn()
    {
        return view('estampas.createOwn')
            ->with('title',"Create Stamp");
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
                if(Auth::user()->tipo == 'C')
                {
                    $photo_path = $request->file('photo')->store("estampas_privadas/");
                }
                else
                {
                    $photo_path = $request->file('photo')->store("public/estampas");
                }
                $estampa->imagem_url = basename($photo_path);
            }

            $estampa->save();

            return redirect()->route((Auth::user()->tipo == 'C') ? 'estampasproprias.indexOwn' : 'estampas.index')
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

    public function editOwn(Estampa $estampa)
    {
        return view('estampas.editOwn')
            ->with('title', "Edit Stamp")
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
                if(Auth::user()->tipo == 'C')
                {
                    Storage::delete("estampas_privadas/" . $estampa->imagem_url);
                    $photo_path = $request->file('photo')->store("estampas_privadas/");
                }
                else
                {
                    Storage::delete("public/estampas/" . $estampa->imagem_url);
                    $photo_path = $request->file('photo')->store("public/estampas");
                }
                $estampa->imagem_url = basename($photo_path);
            }

            $estampa->update();

            return redirect()->route((Auth::user()->tipo == 'C') ? 'estampasproprias.indexOwn' : 'estampas.index')
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

    public function image(Estampa $estampa, $path)
    {
        if (Storage::exists("estampas_privadas/" . $path))
        {
            return response()->file(storage_path("app/estampas_privadas/" . $path));
        }
    }
}
