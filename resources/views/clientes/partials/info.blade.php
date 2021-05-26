<p><strong>Name: </strong>{{$user->name}}</p>
<p><strong>Email: </strong>{{$user->email}}</p>
<p><strong>NIF: </strong>{{$cliente->nif ?? "----"}}</p>
<p><strong>Address: </strong>{{$cliente->endereco ?? "----"}}</p>
<p><strong>Payment Type: </strong>
    @if ($cliente->tipo_pagamento == NULL)
        ----
    @elseif ($cliente->tipo_pagamento == 'MC')
        MasterCard
    @else
        {{ ucfirst($cliente->tipo_pagamento) }}
    @endif
</p>
<p><strong>Payment Reference: </strong>{{$cliente->ref_pagamento ?? "----"}}</p>

