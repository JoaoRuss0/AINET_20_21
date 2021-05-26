<div>
    <label for="user_type">User Type</label>
    <select type="text" name="tipo" id="user_type">
        <option value="A" {{old('tipo', $user->tipo ?? '') == 'A' ? 'selected' : ''}}>Administrator</option>
        <option value="F" {{old('tipo', $user->tipo ?? '') == 'F' ? 'selected' : ''}}>Worker</option>
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
        <option value=0 {{old('bloqueado', $user->bloqueado ?? '') == 0 ? 'selected' : ''}}>Not Blocked</option>
        <option value=1 {{old('bloqueado', $user->bloqueado ?? '') == 1 ? 'selected' : ''}}>Blocked</option>
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
