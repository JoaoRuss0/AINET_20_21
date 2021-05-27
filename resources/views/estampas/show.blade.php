@extends('layout.template')

@section('content')
    <div id="estampa_show">

        <h1 class="title">Stamp #{{ $stamp->id }}</h1>

        <h2 class="category_title">{{$category}}</h2>

        <div class="stamp_profile">
            <div class="stamp_profile_img">
                <img src="{{ asset("storage/estampas/" . $stamp->imagem_url) }}" loading="lazy" alt="Stamp image.">
            </div>

            <div class="stamp_profile_info">
                @include('estampas.partials.info')
            </div>

        @can('update', $stamp)
            <div>
                <a href="{{ route('estampas.edit', ['estampa' => $stamp->id]) }}" class="href_button button_blue">Edit Stamp</a>
            </div>
        @endcan
        </div>
    </div>
@endsection
