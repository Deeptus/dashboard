<a class="navbar-item {{ __active($active, 'client.certificado') }}" href="{{ route('client.home') }}">
    Certificados MP
</a>
<a class="navbar-item {{ __active($active, 'client.pedido') }}" href="{{ route('client.pedido') }}">
    PROFORMA DE PEDIDOS
</a>
<!-- HISTÓRICO Y ESTADO DE PEDIDOS -->
<a class="navbar-item {{ __active($active, 'client.hpedidos') }}" href="{{ route('client.hpedidos') }}">
    HISTÓRICO DE PEDIDOS
</a>
<a class="navbar-item {{ __active($active, 'client.pendiente-entrega') }}" href="{{ route('client.pendiente-entrega') }}">
    PENDIENTE POR ENTREGA
</a>
<a class="navbar-item {{ __active($active, 'client.ccorriente') }}" href="{{ route('client.ccorriente') }}">
    CUENTA CORRIENTE
</a>
