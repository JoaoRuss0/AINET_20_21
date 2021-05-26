@extends('layout.template')

@section('content')

<div id="email_verify">
    <h1 class="title">Email Verification</h1>

    <div>
        @if (session('resent'))
            <p><strong>A fresh verification link has been sent to your email address.</strong></p>
        @endif
        <p>Before proceeding, please check your email for a verification link.</p>
        <p>If you did not receive the email:</p>
        <form action="{{ route('verification.resend') }}" method="POST" >
            @csrf
            <button type="submit" class="button_black">Click here to request another</button>
        </form>
    </div>
</div>

@endsection
