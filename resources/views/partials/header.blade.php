@php
    $homeUrl = Route::has('home') ? route('home') : url('/');
@endphp

<header class="site-header">
    <div class="site-header-inner">
        <a class="site-brand" href="{{ $homeUrl }}">Munchi</a>
        <nav class="site-nav">
            <a class="nav-link" href="{{ $homeUrl }}">Home</a>
            <a class="nav-link" href="{{ url('/privacy') }}">Privacy</a>
            <a class="nav-link" href="{{ url('/terms') }}">Terms</a>
            <a class="nav-link" href="{{ url('/contact') }}">Contact</a>
        </nav>
    </div>
</header>
