<div>
    <label for="stamp_photo">Photo
        <span class="optional_field_indicator">- Optional</span>
    </label>
    <input type="file" name="photo" id="stamp_photo">
</div>

@error('photo')
    @foreach ($errors->get('photo') as $message)
        <div class="form_error_message">
            <label></label>
            <p><strong>{{$message}}</strong></p>
        </div>
    @endforeach
@enderror
