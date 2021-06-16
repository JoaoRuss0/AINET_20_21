@extends('layout.template')

@section('content')

<div id="cart">
    <h1 class="title">Orders</h1>

    @include('layout.partials.return-message')

@can('filter', App\Models\Encomenda::class)
    <div class="filter">
        <fieldset class="filter_fieldset">
            <legend>Filter</legend>
            <form action="{{ route('encomendas.filter') }}" class="filter_form">
                <div class="filter_form_table">
                    <div>
                        <label for="estado"><strong>Status:</strong></label>
                        <select name="estado">
                            <option value="">All</option>
                            <option value="pendente"
                        @if(!empty($last_filter['estado']) && $last_filter['estado'] == 'pendente')
                            selected
                        @endif
                            >Pending</option>
                            <option value="paga"
                        @if(!empty($last_filter['estado']) && $last_filter['estado'] == 'paga')
                            selected
                        @endif
                            >Paid</option>
                            <option value="fechada"
                        @if(!empty($last_filter['estado']) && $last_filter['estado'] == 'fechada')
                            selected
                        @endif
                            >Closed</option>
                            <option value="anulada"
                        @if(!empty($last_filter['estado']) && $last_filter['estado'] == 'anulada')
                            selected
                        @endif
                            >Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label for="cliente"><strong>Client:</strong></label>
                        <select name="cliente">
                            <option value="">All</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente }}"
                            @if(!empty($last_filter['cliente']) && $last_filter['cliente'] == $cliente)
                                selected
                            @endif
                            >{{ $cliente }}</option>
                        @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="data"><strong>Date:</strong></label>
                        <select name="data">
                            <option value="">All</option>
                        @foreach ($datas as $data)
                            <option value="{{ $data }}"
                            @if(!empty($last_filter['data']) && $last_filter['data'] == $data)
                                selected
                            @endif
                            >{{ $data }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>

                <div class="form_buttons">
                    <button type="reset" class="form_button button_red clear_button">Clear</button>
                    <button type="submit" class="form_button button_green">Filter</button>
                </div>
            </form>

            <a class="form_button href_button button_black" href="{{ route('encomendas.index') }}">All</a>
        </fieldset>
    </div>

@if (isset($last_filter))
    @if (!empty($last_filter))
        <div class="filter_search_result">
            <p><strong>Found {{ $last_filter["querry_count"] }} results for:</strong></p>
            <div class="filter_search_parameters">
                @if (!empty($last_filter["estado"]))
                    <p><strong>Status: </strong>"{{ $last_filter["estado"] }}"</p>
                @endif

                @if (!empty($last_filter["cliente"]))
                    <p><strong>Client: </strong>"{{ $last_filter["cliente"] }}"</p>
                @endif

                @if (!empty($last_filter["data"]))
                    <p><strong>Date: </strong>"{{ $last_filter["data"] }}"</p>
                @endif
            </div>
        </div>
    @else
        <div class="filter_search_result">
            <p><strong>Showing everything.</strong></p>
        </div>
    @endif
@endif
@endcan

@if($orders && count($orders))
    <div class="orders_list">
    @foreach ($orders as $order)
        <div class="orders_item
        @if(!$loop->last)
            orders_item_border
        @endif
        ">
            <div class="order_number">
                <strong>Order #{{ $order->id }}</strong>
            </div>
            @include('encomendas.partials.info')
            <div class="order_buttons">
                <a href="{{ route('encomendas.show', ['encomenda' => $order->id]) }}" class="href_button button_black">View</a>

            @can('updateF', App\Models\Encomenda::class)
                @if($order->estado == 'pendente')
                    <form action="{{ route('encomendas.updateF', ['encomenda' => $order->id])}}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="paga" name="estado">
                        <button type="submit" class="button_green">Paid</button>
                    </form>
                @elseif($order->estado == 'paga')
                    <form action="{{ route('encomendas.updateF', ['encomenda' => $order->id])}}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="fechada" name="estado">
                        <button type="submit" class="button_blue">Closed</button>
                    </form>
                @endif
            @endcan

            @can('updateA', App\Models\Encomenda::class)
                @if($order->estado != 'fechada' && $order->estado != 'anulada')
                    <form action="{{ route('encomendas.updateA', ['encomenda' => $order->id])}}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="anulada" name="estado">
                        <button type="submit" class="button_red">Cancel</button>
                    </form>
                @endif
            @endcan
            </div>
        </div>
    @endforeach
    </div>
    {{ $orders->links() }}
@else
    <p>No orders to show.</p>
@endif

</div>
@endsection
