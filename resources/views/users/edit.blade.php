@extends('layout.template')

@section('content')

<div id="edit">
    <h1>Edit</h1>
    <form method="PUT" action=""><!--\{\{route('users.update')\}\}-->
        @csrf
        @include('users.partials.create-edit')
    </form>
</div>

@endsection
