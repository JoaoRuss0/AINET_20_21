<p><strong>Status: </strong>
    @switch($order->estado)
        @case("paga")
                Paid
        @break
        @case("pendente")
            Pending
        @break
        @case("fechada")
            Closed
        @break
        @case("anulada")
            Cancelled
        @break
    @endswitch
</p>
<p><strong>Date: </strong>{{ $order->data }}</p>
<p><strong>Notes: </strong>{{ $order->notas }}</p>
<p><strong>NIF: </strong>{{ $order->nif }}</p>
<p><strong>Address: </strong>{{ $order->endereco }}</p>
<p><strong>Payment Type: </strong>{{ $order->tipo_pagamento }}</p>
<p><strong>Payment Reference: </strong>{{ $order->ref_pagamento }}</p>
<p><strong>Total: </strong>{{ $order->preco_total }} €</p>
