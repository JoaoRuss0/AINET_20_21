<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Estampa;
use Illuminate\Http\Request;

class EstampaController extends Controller
{
    public function index()
    {
        return view('stamps.index')
            ->with("title","Catalog")
            ->with("categories", Categoria::all()->sortBy('nome'))
            ->with("stamps", Estampa::all());
    }

    public function filter(Request $request)
    {
        $stamp_querry = Estampa::query();
        $last_filter = [];

        if(!empty($request->categoria_id))
        {
            $stamp_querry = $stamp_querry->where('categoria_id', $request->categoria_id);
            $last_filter["categoria"] = Categoria::find($request->categoria_id);
        }

        if(!empty($request->nome))
        {
            $stamp_querry = $stamp_querry->where('nome', 'LIKE', "%$request->nome%");
            $last_filter["nome"] = $request->nome;
        }

        if(!empty($request->descricao))
        {
            $stamp_querry = $stamp_querry->where('descricao', 'LIKE', "%$request->descricao%");
            $last_filter["descricao"] = $request->descricao;
        }

        return view('stamps.index')
            ->with("title","Catalog")
            ->with("categories", Categoria::all()->sortBy('nome'))
            ->with("stamps", $stamp_querry->get())
            ->with("last_filter", $last_filter);
    }
}
