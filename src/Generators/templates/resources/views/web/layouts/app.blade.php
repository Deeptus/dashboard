<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', __meta('default', 'title'))</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <meta name="description" content="@yield('description', __meta('default', 'description'))">
    <meta name="keywords" content="@yield('keywords', __meta('default', 'keywords'))">
    <meta name="author" content="@yield('author', __meta('default', 'author'))">

    <meta name="public-path" content="{{ asset('/') }}">
    <meta name="storage-path" content="{{ asset(Storage::url('/')) }}">

    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="@yield('author', __meta('default', 'author'))" />
    <meta property="og:title" content="@yield('title', __meta('default', 'title'))" />
    <meta property="og:description" content="@yield('description', __meta('default', 'description'))" />
    <meta property="og:locale" content="{{ LaravelLocalization::getCurrentLocale() }}">
    @foreach (LaravelLocalization::getSupportedLocales() as $key => $lang)
        @if (LaravelLocalization::getCurrentLocale()!=$key)
            <meta property="og:locale:alternate" content="{{ $key }}">
        @endif
    @endforeach
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.1/css/all.css" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ asset('css/website.css') }}?{{ $assets_version }}" rel="stylesheet">
    <link href="{{ asset('fontello/css/hard.css') }}?{{ $assets_version }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <x-header/>
        <div id="app-content">@yield('content')</div>
        <x-footer/>
    </div>
    <?php
        if ( auth()->guard('client')->check() ) {
            # Session public storage information
            $user = auth()->guard('client')->user();
            $store = [];
            $store['fullname']      = $user->fullname;
            $store['dni']           = $user->dni;
            $store['phone']         = $user->phone;
            $store['address']       = $user->address;
            $store['business_name'] = $user->business_name;
            $store['iva_id']        = $user->iva_id;
            $store['cuit']          = $user->cuit;
            $store['provincia_id']  = $user->provincia_id;
            $store['localidad_id']  = $user->localidad_id;
            $store['codigo_postal'] = $user->codigo_postal;
            $store['email']         = $user->email;
            ?>
            <script type="text/javascript">window.spsi = "{{ base64_encode(json_encode($store)) }}"</script>
            <?php
        }
    ?>
    <script type="text/javascript" src="{{ asset('js/website.js').'?'.$assets_version }}"></script>
    @yield('scripts')
</body>
</html>
