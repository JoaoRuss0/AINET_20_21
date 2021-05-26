@extends('layout.template')

@section('content')

<div id="edit_user">
    <h1 class="title">Editing {{ (($user->tipo == 'A') ? "Admin" : "Worker" ) . " #" . $user->id }}</h1>
@if($errors->any())
    <p class="message_error">Fields were not filled correctly.</p>
@endif
    @include('layout.partials.return-message')
    <form method="POST" action="{{route('users.update', ['user' => $user->id])}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="table_form">
            @include('users.partials.create-edit')
            @include('users.partials.create-edit-newpassword')
            @can('block_destroy_type', $user)
                @include('users.partials.create-edit-admin')
            @endcan
            <input type="hidden" name="id" value="{{$user->id}}">

            <div>
                <label></label>
                <button type="submit" class="button_blue">Update</button>
            </div>
        </div>
    </form>
</div>

@endsection
