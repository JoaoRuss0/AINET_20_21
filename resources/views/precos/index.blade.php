@extends('layout.template')

@section('content')

<div id="prices">
    <h1 class="title">Prices</h1>

    @include('layout.partials.return-message')

    <div class="price_table">
        <div>
            <div><strong>Catalog Stamp</strong></div>
            <div>{{$prices->preco_un_catalogo}}€</div>
        </div>
        <div>
            <div><strong>Own Stamp</strong></div>
            <div>{{$prices->preco_un_proprio}}€</div>
        </div>
        <div>
            <div><strong>Catalog Stamp Discount</strong></div>
            <div>{{$prices->preco_un_catalogo_desconto}}€</div>
        </div>
        <div>
            <div><strong>Own Stamp Discount</strong></div>
            <div>{{$prices->preco_un_proprio_desconto}}€</div>
        </div>
        <div>
            <div><strong>Quantity needed for Discount</strong></div>
            <div>{{$prices->quantidade_desconto}}</div>
        </div>
    </div>

@can('update', $prices)
    <form action="{{ route('precos.update', ['preco' => $prices->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="price_table_admin">
            <div>
                <div><strong>Catalog Stamp</strong></div>
                <input name="preco_un_catalogo" type="number" step=".01" value="{{ old('preco_un_catalogo', $prices->preco_un_catalogo) }}" required> €

                @error('preco_un_catalogo')
                    @foreach ($errors->get('preco_un_catalogo') as $message)
                        <div class="form_error_message">
                            <label></label>
                            <p><strong>{{$message}}</strong></p>
                        </div>
                    @endforeach
                @enderror
            </div>
            <div>
                <div><strong>Own Stamp</strong></div>
                <input name="preco_un_proprio" type="number" step=".01" value="{{ old('preco_un_proprio', $prices->preco_un_proprio) }}" required> €

                @error('preco_un_proprio')
                    @foreach ($errors->get('preco_un_proprio') as $message)
                        <div class="form_error_message">
                            <label></label>
                            <p><strong>{{$message}}</strong></p>
                        </div>
                    @endforeach
                @enderror
            </div>
            <div>
                <div><strong>Catalog Stamp Discount</strong></div>
                <input name="preco_un_catalogo_desconto" type="number" step=".01" value="{{ old('preco_un_catalogo_desconto', $prices->preco_un_catalogo_desconto) }}" required> €

                @error('preco_un_catalogo_desconto')
                    @foreach ($errors->get('preco_un_catalogo_desconto') as $message)
                        <div class="form_error_message">
                            <label></label>
                            <p><strong>{{$message}}</strong></p>
                        </div>
                    @endforeach
                @enderror
            </div>
            <div>
                <div><strong>Own Stamp Discount</strong></div>
                <input name="preco_un_proprio_desconto" type="number" step=".01" value="{{ old('preco_un_proprio_desconto', $prices->preco_un_proprio_desconto) }}" required> €

                @error('preco_un_proprio_desconto')
                    @foreach ($errors->get('preco_un_proprio_desconto') as $message)
                        <div class="form_error_message">
                            <label></label>
                            <p><strong>{{$message}}</strong></p>
                        </div>
                    @endforeach
                @enderror
            </div>
            <div>
                <div><strong>Quantity needed for Discount</strong></div>
                <input name="quantidade_desconto" type="number" value="{{ old('quantidade_desconto', $prices->quantidade_desconto) }}" required>

                @error('quantidade_desconto')
                    @foreach ($errors->get('quantidade_desconto') as $message)
                        <div class="form_error_message">
                            <label></label>
                            <p><strong>{{$message}}</strong></p>
                        </div>
                    @endforeach
                @enderror
            </div>
            <button type="submit" class="button_blue">Update Prices</button>
        </div>
    </form>
@endcan
</div>

@endsection
