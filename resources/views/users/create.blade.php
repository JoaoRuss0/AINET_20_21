@extends('layout.template')

@section('content')

<div id="create_user">
    <h1 class="title">Create User</h1>
@if($errors->any())
    <p class="message_error">Fields were not filled correctly.</p>
@endif
    <p class="message {{session('message_type')}}">{{session('message')}}</p>
    <form method="POST" action="{{route('users.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="table_form">
            @csrf
            @include('users.partials.create-edit')
            @include('users.partials.create-edit-password')
            @include('users.partials.create-edit-admin')

            <div>
                <label></label>
                <button type="submit" class="button_green">Create</button>
            </div>
        </div>
    </form>
</div>

@endsection
