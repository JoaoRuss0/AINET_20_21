@extends('layout.template')

@section('content')

<div id="login">
    <h1>Login</h1>
    <p class="{{session('message_type')}}">{{session('message')}}</p>
    <form action="" class="table_form">
        <div>
            <label for="nome">Name: </label>
            <input type="text" name="nome" required>
        </div>

        <div>
            <label for="password">Password: </label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label></label>
            <button type="submit">Sign In</button>
        </div>
    </form>
</div>

@endsection
