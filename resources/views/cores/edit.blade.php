@extends('layout.template')

@section('content')
    <div id="colours">
        <h1 class="title">Colours</h1>

        @include('layout.partials.return-message')

        <form action="{{ route('cores.update', ['cor' => $colour->codigo]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="table_form">

                @include('cores.partials.create-edit')

                <div>
                    <label></label>
                    <button class="button_blue" type="submit">Update</button>
                </div>
            </div>
        </form>
    </div>

@endsection
