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
  
    <link rel="preload"
          as="image"
          href="@asset('resources/images/hero-slika-1.webp')"
          media="(min-width: 769px)"
          fetchpriority="high">
    <link rel="preload"
          as="image"
          href="@asset('resources/images/hero-slika-1-mobile.webp')"
          media="(max-width: 768px)"
          fetchpriority="high">

    <link rel="preload" as="font" type="font/woff2" crossorigin
          href="@asset('resources/fonts/kavoon-v25-latin_latin-ext-regular.woff2')">
    <link rel="preload" as="font" type="font/woff2" crossorigin
          href="@asset('resources/fonts/poppins-v24-latin_latin-ext-regular.woff2')">
  </head>

  <body @php(body_class())>
    @php(wp_body_open())

    <div id="app" class="relative overflow-x-clip bg-[#faf8f5]">
      
      <div class="blobs" aria-hidden="true">
        <div class="blob b1"></div>
        <div class="blob b2"></div>
        <div class="blob b3"></div>
      </div>

      <div class="relative z-10 flex flex-col min-h-screen">
        <a class="sr-only focus:not-sr-only" href="#main">
          {{ __('Skip to content', 'sage') }}
        </a>

        @include('sections.header')

        <main id="main" class="main flex-grow">
          @yield('content')
        </main>

        @hasSection('sidebar')
          <aside class="sidebar">
            @yield('sidebar')
          </aside>
        @endif

        @include('sections.footer')
      </div>
      
    </div>

    @php(do_action('get_footer'))
    @php(wp_footer())

    @include('partials.reservation-modal')
  </body>
</html>