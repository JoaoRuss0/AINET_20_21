@extends('layout.template')

@section('content')

<div id="mystamps">
    <h1 class="title">My Stamps</h1>

    @include('layout.partials.return-message')

@can('create', App\Models\Estampa::class)
    <div class="add_stamp_div">
        <a class="href_button button_green" href="{{ route('estampasproprias.create') }}" >Add Stamp</a>
    </div>
@endcan

@if($stamps && count($stamps))
    <div id="stamps_table">
    @foreach ($stamps as $stamp)
        <div class="stamp_card">
            <p class="stamp_name"><strong>{{$stamp->nome}}</strong></p>

            <div class="stamp_image">
                <img src="{{ route('estampasproprias.image', ['path' => "$stamp->imagem_url", 'estampa' => $stamp]) }}" loading="lazy" alt="No stamp logo!">
            </div>
            <p class="stamp_description">
                {{$stamp->descricao}}
            </p>

            <div class="stamp_buttons">
            @can('view', $stamp)
                @auth
                    <a href="{{ route('estampas.show', ['estampa' => $stamp->id]) }}" class="href_button button_black">View</a>
                @else
                    <a href="{{ route('estampas.guest.show', ['estampa' => $stamp->id]) }}" class="href_button button_black">View</a>
                @endauth
            @endcan

            @can(['update', 'delete'], $stamp)
                <a href="{{ route('estampasproprias.edit', ['estampa' => $stamp->id]) }}" class="href_button button_blue">Edit</a>
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
@else
    <p>No stamps to show.</p>
@endif
@endsection
