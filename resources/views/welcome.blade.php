<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Munchi</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite('resources/css/public.css')
    </head>
    <body>
        <div class="page">
            @include('partials.header')
            <main class="content">
                <div class="container">
                    <div class="banner">
                        Development environment — points have no real-world value.
                    </div>

                    <section class="card hero">
                        <h1>Munchi</h1>
                        <p>Earn points, unlock in-app benefits</p>
                        <p class="note note-spacing">Optional third-party rewarded offers (AdGem/partners)</p>
                        @if(!Auth::check())
                            <div class="cta-row">
                                @if (Route::has('register'))
                                    <a class="cta cta-primary" href="{{ route('register') }}">Get started</a>
                                @endif

                                @if (Route::has('login'))
                                    <a class="cta cta-secondary" href="{{ route('login') }}">Sign in</a>
                                @endif
                            </div>
                        @endif
                    </section>

                    <section class="card">
                        <h2 class="section-title">How it works</h2>
                        <div class="steps">
                            <div class="step">1. Create an account</div>
                            <div class="step">2. Earn points (optional offers)</div>
                            <div class="step">3. Redeem for in-app benefits</div>
                        </div>
                    </section>
                </div>
            </main>

            @include('partials.footer')
        </div>
    </body>
</html>
