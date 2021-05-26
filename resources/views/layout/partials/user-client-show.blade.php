@extends('layout.template')

@section('content')

<div id="user_show">

    @yield('title')

    <div class="profile">
        <div class="profile_img">
            @if ($user->foto_url)
                <img src="{{ asset('storage/fotos/' . $user->foto_url) }}" loading="lazy" alt="No user image.">
            @else
                <img src="" loading="lazy" alt="No user image.">
            @endif
        </div>

        @yield('profile_info')

        @yield('button')
    </div>
</div>

@endsection
