<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Munchi Dashboard</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite('resources/css/public.css')
    </head>
    <body>
        <div class="page">
            @include('partials.header')

            <main class="content">
                <div class="container">
                    <section class="card hero">
                        <h1>Dashboard</h1>
                        <p class="note">Points are for in-app benefits only. No cash value.</p>
                    </section>

                    @if (session('status'))
                        <div class="banner">{{ session('status') }}</div>
                    @endif

                    <section class="card">
                        <h2 class="section-title">Your Points: {{ auth()->user()->points_balance ?? 0 }}</h2>
                        <p class="note">Use points to unlock future in-app rewards.</p>
                        <form method="POST" action="{{ route('earn-points') }}">
                            @csrf
                            <button type="submit">Earn points</button>
                        </form>
                    </section>
                </div>
            </main>

            @include('partials.footer')
        </div>
    </body>
</html>
