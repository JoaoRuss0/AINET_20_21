@extends('layout.template')

@section('content')

<div id="edit_cliente">
    <h1 class="title">Edit</h1>
@if($errors->any())
    <p class="message_error">Fields were not filled correctly.</p>
@endif
    <p class="message {{session('message_type')}}">{{session('message')}}</p>
    <form method="POST" action="{{route('clientes.update', ['cliente' => $cliente->id])}}" enctype="multipart/form-data">
        @csrf
        <div class="table_form">
            @csrf
            @method('PUT')
            @include('users.partials.create-edit')
            @include('users.partials.create-edit-newpassword')
            @include('clientes.partials.create-edit')
            <input type="hidden" name="id" value="{{$user->id}}">

            <div>
                <label></label>
                <button type="submit">Update</button>
            </div>
        </div>
    </form>
</div>

@endsection
