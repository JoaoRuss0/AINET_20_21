@extends('layout.template')

@section('content')

<div id="catalog">
    <h1 class="title">Catalog</h1>

    @include('layout.partials.return-message')

@can('create', App\Models\Estampa::class)
    <div class="add_stamp_div">
        <a class="href_button button_green" href="{{ route('estampas.create') }}" >Add Stamp</a>
    </div>
@endcan

    <div class="filter">
        <fieldset class="filter_fieldset">
            <legend>Filter</legend>
            <form action="
            @auth
                {{ route('estampas.filter') }}
            @else
                {{ route('estampas.guest.filter') }}
            @endauth
            " class="filter_form">

                <div class="filter_form_table">
                    <div>
                        <label for="nome"><strong>Name:</strong></label>
                        <input type="text" name="nome" placeholder="Search Names" value="{{$last_filter["nome"] ?? ""}}" >
                    </div>

                    <div>
                        <label for="descricao"><strong>Description:</strong></label>
                        <input type="text" name="descricao" placeholder="Search Descriptions" value="{{$last_filter["descricao"]  ?? ""}}" >
                    </div>

                    <div>
                        <label for="categoria_id"><strong>Category:</strong></label>
                        <select name="categoria_id">
                            <option value="">All</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}"
                            @if (!empty($last_filter["categoria"]->id) && $category->id == $last_filter["categoria"]->id)
                                selected
                            @endif
                            >{{$category->nome}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>

                <div class="form_buttons">
                    <button type="reset" class="form_button button_red clear_button">Clear</button>
                    <button type="submit" class="form_button button_green">Filter</button>
                </div>

            </form>

            <a class="form_button href_button button_black" href="{{ route('estampas.index') }}">All</a>
        </fieldset>
    </div>

@if (isset($last_filter))
    @if (!empty($last_filter))
        <div class="filter_search_result">
            <p><strong>Found {{ $last_filter["querry_count"] }} results for:</strong></p>
            <div class="filter_search_parameters">
                <p class="filter_search_parameters">
                @if (isset($last_filter["categoria"]))
                    <p><strong>Category: </strong>{{ $last_filter["categoria"]->nome }}</p>
                @endif

                @if (!empty($last_filter["nome"]))
                    <p><strong>Name: </strong>"{{ (strlen($last_filter["nome"]) > 30) ? substr($last_filter["nome"], 0, 30) . "..." : $last_filter["nome"] }}"</p>
                @endif

                @if (!empty($last_filter["descricao"]))
                    <p><strong>Description: </strong>"{{ (strlen($last_filter["descricao"]) > 30) ? substr($last_filter["descricao"], 0, 30) . "..." : $last_filter["descricao"] }}"</p>
                @endif
            </div>
        </div>
    @else
        <div class="filter_search_result">
            <p><strong>Showing everything.</strong></p>
        </div>
    @endif
@endif

    <div id="stamps_table">
    @foreach ($stamps as $stamp)
        <div class="stamp_card">
            <p class="stamp_name"><strong>{{$stamp->nome}}</strong></p>

            <div class="stamp_image">
                <img src="{{ asset("storage/estampas/$stamp->imagem_url") }}" loading="lazy" alt="No stamp logo!">
            </div>
            <p class="stamp_description">
                {{$stamp->descricao}}
            </p>

            <div class="stamp_buttons">
            @auth
                <a href="{{ route('estampas.show', ['estampa' => $stamp->id]) }}" class="href_button button_black">View</a>
            @else
                <a href="{{ route('estampas.guest.show', ['estampa' => $stamp->id]) }}" class="href_button button_black">View</a>
            @endauth
            @can(['update', 'delete'], $stamp)
                <a href="{{ route('estampas.edit', ['estampa' => $stamp->id]) }}" class="href_button button_blue">Edit</a>
                <form action="{{ route('estampas.destroy', ['estampa' => $stamp->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="button_red">Delete</button>
                </form>
            @endcan
            @can('view', App\Models\Cart::class)
                <a href="{{ route('cart.add', ['estampa' => $stamp->id]) }}" class="href_button button_green">Add to Cart</a>
            @endcan
            </div>
        </div>
    @endforeach
    </div>
    {{ $stamps->links() }}
</div>
@endsection
