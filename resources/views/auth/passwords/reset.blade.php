@extends('layout.template')

@section('content')

<div id="password_reset">
    <h1 class="title">Reset Password</h1>

    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <div class="table_form">
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email">Email </label>
                <input type="email" name="email" id="email" value="{{$email ?? old('email')}}" required>
            </div>

            @error('email')
                @foreach ($errors->get('email') as $message)
                    <div class="form_error_message">
                        <label></label>
                        <p><strong>{{$message}}</strong></p>
                    </div>
                @endforeach
            @enderror

            <div>
                <label for="password">Password </label>
                <input id="password" type="password" name="password" required>
            </div>

            @error('password')
                @foreach ($errors->get('password') as $message)
                    <div class="form_error_message">
                        <label></label>
                        <p><strong>{{$message}}</strong></p>
                    </div>
                @endforeach
            @enderror

            <div>
                <label for="password_confirmation">Password Confirmation </label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>

            <div>
                <label></label>
                <button type="submit" class="button_black">Reset Password</button>
            </div>
            </div>
        </div>
    </form>
</div>
@endsection
