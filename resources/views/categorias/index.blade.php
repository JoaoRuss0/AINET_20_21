@extends('layout.template')

@section('content')
    <div id="categories">
        <h1 class="title">Categories</h1>

        @include('layout.partials.return-message')

        <form action="{{ route('categorias.store') }}" method="POST" class="categories_new_form">
            @csrf

            <div>
                <label for="category_nome">
                    <span class="tooltip">Name
                        <span class="tooltiptext_bottom">Can contain any accented upper/lower case letter and spaces with max size of 255 characters.</span>
                    </span>
                </label>
                <input type="text" name="nome" id="category_nome" pattern="^[a-zA-Z0-9 \u00C0-\u00FF]{1,255}$"
                @if(!old('categoria_id'))
                    value="{{old('nome')}}"
                @endif
                required>
            </div>

            @error('nome')
                @if(!old('categoria_id'))
                    @foreach ($errors->get('nome') as $message)
                        <div class="form_error_message">
                            <p><strong>{{$message}}</strong></p>
                        </div>
                    @endforeach
                @endif
            @enderror

            <button class="button_green" type="submit">Add Category</button>
        </form>

        <div class="categories_list">
        @foreach ($categories as $category)
            <div class="category_item">
                <div class="category_item_info">
                    <div class="category_list_name">
                        <p><strong>{{$category->nome}}</strong></p>
                    </div>

                    <form action="{{ route('categorias.update', ['categoria' => $category->id]) }}" method="POST" class="category_update_form">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="category_nome">
                                <span class="tooltip">New Name
                                    <span class="
                                    @if($loop->last)
                                        tooltiptext_top
                                    @else
                                        tooltiptext_bottom
                                    @endif
                                    ">Can contain numbers, any accented upper/lower case letter and spaces with max size of 255 characters.</span>
                                </span>
                            </label>
                            <input type="text" name="nome" id="category_nome" pattern="^[a-zA-Z0-9 \u00C0-\u00FF]{1,255}$"
                            @if(old('categoria_id') == $category->id)
                                value="{{old('nome')}}"
                            @endif
                            required>
                        </div>

                        <input type="hidden" type="text" name="categoria_id" value="{{$category->id}}">

                        <button type="submit" class="button_blue">Update</button>
                    </form>

                    <form action="{{ route('categorias.destroy', ['categoria' => $category->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button_red">Delete</button>
                    </form>
                </div>

                @error('nome')
                    @if(old('categoria_id') == $category->id)
                        @foreach ($errors->get('nome') as $message)
                            <div class="form_error_message">
                                <p><strong>{{$message}}</strong></p>
                            </div>
                        @endforeach
                    @endif
                @enderror
            </div>
        @endforeach
        </div>
    </div>
@endsection
