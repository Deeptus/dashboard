<div id="headband">
    <div class="container">
        <div class="row py-2">
            <div class="col-6 d-flex justify-content-start align-items-center">
                <a class="navbar-item" href="{{ route('home') }}">
                    <img src="{{ asset('images/royo.png') }}" class="mr-5">
                </a>
            </div>
            <div class="col-6 d-flex justify-content-end align-items-center">
                <a class="navbar-item" href="{{ route('home') }}">
                    <img src="{{ asset('images/klockmetal.png') }}">
                </a>
                <div href="" class="d-none d-md-block zona-privada-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle"></i>
                    {{ $privatezone->user()->name }}
                </div>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('client.home') }}">Area de Clientes</a>
                    <a class="dropdown-item" href="{{ route('client.logout') }}">Salir</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="navbar-container">
    <div class="container">
        <div class="navbar justify-content-start p-0">
            <div class="navbar-items-container navbar-items-container-login">
                <div id="navbar-items" class="">
                    @include('client-area.components.navbar-items')
                </div>
                <div id="navbar-search-container" class="">
                    <input type="text" placeholder="Escribe aqui lo que quieres buscar">
                    <button>
                        <i class="fas fa-search"></i>
                        Buscar
                    </button>
                </div>
            </div>
            <div id="navbar-btn-manu" data-toggle="modal" data-target="#modalNavbarTop"><i class="fas fa-bars"></i> MENU</div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalNavbarTop" tabindex="-1" role="dialog" aria-labelledby="modalNavbarTopTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalNavbarTopTitle">Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="navbar-modal-items" class="">
            @include('client-area.components.navbar-items')
        </div>
      </div>
    </div>
  </div>
</div>
    @if ($errors->any())
    <div class="row">
        <div class="col s12 m12">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
