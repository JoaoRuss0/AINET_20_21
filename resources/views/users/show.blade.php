@extends('layout.partials.user-client-show')

@section('title')
    <h1 class="title">User #{{ $user->id }} Profile</h1>
@endsection

@section('profile_info')
    <div class="profile_info">
        @include('users.partials.info')
    </div>
@endsection

@section('button')
    <div>
        <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="href_button button_blue">Edit Profile</a>
    </div>
@endsection
