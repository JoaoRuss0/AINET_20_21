@extends('layout.template')

@section('content')

<div id="edit_stamp">
    <h1 class="title">Editing Stamp #{{$stamp->id}}</h1>
@if($errors->any())
    <p class="message_error">Fields were not filled correctly.</p>
@endif
    @include('layout.partials.return-message')
    <form method="POST" action="{{route('estampas.update', ['estampa' => $stamp->id])}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="table_form">
            @include('estampas.partials.create-edit')
            @include('estampas.partials.edit-photo')
            <input type="hidden" name="cliente_id" value="{{ Auth::user()->cliente->id }}">
            <div>
                <label></label>
                <button type="submit" class="button_blue">Update</button>
            </div>
        </div>
    </form>
</div>

@endsection
