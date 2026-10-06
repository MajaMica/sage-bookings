<!doctype html>
<html @php(language_attributes())>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php(do_action('get_header'))
    @php(wp_head())

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
      window.bagdalaReservation = {
        nonce: '{{ wp_create_nonce('bagdala_reservation') }}'
      };
    </script>

    {{-- Preload hero image (LCP element) --}}
    <link rel="preload"
          as="image"
          href="@asset('resources/images/woman-traveling-in-barcelona-3.webp')"
          media="(min-width: 769px)"
          fetchpriority="high">
    <link rel="preload"
          as="image"
          href="@asset('resources/images/woman-traveling-in-barcelona-3-mobile.webp')"
          media="(max-width: 768px)"
          fetchpriority="high">

    {{-- Preload Kavoon (naslovi iznad fold-a) + Poppins regular (body tekst) --}}
    <link rel="preload" as="font" type="font/woff2" crossorigin
          href="@asset('resources/fonts/kavoon-v25-latin_latin-ext-regular.woff2')">
    <link rel="preload" as="font" type="font/woff2" crossorigin
          href="@asset('resources/fonts/poppins-v24-latin_latin-ext-regular.woff2')">
  </head>

  <body @php(body_class())>
    @php(wp_body_open())

    <div id="app">
      <a class="sr-only focus:not-sr-only" href="#main">
        {{ __('Skip to content', 'sage') }}
      </a>

      @include('sections.header')

      <main id="main" class="main">
        @yield('content')
      </main>

      @hasSection('sidebar')
        <aside class="sidebar">
          @yield('sidebar')
        </aside>
      @endif

      @include('sections.footer')
    </div>

    @php(do_action('get_footer'))
    @php(wp_footer())

    @include('partials.reservation-modal')
  </body>
</html>