@extends('layout.template')

@section('content')

<div id="user_list">
    <h1 class="title">User List</h1>

    @include('layout.partials.return-message')

    <div class="add_user_div">
        <a class="href_button button_green" href="{{ route('users.create') }}" >Add User</a>
    </div>

    <div class="filter">
        <fieldset class="filter_fieldset">
            <legend>Filter</legend>
            <form action="{{ route('users.filter') }}" class="filter_form">
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
                            <option value="">Any</option>
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

                <div class="form_buttons">
                    <button type="reset" class="form_button button_red clear_button">Clear</button>
                    <button type="submit" class="form_button button_green">Filter</button>
                </div>

            </form>

            <a class="form_button href_button button_black" href="{{ route('users.index') }}">All</a>
        </fieldset>
    </div>

@if (isset($last_filter))
    @if (!empty($last_filter))
        <div class="filter_search_result">
            <p><strong>Found {{ $last_filter["querry_count"] }} results for:</strong></p>
            <div class="filter_search_parameters">
                @if (isset($last_filter["tipo"]))
                    <p><strong>Type: </strong>
                    @switch($last_filter["tipo"])
                        @case("A")
                            Admin
                            @break
                        @case("C")
                            Client
                            @break
                        @case("F")
                            Worker
                            @break
                    @endswitch
                    </p>
                @endif

                @if (!empty($last_filter["name"]))
                    <p><strong>Name: </strong>"{{ (strlen($last_filter["name"]) > 30) ? substr($last_filter["name"], 0, 30) . "..." : $last_filter["name"] }}"</p>
                @endif

                @if (!empty($last_filter["bloqueado"]))
                    <p><strong>Bocked: </strong>{{$last_filter["bloqueado"]}}</p>
                @endif
            </div>
        </div>
    @else
        <div class="filter_search_result">
            <p><strong>Showing everything.</strong></p>
        </div>
    @endif
@endif

    <div id="list">
    @foreach ($users as $user)
        <div class="list_item">
        <!-- Check if user has a photo or not -->
        @if ($user->foto_url)
            <img class="item_photo" src="{{ asset('storage/fotos/' . $user->foto_url) }}" loading="lazy" alt="No user image.">
        @else
            <img class="item_photo" src="" loading="lazy" alt="No user image.">
        @endif
            <div class="item_info">
                @include('users.partials.info')
            </div>
            <div class="item_buttons">
            @can ('view', $user)
                <a href="{{ route('users.show', ['user' => $user->id] ) }}" class="href_button button_black">View</a>
            @endcan
            @can ('update', $user)
                <a href="{{ route('users.edit', ['user' => $user->id] ) }}" class="href_button button_blue">Edit</a>
            @endcan
            @can('block_destroy_type', $user)
                <form action="{{ route('users.block', ['user' => $user->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button
                    @if ($user->bloqueado)
                        class="button_green">Unblock
                    @else
                        class="button_red">Block
                    @endif
                    </button>
                </form>
                <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="button_grey">Delete</button>
                </form>
            @endcan
            </div>
        </div>
    @endforeach
    </div>
    {{ $users->links() }}
</div>

@endsection
