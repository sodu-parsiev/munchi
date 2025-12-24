<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Munchi</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <style>
            :root {
                color-scheme: light;
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                font-family: "Instrument Sans", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
                background: #f7f7f5;
                color: #1b1b18;
            }

            .page {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .content {
                flex: 1;
                display: flex;
                justify-content: center;
                padding: 32px 20px 48px;
            }

            .card {
                background: #ffffff;
                border: 1px solid #e2e2dc;
                border-radius: 16px;
                padding: 24px;
                box-shadow: 0 12px 30px rgba(27, 27, 24, 0.06);
            }

            .container {
                width: 100%;
                max-width: 960px;
                display: flex;
                flex-direction: column;
                gap: 24px;
            }

            .banner {
                border: 1px solid #f3c96b;
                background: #fff5dd;
                color: #6b4f00;
                padding: 12px 16px;
                border-radius: 12px;
                font-size: 0.95rem;
                text-align: center;
                font-weight: 600;
            }

            .hero {
                text-align: center;
            }

            .hero h1 {
                margin: 0 0 8px;
                font-size: 2.5rem;
                letter-spacing: -0.02em;
            }

            .hero p {
                margin: 0;
                font-size: 1.2rem;
                color: #4a4a46;
            }

            .cta-row {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 12px;
                margin-top: 20px;
            }

            .cta {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 12px 20px;
                border-radius: 999px;
                font-weight: 600;
                text-decoration: none;
                border: 1px solid transparent;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .cta-primary {
                background: #ff7a18;
                color: #ffffff;
                box-shadow: 0 6px 16px rgba(255, 122, 24, 0.25);
            }

            .cta-secondary {
                background: #ffffff;
                color: #1b1b18;
                border-color: #e2e2dc;
            }

            .cta:hover {
                transform: translateY(-1px);
            }

            .section-title {
                margin: 0 0 12px;
                font-size: 1.25rem;
            }

            .steps {
                display: grid;
                gap: 12px;
            }

            .step {
                border: 1px solid #e2e2dc;
                border-radius: 12px;
                padding: 14px 16px;
                background: #fbfbfa;
            }

            .note {
                color: #5a5a54;
                font-size: 0.95rem;
            }

            footer {
                border-top: 1px solid #e2e2dc;
                padding: 18px 20px;
                text-align: center;
                background: #ffffff;
            }

            footer a {
                color: #1b1b18;
                text-decoration: none;
                margin: 0 8px;
                font-weight: 500;
            }

            footer .footer-meta {
                margin-top: 8px;
                color: #6b6b65;
                font-size: 0.9rem;
            }

            @media (max-width: 720px) {
                .hero h1 {
                    font-size: 2rem;
                }

                .card {
                    padding: 20px;
                }
            }
        </style>
    </head>
    <body>
        <div class="page">
            <main class="content">
                <div class="container">
                    <div class="banner">
                        Development environment — points have no real-world value.
                    </div>

                    <section class="card hero">
                        <h1>Munchi</h1>
                        <p>Earn points, unlock in-app benefits</p>
                        <p class="note" style="margin-top: 12px;">Optional third-party rewarded offers (AdGem/partners)</p>
                        <div class="cta-row">
                            @if (Route::has('register'))
                                <a class="cta cta-primary" href="{{ route('register') }}">Get started</a>
                            @else
                                <!-- TODO: Update register link once auth routes are available. -->
                                <a class="cta cta-primary" href="#">Get started</a>
                            @endif

                            @if (Route::has('login'))
                                <a class="cta cta-secondary" href="{{ route('login') }}">Sign in</a>
                            @else
                                <!-- TODO: Update login link once auth routes are available. -->
                                <a class="cta cta-secondary" href="#">Sign in</a>
                            @endif
                        </div>
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

            <footer>
                <div>
                    <a href="/privacy">Privacy</a>
                    <a href="/terms">Terms</a>
                    <a href="/contact">Contact</a>
                </div>
                <div class="footer-meta">© {{ date('Y') }} Munchi</div>
            </footer>
        </div>
    </body>
</html>
