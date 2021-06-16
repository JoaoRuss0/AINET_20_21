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
        $clientes = null;
        $datas = null;

        switch ($user->tipo)
        {
            case 'A':
                $orders = Encomenda::orderByDesc('id')->paginate(10)->onEachSide(1);
                $clientes = Encomenda::all('cliente_id')->groupBy(['cliente_id'])->keys();
                $datas = Encomenda::all('data')->groupBy(['data'])->keys();
                break;
            case 'F':
                $orders = Encomenda::where('estado', 'pendente')->orWhere('estado', 'paga')->orderByDesc('id')->paginate(10)->onEachSide(1);
                break;
            case 'C':
                $orders = $user->cliente->encomendas()->orderByDesc('id')->paginate(10)->onEachSide(1);
                break;
        }

        return view('encomendas.index')
            ->with('title', "Orders")
            ->with('orders', $orders)
            ->with('clientes', $clientes)
            ->with('datas', $datas);
    }

    public function filter(Request $request)
    {
        $encomenda_querry = Encomenda::query();
        $last_filter = [];
        $NO_PARAMETERS = TRUE;

        if(!empty($request->cliente))
        {
            $encomenda_querry = $encomenda_querry->where('cliente_id', "$request->cliente");
            $last_filter['cliente'] = $request['cliente'];
            $NO_PARAMETERS = FALSE;
        }

        if(!empty($request->estado))
        {
            $encomenda_querry = $encomenda_querry->where('estado', "$request->estado");
            $last_filter['estado'] = $request['estado'];
            $NO_PARAMETERS = FALSE;
        }

        if(!empty($request->data))
        {
            $encomenda_querry = $encomenda_querry->where('data', $request->data);
            $last_filter['data'] = $request['data'];
            $NO_PARAMETERS = FALSE;
        }

        $clientes = Encomenda::all('cliente_id')->groupBy(['cliente_id'])->keys();
        $datas = Encomenda::all('data')->groupBy(['data'])->keys();

        if(!$NO_PARAMETERS)
        {
            $query_result = $encomenda_querry
                ->orderByDesc('id')
                ->paginate(10)
                ->onEachSide(1)
                ->withQueryString();
            $last_filter['querry_count'] = $query_result->count();

            return view('encomendas.index')
            ->with('title', "Orders")
            ->with('last_filter', $last_filter)
            ->with('orders', $query_result)
            ->with('clientes', $clientes)
            ->with('datas', $datas);
        }

        $orders = Encomenda::orderByDesc('id')->paginate(10)->onEachSide(1);

        return view('encomendas.index')
            ->with('title', "Orders")
            ->with('last_filter', $last_filter)
            ->with('orders', $orders)
            ->with('clientes', $clientes)
            ->with('datas', $datas);
    }

    public function show(Encomenda $encomenda)
    {
        $items = $encomenda->tshirts;

        foreach ($items as $item)
        {
            $stamp = Estampa::withTrashed()->find($item->estampa_id);
            $item->stamp_photo = $stamp->imagem_url;
            $item->cliente_id = $stamp->cliente_id;
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

    public function update(Request $request, Encomenda $encomenda)
    {
        try
        {
            switch($request->estado)
            {
                case 'paga':
                    if($encomenda->estado == 'pendente')
                    {
                        $encomenda->update(['estado' => $request->estado]);
                        break;
                    }
                    throw new Exception();
                    break;
                case 'fechada':
                    if($encomenda->estado == 'paga')
                    {
                        $encomenda->update(['estado' => $request->estado]);
                        break;
                    }
                    throw new Exception();
                    break;
                case 'anulada':
                    if($encomenda->estado == 'pendente' || $encomenda->estado == 'paga')
                    {
                        $encomenda->update(['estado' => $request->estado]);
                        break;
                    }
                    throw new Exception();
                    break;

            }

            return back()
                ->with('message', "Order successfully updated!")
                ->with('message_type', "message_success");
        }
        catch(Exception $e)
        {
            return back()
                ->with('message', "Error updating order to '$request->estado'.")
                ->with('message_type', "message_error");
        }
    }
}
