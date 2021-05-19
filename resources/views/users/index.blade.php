@extends('layout.template')

@section('content')

<div id="user_list">
    <h1 class="title">User List</h1>

    <div class="filter">
        <fieldset class="filter_fieldset">
            <legend>Filter</legend>
            <form action="/users/filter/" class="filter_form">
                <div class="filter_form_table">
                    <div>
                        <label for="name"><strong>Name:</strong></label>
                        <input type="text" name="name" placeholder="Search Names" value="{{ Request::input('name') ?? '' }}" >
                    </div>

                    <div>
                        <label for="tipo"><strong>Type:</strong></label>
                        <select name="tipo">
                            <option value="">All</option>
                            <option value="A"
                        @if(!empty($last_filter['tipo']) && $last_filter['tipo'] == 'A')
                            selected
                        @endif
                            >Admin</option>
                            <option value="C"
                        @if(!empty($last_filter['tipo']) && $last_filter['tipo'] == 'C')
                            selected
                        @endif
                            >Client</option>
                            <option value="F"
                        @if(!empty($last_filter['tipo']) && $last_filter['tipo'] == 'F')
                            selected
                        @endif
                            >Worker</option>
                        </select>
                    </div>

                    <div>
                        <label for="bloqueado"><strong>Blocked:</strong></label>
                        <select name="bloqueado">
                            <option value=""></option>
                            <option
                        @if(!empty($last_filter['bloqueado']) && $last_filter['bloqueado'] == 'Yes')
                            selected
                        @endif
                            >Yes</option>
                            <option
                        @if(!empty($last_filter['bloqueado']) && $last_filter['bloqueado'] == 'No')
                            selected
                        @endif
                            >No</option>
                        </select>
                    </div>
                </div>

                <div id="form_buttons">
                    <button type="reset" class="form_button clear_button">Clear</button>
                    <button type="submit" class="form_button">Filter</button>
                </div>

            </form>

            <form action="/users/">
                <button type="submit" class="form_button">All</button>
            </form>
        </fieldset>
    </div>

    <div id="list">
    @foreach ($users as $user)
        <div class="list_item">
            <img src="{{asset('storage/fotos/' . $user->foto_url)}}" alt="No user image.">
            <div class="item_info">
                <p><strong>Name: </strong>{{$user->name}}</p>
                <p><strong>Email: </strong>{{$user->email}}</p>
                <p><strong>Type: </strong>
                @switch($user->tipo)
                    @case('A')
                            Administrador
                        @break
                    @case('C')
                            Client
                        @break
                    @case('F')
                            Worker
                        @break
                    @default No type assigned.
                @endswitch
                </p>
                <p><strong>Blocked: </strong>
                @if ($user->bloqueado)
                    Yes
                @else
                    No
                @endif
                </p>
            </div>
        </div>
    @endforeach
    </div>
</div>

@endsection
