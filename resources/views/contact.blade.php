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
      <!-- Replace action with your Laravel route if you enable the form -->
      <form method="post" action="#" novalidate>
        <div class="row">
          <div>
            <label for="name">Name</label>
            <input id="name" name="name" type="text" placeholder="Your name" />
          </div>
          <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" placeholder="you@example.com" />
          </div>
          <div>
            <label for="message">Message</label>
            <textarea id="message" name="message" placeholder="How can we help?"></textarea>
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

    <footer>
      &copy; <span id="y"></span> Munchi. All rights reserved.
    </footer>
  </main>

  <script>
    document.getElementById('y').textContent = new Date().getFullYear();
  </script>
</body>
</html>
