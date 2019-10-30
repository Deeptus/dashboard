@php
    if (config('app.debug')){
        $assets_version = hash('md5', rand());
    } else {
        $assets_version = '2';
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="public-path" content="{{ asset('/') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

    <script>
        document.__API_URL = '{{ url('/') }}';
    </script>
    <!-- Styles -->
    <link href="{{ asset(config('admin.theme.styles', 'css/app.css')) }}?{{ $assets_version }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @auth
        <div class="headband">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled m-0 float-left">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle pl-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user-circle"></i>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="navbar-nav float-right d-flex flex-row">
                            {{--<li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="fas fa-store-alt"></i>
                                    Tienda
                                </a>
                            </li>--}}
                            <li class="nav-item ml-2">
                                <a href="{{ route('admin.home') }}" class="nav-link">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Área de Configuración
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-md navbar-light bg-light navbar-laravel">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item {{ __active($__admin_active, 'presupuesto') }}">
                            <a class="nav-link" href="{{ route('presupuesto') }}">
                                PRESUPUESTOS
                            </a>
                        </li>
                    </ul>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('images/logo-header_10.png') }}" style="width: 90px; transform: scale(1.4);">
                    </a>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item {{ __active($__admin_active, 'pedido') }}">
                            <a class="nav-link" href="{{ route('pedido') }}">
                                PEDIDOS
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        @endauth
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!-- Scripts -->
     <script src="{{ asset('js/dashboard.js') }}?{{ $assets_version }}" defer></script>
</body>
</html>
