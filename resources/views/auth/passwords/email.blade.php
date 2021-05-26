@extends('layout.template')

@section('content')

<div id="password_reset_email">
    <h1 class="title">Reset Password</h1>

    @if (session('status'))
        <div class="email_sent">
            <strong>{{ session('status') }}</strong>
        </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="table_form">
            <div>
                <label for="email">Email </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
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
                <label></label>
                <button type="submit" class="button_black">Send Password Reset Link</button>
            </div>
        </div>
    </form>
</div>
@endsection
