<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Encomenda;
use App\Models\Estampa;
use App\Models\Tshirt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EncomendaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        switch ($user->tipo)
        {
            case 'A':
                $orders = Encomenda::all()->sortByDesc('id');
                break;
            case 'F':
                $orders = Encomenda::where('estado', 'pendente')->orWhere('estado', 'pagas')->get();
                break;
            case 'C':
                $orders = $user->cliente->encomendas;
                break;
        }

        return view('encomendas.index')
            ->with('title', "Orders")
            ->with('orders', $orders)
            ->with('orders_count', $orders->count());
    }

    public function show(Encomenda $encomenda)
    {
        $items = $encomenda->tshirts;

        foreach ($items as $item)
        {
            $item->stamp_photo = Estampa::withTrashed()->find($item->estampa_id)->imagem_url;
        }

        return view('encomendas.show')
            ->with('title', "Order #$encomenda->id")
            ->with('order', $encomenda)
            ->with('items', $items);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try
        {
            $cliente = Auth::user()->cliente;

            if(!$cliente->nif || !$cliente->tipo_pagamento || !$cliente->ref_pagamento || !$cliente->endereco)
            {
                DB::rollback();

                // WithInput() is used in case request goes through validators without a problem but fails to create user
                return back()->withInput()
                    ->with('message', "Error, be sure your profile contains payment information, address and nif.")
                    ->with('message_type', "message_error");
            }

            $encomenda = new Encomenda();

            $encomenda['estado'] = "pendente";
            $encomenda['data'] = Carbon::now();
            $encomenda['cliente_id'] = $cliente->id;
            $encomenda['nif'] = $cliente->nif;
            $encomenda['tipo_pagamento'] = $cliente->tipo_pagamento;
            $encomenda['ref_pagamento'] = $cliente->ref_pagamento;
            $encomenda['endereco'] = $cliente->endereco;
            $encomenda['notas'] = $request->notas;

            $cart = session('cart');
            $encomenda['preco_total'] = $cart->total_price;

            $encomenda->save();

            foreach ($cart->items as $key => $value)
            {
                $tshirt = new Tshirt();

                $tshirt->encomenda_id = $encomenda->id;
                $tshirt->fill($value);
                $tshirt->save();
            }

            //clear cart
            session()->forget('cart');

            DB::commit();

            return back()
                ->with('message', "Order successfully created!")
                ->with('message_type', "message_success");
        }
        catch(Exception $e)
        {
            DB::rollback();

            // WithInput() is used in case request goes through validators without a problem but fails to create user
            return back()->withInput()
                ->with('message', "Error creating Order.")
                ->with('message_type', "message_error");
        }
    }
}
