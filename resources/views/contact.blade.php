<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Contact - Munchi</title>
  <meta name="robots" content="index,follow" />
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
  @vite('resources/css/public.css')
</head>

<body>
  @include('partials.header')
  <main class="wrap wrap-narrow">
    <header>
      <h1>Contact</h1>
      <p class="meta"><strong>Munchi</strong> (munchiapp.co)</p>
    </header>

    <section class="card card-block">
      <p>
        If you have questions, need support, or want to report an issue, you can contact us using the information below.
        We aim to respond as soon as possible.
      </p>
    </section>

    <section class="card card-block">
      <h2 style="margin-top:0;">Contact details</h2>
      <p>
        <strong>Email:</strong>
        <a href="mailto:support@munchiapp.co">support@munchiapp.co</a>
      </p>
      <p>
        <strong>Website:</strong>
        <a href="https://munchiapp.co">https://munchiapp.co</a>
      </p>
    </section>

    <section class="card card-block">
      <h2 style="margin-top:0;">Send us a message</h2>
      @if (session('status'))
        <p style="margin-bottom:16px; color:#0f5132; background:#d1e7dd; padding:12px; border-radius:8px;">
          {{ session('status') }}
        </p>
      @endif
      @if ($errors->any())
        <div style="margin-bottom:16px; color:#842029; background:#f8d7da; padding:12px; border-radius:8px;">
          <p style="margin-top:0; font-weight:600;">Please correct the errors below:</p>
          <ul style="margin:0; padding-left:20px;">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <form method="post" action="{{ route('contact.submit') }}" novalidate>
        @csrf
        <div class="row">
          <div>
            <label for="name">Name</label>
            <input id="name" name="name" type="text" placeholder="Your name" value="{{ old('name') }}" />
          </div>
          <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" placeholder="you@example.com" value="{{ old('email') }}" />
          </div>
          <div>
            <label for="message">Message</label>
            <textarea id="message" name="message" placeholder="How can we help?">{{ old('message') }}</textarea>
          </div>
          <div>
            @include('partials.captcha')
          </div>
          <div>
            <button type="submit">Send message</button>
          </div>
        </div>
      </form>
      <p style="opacity:.8; margin-top:10px;">
        Note: This form is optional. You may also contact us directly via email.
      </p>
    </section>

    @include('partials.footer')
  </main>
</body>
</html>
