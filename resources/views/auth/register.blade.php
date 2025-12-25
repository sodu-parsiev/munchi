<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Create account - Munchi</title>

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
                        <h1 class="auth-title">Create account</h1>
                        <div class="auth-subtext">
                            <p>This is a development environment.</p>
                            <p>Points have no real-world value.</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
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
                                    autocomplete="new-password"
                                    required
                                >
                                @error('password')
                                    <div class="auth-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="field">
                                <label for="password_confirmation">Confirm password</label>
                                <input
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    type="password"
                                    autocomplete="new-password"
                                    required
                                >
                            </div>

                            @include('partials.captcha')

                            <button type="submit" class="auth-button">Create account</button>
                        </form>

                        <div class="auth-footer">
                            <span>Already have an account? </span>
                            <a href="{{ route('login') }}">Sign in</a>
                        </div>
                    </section>
                </div>
            </main>

            @include('partials.footer')
        </div>
    </body>
</html>
