@extends('layout.template')

@section('content')

<div id="register">
    <h1>Register</h1>
@if($errors->any())
    <p class="message_error">Fields were not filled correctly.</p>
@endif
    <p class="message {{session('message_type')}}">{{session('message')}}</p>
    <form method="POST" action="{{route('clientes.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="table_form">
            @csrf
            @include('users.partials.create-edit')
            @include('clientes.partials.create-edit')
            <div>
                <label></label>
                <button type="submit">Submit</button>
            </div>
        </div>
    </form>
</div>

@endsection
