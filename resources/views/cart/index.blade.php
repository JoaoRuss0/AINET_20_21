@extends('layout.template')

@section('content')

<div id="cart">
    <h1 class="title">Shopping Cart</h1>

    @include('layout.partials.return-message')


@if($cart && $cart->items)
    <div class="cart">
        <div class="cart_list">
        @foreach ($cart->items as $key => $item)
            <div class="cart_item cart_item_border">

                <div class="cart_item_image">
                    <img src="{{ asset("storage/estampas/" . $item['stamp_photo']) }}" alt="No stamp image" loading="lazy">
                </div>

                <div>
                    <p><strong>Stamp Name: </strong>{{ $item['stamp_name'] }}</p>
                    <p>
                        <span>
                            <strong>Colour:</strong> {{ $item['colour_name'] }}
                        </span>
                        <span class="colour_showcase" style="background-color:{{$item['colour_code']}}"></span>
                    </p>
                    <p><strong>Size: </strong>{{ $item['size'] }}</p>
                </div>
                <div>
                    <p><strong>Subtotal: </strong>{{ number_format($item['subtotal'], 2) }} €</p>
                    <p><strong>Quantity: </strong>{{ $item['qty'] }}</p>
                </div>

                <div class="cart_item_buttons">
                    <form action="{{ route('cart.update', ['id' => $key]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input value="i" type="hidden" name="action">
                        <button type="submit" class="button_green">Increase</button>
                    </form>
                    <form action="{{ route('cart.update', ['id' => $key]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input value="d" type="hidden" name="action">
                        <button type="submit" class="button_blue">Decrease</button>
                    </form>
                    <form action="{{ route('cart.remove', ['id' => $key]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input value="r" type="hidden" name="action">
                        <button type="submit" class="button_red">Remove</button>
                    </form>
                </div>

            </div>
        @endforeach
            <div class="cart_totals">
                <p><strong>Total: </strong>{{ number_format($cart->total_price, 2) }} €</p>
                <p><strong>Quantity: </strong>{{ $cart->total_qty }}</p>
            </div>
        </div>

        <form action="{{ route('cart.destroy') }}" method="POST" id="cart_clear">
            @csrf
            @method('DELETE')
            <button class="button_red">Empty Cart</button>
        </form>
    </div>
@else
    <p class="cart_empty_p">No items were added to the shopping cart!</p>
@endif
    </div>
</div>

@endsection
