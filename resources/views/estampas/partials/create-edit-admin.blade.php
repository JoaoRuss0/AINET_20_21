<div>
    <label for="stamp_category">Category</label>
    <select type="text" name="categoria_id" id="stamp_category" required>
    @foreach ($categories as $category)
        <option value="{{$category->id}}" {{old('categoria_id', $stamp->categoria_id ?? '') == $category->id ? 'selected' : ''}}>{{$category->nome}}</option>
    @endforeach
    </select>
</div>

@error('categoria_id')
    @foreach ($errors->get('categoria_id') as $message)
        <div class="form_error_message">
            <label></label>
            <p><strong>{{$message}}</strong></p>
        </div>
    @endforeach
@enderror
