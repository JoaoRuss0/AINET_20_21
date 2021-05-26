@extends('layout.partials.user-client-show')

@section('title')
    <h1 class="title">Profile</h1>
@endsection

@section('profile_info')
    <div class="profile_info">
        @include('clientes.partials.info')
    </div>
@endsection

@section('button')
    <div>
        <a href="{{ route('clientes.edit', ['cliente' => $cliente->id]) }}" class="href_button button_blue">Edit Profile</a>
    </div>
@endsection
