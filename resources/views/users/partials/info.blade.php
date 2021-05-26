<p><strong>Name: </strong>{{$user->name}}</p>
<p><strong>Email: </strong>{{$user->email}}</p>
<p><strong>Type: </strong>
@switch($user->tipo)
    @case('A')
            Administrador
        @break
    @case('C')
            Client
        @break
    @case('F')
            Worker
        @break
    @default No type assigned.
@endswitch
</p>
<p><strong>Blocked: </strong>
@if ($user->bloqueado)
    Yes
@else
    No
@endif
</p>
