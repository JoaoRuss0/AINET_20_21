<div>
    <label for="stamp_nome">
        <span class="tooltip">Name
            <span class="tooltiptext_bottom">Can contain any accented upper/lower case letter and spaces with max size of 255 characters.</span>
        </span>
    </label>
    <input type="text" name="nome" id="stamp_nome" pattern="^[a-zA-Z0-9 \u00C0-\u00FF]{1,255}$" value="{{old('nome', $stamp->nome ?? '')}}" required>
</div>

@error('nome')
    @foreach ($errors->get('nome') as $message)
        <div class="form_error_message">
            <label></label>
            <p><strong>{{$message}}</strong></p>
        </div>
    @endforeach
@enderror

<div>
    <label for="stamp_category">Category</label>
    <select type="text" name="categoria_id" id="stamp_category" required>
    @foreach ($categories as $category)
        <option value="{{$category->id}}" {{old('categoria_id', $stamp->categoria_id ?? '') == $category->id ? 'selected' : ''}}>{{$category->nome}}</option>
    @endforeach
    </select>
</div>

@error('bloqueado')
    @foreach ($errors->get('bloqueado') as $message)
        <div class="form_error_message">
            <label></label>
            <p><strong>{{$message}}</strong></p>
        </div>
    @endforeach
@enderror

<div>
    <label for="stamp_description">Description
        <span class="optional_field_indicator">- Optional</span>
    </label>
    <textarea id="stamp_description" name="descricao">{{old('descricao', $stamp->descricao ?? '')}}</textarea>
</div>

@error('descricao')
    @foreach ($errors->get('descricao') as $message)
        <div class="form_error_message">
            <label></label>
            <p><strong>{{$message}}</strong></p>
        </div>
    @endforeach
@enderror
