<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Contact - Munchi</title>
  <meta name="robots" content="index,follow" />
  <style>
    :root { color-scheme: light dark; }
    body { margin: 0; font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; line-height: 1.55; }
    .wrap { max-width: 800px; margin: 0 auto; padding: 24px 16px 64px; }
    header { padding: 8px 0 18px; border-bottom: 1px solid rgba(127,127,127,.25); }
    h1 { font-size: 28px; margin: 0 0 6px; }
    .meta { opacity: .8; margin: 0; }
    h2 { font-size: 18px; margin: 22px 0 10px; }
    p, label { font-size: 15px; }
    .card { border: 1px solid rgba(127,127,127,.25); border-radius: 12px; padding: 16px; margin: 16px 0; }
    .row { display: grid; grid-template-columns: 1fr; gap: 12px; }
    input, textarea, button {
      width: 100%;
      font-size: 15px;
      padding: 10px 12px;
      border-radius: 10px;
      border: 1px solid rgba(127,127,127,.35);
      background: transparent;
      color: inherit;
    }
    textarea { resize: vertical; min-height: 120px; }
    button {
      cursor: pointer;
      font-weight: 600;
      border: 1px solid rgba(127,127,127,.45);
    }
    footer { margin-top: 28px; padding-top: 14px; border-top: 1px solid rgba(127,127,127,.25); opacity: .85; font-size: 13px; }
    a { color: inherit; }
  </style>
</head>

<body>
  <main class="wrap">
    <header>
      <h1>Contact</h1>
      <p class="meta"><strong>Munchi</strong> (munchiapp.co)</p>
    </header>

    <section class="card">
      <p>
        If you have questions, need support, or want to report an issue, you can contact us using the information below.
        We aim to respond as soon as possible.
      </p>
    </section>

    <section class="card">
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

    <section class="card">
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
