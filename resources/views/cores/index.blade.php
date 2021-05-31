@extends('layout.template')

@section('content')
    <div id="colours">
        <h1 class="title">Colours</h1>

        @include('layout.partials.return-message')

        <form action="{{ route('cores.store') }}" method="POST" class="colours_new_form">
            @csrf

            <div class="table_form">
                @include('cores.partials.create-edit')
            </div>

            <button class="button_green" type="submit">Add Colour</button>
        </form>

        <div class="colour_list">
        @foreach ($colours as $colour)
            <div class="colour_item">
                <p>
                    <strong>{{ $colour->nome }}:</strong> {{ $colour->codigo }}
                    <span class="colour_showcase" style="background-color:{{$colour->codigo}}"></span>
                </p>
                <div>
                    <a href="{{ route('cores.edit', ['cor' => $colour->codigo])}}" class="href_button button_blue">Edit</a>
                    <form action="{{ route('cores.destroy', ['cor' => $colour->codigo]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button_red">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
        </div>
    </div>
@endsection
