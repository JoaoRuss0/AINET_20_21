@extends('layout.template')

@section('content')

<div id="catalog">
    <h1 class="title">Catalog</h1>

    <div class="filter">
        <fieldset class="filter_fieldset">
            <legend>Filter</legend>
            <form action="/stamps/filter/" class="filter_form">

                <div class="filter_form_table">
                    <div>
                        <label for="nome">Name:</label>
                        <input type="text" name="nome" placeholder="Search Names" value="{{$last_filter["nome"] ?? ""}}" >
                    </div>

                    <div>
                        <label for="descricao">Description:</label>
                        <input type="text" name="descricao" placeholder="Search Descriptions" value="{{$last_filter["descricao"]  ?? ""}}" >
                    </div>

                    <div>
                        <label for="categoria_id">Category:</label>
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
                    <button type="reset" class="form_button clear_button">Clear</button>
                    <button type="submit" class="form_button">Filter</button>
                </div>

            </form>

            <form action="/stamps/">
                <button type="submit" class="form_button">All</button>
            </form>
        </fieldset>
    </div>

@if (isset($last_filter))
    <div class="filter_search_result">
        <p><strong>Search results for:</strong></p>
        <div>
            <p class="filter_search_parameters">
            @if (isset($last_filter["categoria"]))
                <strong>Category: </strong>{{$last_filter["categoria"]->nome}}
            @endif

            @if (!empty($last_filter["nome"]))
                <strong>Name: </strong>"{{$last_filter["nome"]}}"
            @endif

            @if (!empty($last_filter["descricao"]))
                <strong>Description:</strong> "{{$last_filter["descricao"]}}"
            @endif
            </p>
        </div>
    </div>
@endif

    <div id="stamps_table">
    @foreach ($stamps as $stamp)
        <div class="stamp_card">
            <p class="stamp_name"><strong>{{$stamp->nome}}</strong></p>

            <img class="stamp_image" loading="lazy" src="{{asset("storage/estampas/$stamp->imagem_url")}}" alt="No stamp logo!">

            <p class="stamp_description">
                {{$stamp->descricao}}
            </p>
        </div>
    @endforeach
    </div>
</div>
@endsection
