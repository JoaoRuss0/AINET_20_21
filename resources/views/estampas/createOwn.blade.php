@extends('layout.template')

@section('content')

<div id="create_stamp">
    <h1 class="title">New Stamp</h1>
@if($errors->any())
    <p class="message_error">Fields were not filled correctly.</p>
@endif
    @include('layout.partials.return-message')
    <form method="POST" action="{{ route('estampas.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="table_form">
            @include('estampas.partials.create-edit')
            @include('estampas.partials.create-photo')
            <input type="hidden" name="cliente_id" value="{{ Auth::user()->cliente->id }}">
            <div>
                <label></label>
                <button type="submit" class="button_green">Create</button>
            </div>
        </div>
    </form>
</div>
@endsection
