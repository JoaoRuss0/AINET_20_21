@extends('layout.template')

@section('content')

<div id="welcome">
    <h1>Welcome to your favourite shirt shop!</h1>

    <a id="welcome_link" href="{{ route('estampas.index') }}">
        <img id="arrow_right" src="{{ asset('img/arrow_right.gif') }}" alt="">
        <div>Enter <strong>MagicShirts</strong></div>
    </a>
</div>

@endsection
