<div>
    <label for="user_password">
        <span class="tooltip">New Password <span class="tooltiptext_bottom">Max size of 255 characters.</span></span>
    </label>
    <input type="password" name="password" id="user_password">
</div>

@error('password')
    @foreach ($errors->get('password') as $message)
        <div class="form_error_message">
            <label></label>
            <p><strong>{{$message}}</strong></p>
        </div>
    @endforeach
@enderror

<div>
    <label for="user_password_confirmation">New Password Confirmation </label>
    <input type="password" name="password_confirmation" id="user_password_confirmation">
</div>
