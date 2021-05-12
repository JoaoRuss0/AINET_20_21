<div>
    <label for="client_nif">
        <span class="tooltip">NIF
            <span class="tooltiptext">A sequence of 9 digits.</span>
        </span>
        <span class="optional_field_indicator"> - Optional</span>
    </label>
    <input type="text" name="nif" id="client_nif" pattern="^\d{9}$" value="{{old('nif') ?? ''}}">
</div>
@error('nif')
<div class="form_error_message">
    <label></label>
    <p><strong>{{$message}}</strong></p>
</div>
@enderror
<div>
    <label for="client_address">Address
        <span class="optional_field_indicator">- Optional</span>
    </label>
    <!--<input type="text" name="endereco" id="client_address">-->
    <textarea id="client_address" name="endereco">{{old('endereco') ?? ''}}</textarea>
</div>
@error('endereco')
<div class="form_error_message">
    <label></label>
    <p><strong>{{$message}}</strong></p>
</div>
@enderror
<div>
    <label for="client_payment_type">Payment Type
        <span class="optional_field_indicator">- Optional</span>
    </label>
    <select type="text" name="tipo_pagamento" id="client_payment_type">
        <option value="">None</option>
        <option value="VISA" {{old('tipo_pagamento') == 'VISA' ? 'selected' : ''}}>Visa</option>
        <option value="MC" {{old('tipo_pagamento') == 'MC' ? 'selected' : ''}}>Master Card</option>
        <option value="PAYPAL" {{old('tipo_pagamento') == 'PAYPAL' ? 'selected' : ''}}>Paypal</option>
    </select>
</div>
@error('tipo_pagamento')
<div class="form_error_message">
    <label></label>
    <p><strong>{{$message}}</strong></p>
</div>
@enderror
<div>
    <label for="client_payment_ref">
        <span class="tooltip">Payment Reference
            <span class="tooltiptext">A sequence of 16 digits if Master Card or Visa were selected.</span>
        </span>
        <span class="optional_field_indicator"> - Optional</span>
    </label>
    <input type="text" name="ref_pagamento" id="client_payment_ref" disabled>
</div>
@error('ref_pagamento')
<div class="form_error_message">
    <label></label>
    <p><strong>{{$message}}</strong></p>
</div>
@enderror
