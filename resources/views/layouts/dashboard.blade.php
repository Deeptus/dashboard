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


<link href="https://unpkg.com/primevue/resources/themes/saga-blue/theme.css " rel="stylesheet">
<link href="https://unpkg.com/primevue/resources/primevue.min.css " rel="stylesheet">
<link href="https://unpkg.com/primeicons/primeicons.css " rel="stylesheet">
    <!-- Hardcodeada temporal -->  
<style type="text/css">
    .btn .app-primary{
        color: white;
    }
    .dataTable-top {
            justify-content: flex-end !important;
        
        
    }


</style>
    <!-- Hardcodeada temporal -->  

</head>
<body >

    @if (Auth::check())
    <div id="app" class="p-2">
    </div>

        <!-- Scripts -->
        <script src="{{ asset('js/dashboard.js') }}?{{ $assets_version }}" defer></script>


         <script>

            window.authUser={!! json_encode(Auth::user()); !!};
            window.authPermissions= [1]
            window.authGroup= [1]

     </script>
    @else

         <script>window.authUser=null;</script>
    @endif


</body>

</html>
