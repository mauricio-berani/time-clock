<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/pt.js"></script>
    {{-- You need to set here the default locale or any global flatpickr settings--}}
    <script>
        flatpickr.localize(flatpickr.l10ns.pt);
    </script>
    <title>{{ isset($title) ? $title.' - '.config('client.name') : config('client.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">
    <div class="shadow bg-primary">

    </div>
    <x-main full-width>
        <x-slot:sidebar drawer="main-drawer" class="bg-accent">
            <livewire:common.navigation.sidebar-component />
        </x-slot:sidebar>

        <x-slot:content class="bg-base-200">
            <livewire:common.navigation.navbar-component />
            {{ $slot }}
        </x-slot:content>
    </x-main>

    <x-toast />
</body>

</html>
