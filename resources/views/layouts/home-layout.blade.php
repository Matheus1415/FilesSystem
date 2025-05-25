<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'FileSystem')</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-background">
    @yield('content')
</body>
</html>