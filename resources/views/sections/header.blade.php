{{-- TOP BAR --}}
<div id="top-bar" class="hidden md:block bg-bagdala-blue text-white text-sm relative z-40">
  <div class="container mx-auto flex justify-between items-center h-11 px-4">
    <div class="flex items-center gap-6">
      <a href="{{ home_url('/kontakt') }}" class="hover:text-bagdala-orange transition-colors">Kontakt</a>
      <a href="{{ home_url('/wp-content/uploads/2026/09/OUP-Bagdala-037-za-2027.pdf') }}" target="_blank" rel="noopener" class="hover:text-bagdala-orange transition-colors hidden sm:flex items-center gap-1.5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
        </svg>
        Opšti uslovi
      </a>
      <a href="http://bagdala-travel.test/wp-content/uploads/2026/09/Ugovor-o-subagenturi-1-1.docx" target="_blank" rel="noopener" class="hover:text-bagdala-orange transition-colors hidden md:flex items-center gap-1.5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
        </svg>
        Ugovor
      </a>
    </div>
    <div class="flex items-center gap-4">
      <a href="https://www.facebook.com/bagdalatravel.krusevac" target="_blank" rel="noopener" class="hover:text-bagdala-orange transition-colors">Facebook</a>
      <span class="text-bagdala-orange text-lg leading-none">•</span>
      <a href="https://www.instagram.com/bagdalatravel.krusevac/" target="_blank" rel="noopener" class="hover:text-bagdala-orange transition-colors">Instagram</a>
    </div>
  </div>
</div>

{{-- CAPSULE HEADER --}}
<header id="site-header" class="fixed left-0 right-0 z-50 px-4 transition-all duration-500" style="top: 44px;">
  <div id="header-container" class="max-w-6xl mx-auto flex items-center justify-between px-5 py-3 rounded-full transition-all duration-500">

    {{-- Logo --}}
    <a href="{{ home_url('/') }}" class="flex-shrink-0">
      <img id="header-logo" src="@asset('resources/images/service-037.webp')"
           alt="Bagdala Travel" class="h-10 md:h-12 w-auto transition-all duration-500">
    </a>

    {{-- Desktop menu --}}
    <nav class="hidden lg:flex items-center gap-8" id="header-nav">
      <a href="{{ home_url('/') }}" class="header-link text-white font-semibold text-base hover:text-bagdala-orange transition-colors">Početna</a>
      <a href="{{ home_url('/') }}#ponuda" class="header-link text-white font-semibold text-base hover:text-bagdala-orange transition-colors">Ponuda</a>
      <a href="{{ home_url('/iznajmljivanje-autobusa') }}" class="header-link text-white font-semibold text-base hover:text-bagdala-orange transition-colors">Iznajmljivanje autobusa</a>
      <a href="{{ home_url('/kontakt') }}" class="header-link text-white font-semibold text-base hover:text-bagdala-orange transition-colors">Kontakt</a>
    </nav>

    {{-- CTA --}}
    <a href="{{ home_url('/kontakt') }}"
       class="hidden lg:inline-flex items-center justify-center bg-bagdala-orange hover:bg-bagdala-orange-dark text-stone-900 font-semibold text-sm px-6 py-3 rounded-full transition-colors">
      Putuj sa nama!
    </a>

    {{-- Mobile hamburger --}}
    <button id="mobile-menu-toggle"
            class="lg:hidden header-link text-white w-10 h-10 flex items-center justify-center transition-colors"
            aria-label="Menu" aria-expanded="false">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7" id="icon-open">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
      </svg>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7 hidden" id="icon-close">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
      </svg>
    </button>

  </div>
</header>

{{-- MOBILE MENU --}}
<div id="mobile-menu" class="hidden fixed inset-0 z-40 lg:hidden opacity-0 transition-opacity duration-300">
  <div id="mobile-menu-backdrop" class="absolute inset-0 bg-black/70 backdrop-blur-md"></div>
  <nav class="absolute top-32 left-4 right-4 bg-bagdala-blue rounded-3xl p-6 shadow-2xl transform -translate-y-4 transition-transform duration-300">
    <div class="flex flex-col gap-1">
      <a href="{{ home_url('/') }}" class="text-white text-lg font-semibold py-3 border-b border-white/10 hover:text-bagdala-orange transition-colors">Početna</a>
      <a href="{{ home_url('/') }}#ponuda" class="text-white text-lg font-semibold py-3 border-b border-white/10 hover:text-bagdala-orange transition-colors">Ponuda</a>
      <a href="{{ home_url('/iznajmljivanje-autobusa') }}" class="text-white text-lg font-semibold py-3 border-b border-white/10 hover:text-bagdala-orange transition-colors">Iznajmljivanje autobusa</a>
      <a href="{{ home_url('/kontakt') }}" class="text-white text-lg font-semibold py-3 border-b border-white/10 hover:text-bagdala-orange transition-colors">Kontakt</a>
    </div>

    <div class="flex items-center gap-4 mt-6">
      <a href="https://www.facebook.com/bagdalatravel.krusevac" target="_blank" rel="noopener" class="text-white/80 hover:text-bagdala-orange text-sm transition-colors">Facebook</a>
      <span class="text-bagdala-orange">•</span>
      <a href="https://www.instagram.com/bagdalatravel.krusevac/" target="_blank" rel="noopener" class="text-white/80 hover:text-bagdala-orange text-sm transition-colors">Instagram</a>
    </div>

    <a href="{{ home_url('/kontakt') }}"
       class="mt-6 inline-flex items-center justify-center w-full bg-bagdala-orange hover:bg-bagdala-orange-dark text-stone-900 font-semibold px-6 py-4 rounded-full transition-colors">
      Putuj sa nama!
    </a>
  </nav>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const header    = document.getElementById('site-header');
    const container = document.getElementById('header-container');
    const logo      = document.getElementById('header-logo');
    const links     = document.querySelectorAll('.header-link');
    const topBar    = document.getElementById('top-bar');

    let lastScroll = 0;

    function updateHeader() {
      const scrolled = window.scrollY > 30;

      if (scrolled) {
        header.style.top = '12px';
        container.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-lg', 'border', 'border-neutral-200');
        container.classList.remove('bg-transparent');

        links.forEach(el => {
          el.classList.remove('text-white');
          el.classList.add('text-stone-900');
        });
      } else {
        header.style.top = '44px';
        container.classList.remove('bg-white/95', 'backdrop-blur-md', 'shadow-lg', 'border', 'border-neutral-200');
        container.classList.add('bg-transparent');

        links.forEach(el => {
          el.classList.remove('text-stone-900');
          el.classList.add('text-white');
        });
      }
    }

    window.addEventListener('scroll', updateHeader, { passive: true });
    updateHeader();

    // MOBILE MENU
    const toggle   = document.getElementById('mobile-menu-toggle');
    const menu     = document.getElementById('mobile-menu');
    const backdrop = document.getElementById('mobile-menu-backdrop');
    const iconOpen = document.getElementById('icon-open');
    const iconClose = document.getElementById('icon-close');

    function openMenu() {
      menu.classList.remove('hidden');
      requestAnimationFrame(() => {
        menu.classList.remove('opacity-0');
        menu.querySelector('nav').classList.remove('-translate-y-4');
      });
      iconOpen.classList.add('hidden');
      iconClose.classList.remove('hidden');
      toggle.setAttribute('aria-expanded', 'true');
    }

    function closeMenu() {
      menu.classList.add('opacity-0');
      menu.querySelector('nav').classList.add('-translate-y-4');
      setTimeout(() => menu.classList.add('hidden'), 300);
      iconOpen.classList.remove('hidden');
      iconClose.classList.add('hidden');
      toggle.setAttribute('aria-expanded', 'false');
    }

    toggle.addEventListener('click', () => {
      if (menu.classList.contains('hidden')) openMenu();
      else closeMenu();
    });
    backdrop.addEventListener('click', closeMenu);
  });
</script>