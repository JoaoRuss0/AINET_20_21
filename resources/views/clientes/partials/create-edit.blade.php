<div>
    <label for="client_nif">
        <span class="tooltip">NIF
            <span class="tooltiptext_bottom">A sequence of 9 digits.</span>
        </span>
        <span class="optional_field_indicator"> - Optional</span>
    </label>
    <input type="text" name="nif" id="client_nif" pattern="^\d{9}$" value="{{old('nif', $cliente->nif ?? '')}}">
</div>

@error('nif')
    @foreach ($errors->get('nif') as $message)
        <div class="form_error_message">
            <label></label>
            <p><strong>{{$message}}</strong></p>
        </div>
    @endforeach
@enderror

<div>
    <label for="client_address">Address
        <span class="optional_field_indicator">- Optional</span>
    </label>
    <!--<input type="text" name="endereco" id="client_address">-->
    <textarea id="client_address" name="endereco">{{old('endereco', $cliente->endereco ?? '')}}</textarea>
</div>

@error('endereco')
    @foreach ($errors->get('endereco') as $message)
        <div class="form_error_message">
            <label></label>
            <p><strong>{{$message}}</strong></p>
        </div>
    @endforeach
@enderror

<div>
    <label for="client_payment_type">Payment Type
        <span class="optional_field_indicator">- Optional</span>
    </label>
    <select type="text" name="tipo_pagamento" id="client_payment_type">
        <option value="">None</option>
        <option value="VISA" {{old('tipo_pagamento', $cliente->tipo_pagamento ?? '') == 'VISA' ? 'selected' : ''}}>Visa</option>
        <option value="MC" {{old('tipo_pagamento', $cliente->tipo_pagamento ?? '') == 'MC' ? 'selected' : ''}}>Master Card</option>
        <option value="PAYPAL" {{old('tipo_pagamento', $cliente->tipo_pagamento ?? '') == 'PAYPAL' ? 'selected' : ''}}>Paypal</option>
    </select>
</div>

@error('tipo_pagamento')
    @foreach ($errors->get('tipo_pagamento') as $message)
        <div class="form_error_message">
            <label></label>
            <p><strong>{{$message}}</strong></p>
        </div>
    @endforeach
@enderror

<div>
    <label for="client_payment_ref">
        <span class="tooltip">Payment Reference
            <span class="tooltiptext_top">A sequence of 16 digits if Master Card or Visa were selected.</span>
        </span>
        <span class="optional_field_indicator"> - Optional</span>
    </label>
    <input type="text" name="ref_pagamento" id="client_payment_ref" value="{{old('ref_pagamento', $cliente->ref_pagamento ?? '')}}" disabled>
</div>

@error('ref_pagamento')
    @foreach ($errors->get('ref_pagamento') as $message)
        <div class="form_error_message">
            <label></label>
            <p><strong>{{$message}}</strong></p>
        </div>
    @endforeach
@enderror
