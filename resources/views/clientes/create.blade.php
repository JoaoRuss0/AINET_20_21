@extends('layout.template')

@section('content')

<div id="create_cliente">
    <h1 class="title">Register</h1>
@if($errors->any())
    <p class="message_error">Fields were not filled correctly.</p>
@endif
    @include('layout.partials.return-message')
    <form method="POST" action="{{ route('clientes.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="table_form">
            @include('users.partials.create-edit')
            @include('users.partials.create-edit-password')
            @include('clientes.partials.create-edit')
            <div>
                <label></label>
                <button type="submit" class="button_green">Register</button>
            </div>
        </div>
    </form>
</div>

@endsection
