@php
    if (!$assets_version) {
        if (config('app.debug')){
            $assets_version = hash('md5', rand());
        } else {
            $assets_version = '2';
        }
    }
    if (isset($_COOKIE["sidebarToggleStatus"])) {
        if ($_COOKIE["sidebarToggleStatus"] == 'show') {
            $sidebarToggleHide = false;
        } else {
            $sidebarToggleHide = true;
        }
    } else {
        $sidebarToggleHide = false;
    }
@endphp
<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset(Storage::url(__config_var('admin_favicon'))) }}" type="image/png" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="public-path" content="{{ asset('/') }}">
    <meta name="storage-path" content="{{ asset(Storage::url('/')) }}">
    <meta name="decimal-separator" content="{{ __config_var('decimal_separator') }}">
    <meta name="thousands-separator" content="{{ __config_var('thousands_separator') }}">
    <meta name="3c3aazbg5" content="{{ floatval(ini_get('upload_max_filesize')) * 1024 }}">
    <meta name="f983jd020" content="{{ floatval(ini_get('post_max_size')) * 1024 }}">

    <title>{{ config('app.name', 'Panel') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/nunito/nunito.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/fontawesome/css/all.min.css') }}">
    <link href="{{ asset(config('admin.theme.styles', 'css/theme-02.css')) }}?{{ $assets_version }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('fontello/css/hard.css') }}">
    <script>
        window.serverTime = "{{ now() }}"
        window.apis = {
            homework: "{{ route('admin.homework') }}",
            notification: "{{ route('admin.notification') }}"
        }
    </script>
</head>

<body id="page-top" class="{{ $sidebarToggleHide ? 'sidebar-toggled' : '' }}">
    <!-- Page Wrapper -->
    <div id="app">
        <div id="wrapper">
            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion {{ $sidebarToggleHide ? 'toggled' : '' }}" id="accordionSidebar">
                @if (isset($__admin_menu))
                    @include($__admin_menu)
                @endif
                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>

            </ul>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    @if (isset($__admin_topbar))
                        @include($__admin_topbar)
                    @else
                        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                            <!-- Sidebar Toggle (Topbar) -->
                            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                                <i class="fa fa-bars"></i>
                            </button>

                            <!-- Topbar Navbar -->
                            <ul class="navbar-nav ms-auto">

                                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                                <li class="nav-item dropdown no-arrow d-sm-none">
                                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-search fa-fw"></i>
                                    </a>
                                    <!-- Dropdown - Messages -->
                                    <div class="dropdown-menu dropdown-menu-end p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                        <form class="form-inline mr-auto w-100 navbar-search">
                                            <div class="input-group">
                                                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button">
                                                        <i class="fas fa-search fa-sm"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                                <li class="nav-item dropdown no-arrow">
                                    <a class="nav-link dropdown-toggle" href="#" id="homeworkDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-tasks img-profile"></i>
                                    </a>
                                    <!-- Dropdown - User Information -->
                                    <homework></homework>
                                </li>
                                <div class="topbar-divider d-none d-sm-block"></div>
                                <li class="nav-item dropdown no-arrow">
                                    <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-bell img-profile"></i>
                                    </a>
                                    <notifications></notifications>
                                </li>
                                <!-- Nav Item - User Information -->
                                @if(count(LaravelLocalization::getSupportedLocales()) > 1)
                                <li class="nav-item dropdown no-arrow">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-globe img-profile"></i>
                                        <span class="me-2 d-none d-lg-inline text-gray-600 small">{{ strtoupper(LaravelLocalization::getCurrentLocale()) }}</span>
                                    </a>
                                    <!-- Dropdown - User Information -->
                                    <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
                                        @foreach (LaravelLocalization::getSupportedLocales() as $key => $lang)
                                            @if (LaravelLocalization::getCurrentLocale()!=$key)
                                                <a href="{{ LaravelLocalization::getLocalizedURL($key) }}" class="dropdown-item">
                                                    {{ strtoupper($key) }}
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </li>
                                @endif
                                <div class="topbar-divider d-none d-sm-block"></div>

                                <!-- Nav Item - User Information -->
                                <li class="nav-item dropdown no-arrow">
                                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-user-circle img-profile"></i>
                                        <span class="me-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                                        {{-- <img class="img-profile rounded-circle" src="{{ asset('img/blank-profile-picture.png') }}"> --}}
                                    </a>
                                    <!-- Dropdown - User Information -->
                                    <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="profileDropdown">
                                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Perfil
                                        </a>
                                        {{--
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Mi Acitividad
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        --}}
                                        <a class="dropdown-item" href="{{ route('logout') }}" {{--data-toggle="modal" data-target="#logoutModal"--}}>
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                            Salir
                                        </a>
                                    </div>
                                </li>

                            </ul>

                        </nav>
                    @endif
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        @yield('content')

                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>{{ config('admin.text.footer') }}</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->
        </div>
        <file-manager ref="FileManager" url-data="{{ route('admin.file-manager') }}"></file-manager>
        <chat-area ref="chatArea" endpoint="{{ route('admin.chat-area') }}"></chat-area>
        <homework-show ref="homeworkShow"></homework-show>
        <notification-show ref="notificationShow"></notification-show>
        <awesome-alert ref="awesome-alert"></awesome-alert>
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/dashboard.js') }}?{{ $assets_version }}" defer></script>

</body>

</html>
