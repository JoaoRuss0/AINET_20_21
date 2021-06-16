@component('mail::message')
<h1><strong>Order #{{$order->id}}</strong> successfully closed.</h1>
@include('encomendas.partials.info')

@component('mail::table')
| Stamp                 | Colour                | Size               | Quantity              | Price               | Subtotal            |
|-----------------------|:----------------------|:-------------------|:----------------------|:--------------------|:--------------------|
@foreach ($items as $item)
| {{$item->estampa_id}} | {{$item->cor_codigo}} | {{$item->tamanho}} | {{$item->quantidade}} | {{$item->preco_un}} | {{$item->subtotal}} |
@endforeach
@endcomponent

Kind regards,<br>
MagicShirts!
@endcomponent

