<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ isset($title) ? $title.' - '.config('client.name') : config('client.name') }}</title>
</head>

<body>
    {{ $slot }}
    <x-toast />
</body>

</html>
