<div>
    <label for="user_name">
        <span class="tooltip">Name
            <span class="tooltiptext_bottom">Can contain any accented upper/lower case letter and spaces with max size of 255 characters.</span>
        </span>
    </label>
    <input type="text" name="name" id="user_name" pattern="^[a-zA-Z \u00C0-\u00FF]{1,255}$" value="{{old('name', $user->name ?? '')}}" required>
</div>
@error('name')
<div class="form_error_message">
    <label></label>
    <p><strong>{{$message}}</strong></p>
</div>
@enderror
<div>
    <label for="user_email">
        <span class="tooltip">Email <span class="tooltiptext_bottom">Can contain any accented upper/lower case letter. Must be of this format **@**.** with max size of 255 characters.</span></span>
    </label>
    <input type="email" name="email" id="user_email" value="{{old('email', $user->email ?? '')}}" required >
</div>
@error('email')
<div class="form_error_message">
    <label></label>
    <p><strong>{{$message}}</strong></p>
</div>
@enderror
<div>
    <label for="user_photo">Photo
        <span class="optional_field_indicator">- Optional</span>
    </label>
    <input type="file" name="photo" id="user_photo">
</div>
@error('photo')
<div class="form_error_message">
    <label></label>
    <p><strong>{{$message}}</strong></p>
</div>
@enderror
