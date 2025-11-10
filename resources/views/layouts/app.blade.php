<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">


    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    <!-- ✅ Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
</head>

<body>
    <div id="app">

        <main class="py-4">
            @yield('content')
        </main>
    </div>


{{--    <footer class="bg-dark text-white py-4">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-6">--}}
{{--                    <p>&copy; 2025 Gemeente. Alle rechten voorbehouden.</p>--}}
{{--                </div>--}}
{{--                <div class="col-md-6 text-end">--}}
{{--                    <a href="{{ route('privacy.policy') }}" class="text-white me-3">--}}
{{--                        <i class="fas fa-shield-alt me-1"></i> Privacybeleid--}}
{{--                    </a>--}}
{{--                    <!-- روابط أخرى -->--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </footer>--}}
</body>

</html>
