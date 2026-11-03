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

    <div id="app" class="relative overflow-hidden bg-[#faf8f5]">
      
      <div class="absolute top-40 -left-20 w-96 h-96 bg-orange-400 rounded-[0_100%_0_100%] blur-3xl opacity-20 leaf-1 pointer-events-none z-0"></div>
      <div class="absolute top-1/3 -right-20 w-[30rem] h-[30rem] bg-amber-500 rounded-[0_100%_0_100%] blur-3xl opacity-15 leaf-2 pointer-events-none z-0"></div>
      <div class="absolute bottom-20 -left-10 w-80 h-80 bg-red-800 rounded-[0_100%_0_100%] blur-3xl opacity-10 leaf-3 pointer-events-none z-0"></div>
      <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-orange-600 rounded-[0_100%_0_100%] blur-2xl opacity-15 leaf-1 pointer-events-none z-0"></div>

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