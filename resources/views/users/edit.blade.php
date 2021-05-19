@extends('layout.template')

@section('content')

<div id="edit">
    <h1>Edit</h1>
    <form method="PUT" action="">
        @csrf
        @method('PUT')
        @include('users.partials.create-edit')
        @include('users.partials.create-edit-newpassword')
        <input type="hidden" name="id" value="{{$user->id}}">
    </form>
</div>

@endsection
