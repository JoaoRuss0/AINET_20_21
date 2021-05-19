<div>
    <label for="user_password">
        <span class="tooltip">Password <span class="tooltiptext">Max size of 255 characters.</span></span>
    </label>
    <input type="password" name="password" id="user_password" required>
</div>
@error('password')
<div class="form_error_message">
    <label></label>
    <p><strong>{{$message}}</strong></p>
</div>
@enderror
<div>
    <label for="user_password_confirmation">Password Confirmation </label>
    <input type="password" name="password_confirmation" id="user_password_confirmation" required>
</div>
