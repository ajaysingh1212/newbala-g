<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Portal') }} · Secure sign in</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="prism-page antialiased">
        <main class="prism-shell">
            <div class="aurora aurora-one"></div>
            <div class="aurora aurora-two"></div>
            <div class="aurora aurora-three"></div>

            <section class="prism-hero" aria-label="Welcome">
                <a class="brand" href="{{ route('login') }}" aria-label="{{ config('app.name', 'Portal') }} home">
                    <span class="brand-mark"><span></span><span></span><span></span></span>
                    <span>{{ config('app.name', 'Portal') }}</span>
                </a>
                <div class="hero-copy">
                    <p class="eyebrow">SECURE WORKSPACE</p>
                    <h1>Where clarity<br>meets control.</h1>
                    <p>One beautifully simple place to access your workspace, manage details, and keep moving.</p>
                </div>
                <div class="hero-footer"><span class="status-dot"></span> Protected access · Available 24/7</div>
            </section>

            <section class="login-panel">
                <div class="login-glow"></div>
                <div class="login-content">{{ $slot }}</div>
            </section>
        </main>
    </body>
</html>
