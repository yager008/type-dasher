    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- heatmap -->
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script src="https://unpkg.com/cal-heatmap/dist/cal-heatmap.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/cal-heatmap/dist/cal-heatmap.css">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('type.css') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-6Ko4Pq/6NmE4O5IhJcB/s8vxl0K1Yb+0tWQFVZz/jUp6CxWFAxI6AA+d6PFZYY6w"
          crossorigin="anonymous">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Include any additional JavaScript scripts here -->

</head>
<body class="font-sans antialiased">
<div class="bg-gray-100 dark:bg-gray-800">
    @include('layouts.navigation') <!-- Include your navigation partial -->

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>

<!-- Additional JavaScript libraries and custom scripts -->
@yield('scripts')

</body>
</html>
