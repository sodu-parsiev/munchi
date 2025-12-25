<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sign in - Munchi</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @vite('resources/css/public.css')
    </head>
    <body>
        <div class="page">
            @include('partials.header')
            <main class="content">
                <div class="container">
                    <section class="card auth-card">
                        <h1 class="auth-title">Sign in</h1>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="field">
                                <label for="email">Email</label>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    autocomplete="email"
                                    value="{{ old('email') }}"
                                    required
                                >
                                @error('email')
                                    <div class="auth-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="field">
                                <label for="password">Password</label>
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    autocomplete="current-password"
                                    required
                                >
                                @error('password')
                                    <div class="auth-error">{{ $message }}</div>
                                @enderror
                            </div>

                            @include('partials.captcha')

                            <button type="submit" class="auth-button">Sign in</button>
                        </form>

                        <div class="auth-footer">
                            <span>Don’t have an account? </span>
                            <a href="{{ route('register') }}">Create one</a>
                        </div>

                        <p class="auth-note">Points are for in-app benefits only.</p>
                    </section>
                </div>
            </main>

            @include('partials.footer')
        </div>
    </body>
</html>
