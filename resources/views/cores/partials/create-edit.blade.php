<div>
    <label for="colour_nome">
        <span class="tooltip">Name
            <span class="tooltiptext_bottom">Can contain any accented upper/lower case letter and spaces with max size of 255 characters.</span>
        </span>
    </label>

    <input type="text" name="nome" id="colour_nome" pattern="^[a-zA-Z \u00C0-\u00FF]{1,255}$" value="{{old('nome', $colour->nome ?? '')}}" required>
</div>

@error('nome')
    @foreach ($errors->get('nome') as $message)
        <div class="form_error_message">
            <p><strong>{{$message}}</strong></p>
        </div>
    @endforeach
@enderror

<div>
    <label for="colour_code">
        <span class="tooltip">Colour Code
            <span class="tooltiptext_bottom">Any css available colour format. Examples: #fff, #000000, white, lightblue, ...</span>
        </span>
    </label>

    <input type="text" name="codigo" id="colour_code" pattern="^[a-zA-Z0-9#]{1,50}$" value="{{old('codigo', $colour->codigo ?? '')}}" required>
</div>

@error('codigo')
    @foreach ($errors->get('codigo', $colour->codigo ?? '') as $message)
        <div class="form_error_message">
            <p><strong>{{$message}}</strong></p>
        </div>
    @endforeach
@enderror
