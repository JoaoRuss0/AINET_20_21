@extends('layout.template')

@section('content')

<div id="cart">
    <h1 class="title">Orders</h1>

    @include('layout.partials.return-message')

@if($orders)
    <div class="orders_list">
    @foreach ($orders as $order)
        <div class="orders_item">
            <div class="order_number">
                <strong>Order #{{ $order->id }}</strong>
            </div>
            @include('encomendas.partials.info')
            <div class="order_buttons">
                <a href="{{ route('encomendas.show', ['encomenda' => $order->id]) }}" class="href_button button_black">View</a>
            </div>
        </div>
    @endforeach
        <div class="orders_total">
            <strong>Total Orders: </strong>{{ $orders_count}}
        </div>
    </div>
@else
    <p>You do not have any orders.</p>
@endif

</div>
@endsection
