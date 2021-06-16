@extends('layout.template')

@section('content')

<div id="cart_add">
    <h1 class="title">Add Item #{{$stamp->id}}</h1>

    @include('layout.partials.return-message')

    <div>
        <div class="stamp_profile_img">
            @if($stamp->cliente_id == null)
                <img src="{{ asset("storage/estampas/" . $stamp->imagem_url) }}" loading="lazy" alt="Stamp image.">
            @else
                <img src="{{ route('estampasproprias.image', ['path' => "$stamp->imagem_url", 'estampa' => $stamp]) }}" loading="lazy" alt="No stamp logo!">
            @endif
        </div>

        <form action="{{ route('cart.store') }}" method="POST">
            @csrf

            <div class="table_form">

                <div>
                    <label for="cart_tshirt_size">Tshirt Size </label>
                    <select type="text" name="size" id="cart_tshirt_size" required>
                        @foreach ($sizes as $size)
                        <option
                        {{ old('size') == $size ? 'selected' : '' }}
                        >{{ $size }}</option>
                    @endforeach
                    </select>
                </div>

                @error('size')
                    @foreach ($errors->get('size') as $message)
                        <div class="form_error_message">
                            <label></label>
                            <p><strong>{{$message}}</strong></p>
                        </div>
                    @endforeach
                @enderror

                <div>
                    <label for="cart_colour_code">Colour </label>
                    <select type="text" name="colour_code" id="cart_colour_code" required>
                    @foreach ($colours as $colour)
                        <option value="{{ $colour->codigo }}"
                        {{ old('colour_code') == $colour->codigo ? 'selected' : '' }}
                        >{{ $colour->nome }}</option>
                    @endforeach
                    </select>
                </div>

                @error('colour_code')
                    @foreach ($errors->get('colour_code') as $message)
                        <div class="form_error_message">
                            <label></label>
                            <p><strong>{{$message}}</strong></p>
                        </div>
                    @endforeach
                @enderror

                <div>
                    <label for="cart_item_quantity">Quantity </label>
                    <input type="number" min="1" steps=1 name="quantity" id="cart_item_quantity" required value="{{ old('quantity', 1)}}">
                </div>

                @error('quantity')
                    @foreach ($errors->get('quantity') as $message)
                        <div class="form_error_message">
                            <label></label>
                            <p><strong>{{$message}}</strong></p>
                        </div>
                    @endforeach
                @enderror

                <input type="hidden" name="stamp_id" value="{{ $stamp->id }}">

                <div>
                    <label></label>
                    <button type="submit" class="button_green">Add</button>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection
