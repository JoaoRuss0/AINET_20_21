@extends('layout.template')

@section('content')

<div id="order">
    <h1 class="title">Order #{{ $order->id }}</h1>

    <div class="order_show">
        <div>
            @include('encomendas.partials.info')
        </div>
        @foreach ($items as $item)
            <div class="order_show_item">
                <div class="order_show_stamp_image">
                @if($item->cliente_id == null)
                    <img src="{{ asset("storage/estampas/" . $item->stamp_photo) }}" alt="No stamp image" loading="lazy">
                @else
                    <img src="{{ route('estampasproprias.image', ['path' => $item->stamp_photo, 'estampa' => App\Models\Estampa::withTrashed()->find($item->estampa_id)]) }}" loading="lazy" alt="No stamp logo!">
                @endif
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
