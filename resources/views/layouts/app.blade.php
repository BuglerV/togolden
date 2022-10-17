<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
		<link rel="stylesheet" href="{{ asset('font-awesome-4.7.0/css/font-awesome.min.css') }}">

        <!-- Scripts -->
		<script src="{{ mix('js/app.js') }}" defer></script>
		<script src="{{ mix('js/libraries.js') }}" defer></script>

        <!-- Styles -->
		<link rel="stylesheet" href="{{ mix('css/bootstrap.css') }}">
		<link rel="stylesheet" href="{{ mix('css/app.css') }}">
    </head>
    <body>
        @include('alert')
        @include('modal')

        <div class="min-vh-100 bg-secondary">
		    @include('navigation')

            <!-- Page Content -->
            <main class="text-light">
                @yield('body')
            </main>
        </div>

        @stack('scripts')
    </body>
</html>
