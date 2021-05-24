<div>
    <label for="user_type">User Type</label>
    <select type="text" name="tipo" id="user_type">
        <option value="A">Administrator</option>
        <option value="F">Worker</option>
    </select>
</div>

@error('tipo')
    @foreach ($errors->get('tipo') as $message)
        <div class="form_error_message">
            <label></label>
            <p><strong>{{$message}}</strong></p>
        </div>
    @endforeach
@enderror

<div>
    <label for="user_blocked">Blocked</label>
    <select type="text" name="bloqueado" id="user_blocked">
        <option value=0>Not Blocked</option>
        <option value=1>Blocked</option>
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
