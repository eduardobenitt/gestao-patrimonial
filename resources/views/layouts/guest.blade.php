<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>AssetFlow</title>


    <!-- Scripts -->
    @vite(['resources/js/login_script.js', 'resources/css/app.css', 'resources/css/login.css'])
</head>

<body>


    <div>
        @yield('content')
    </div>
</body>

</html>
