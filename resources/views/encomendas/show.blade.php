@extends('layout.template')

@section('content')

<div id="cart">
    <h1 class="title">Order #{{ $order->id }}</h1>

    <div class="order_show">
        <div>
            @include('encomendas.partials.info')
        </div>
        @foreach ($items as $item)
            <div class="order_show_item">
                <div class="order_show_stamp_image">
                    <img src="{{ asset('storage/estampas/' . $item->stamp_photo ) }}" alt="No stamp image.">
                </div>
                <p><strong>Stamp: </strong>{{ $item->estampa_id }}</p>
                <p><strong>Colour: </strong>{{ $item->cor_codigo }}</p>
                <p><strong>Size: </strong>{{ $item->tamanho }}</p>
                <p><strong>Quantity: </strong>{{ $item->quantidade }}</p>
                <p><strong>Price: </strong>{{ $item->preco_un }} €</p>
                <p><strong>Subtotal: </strong>{{ $item->subtotal }} €</p>
            </div>
        @endforeach
    </div>
</div>

@endsection
