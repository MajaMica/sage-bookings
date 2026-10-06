<section class="relative w-full h-[600px] overflow-hidden" id="hero-section">

   <div class="absolute inset-0" id="hero-slider">
    <picture>
      <source media="(max-width: 768px)" srcset="@asset('resources/images/woman-traveling-in-barcelona-3-mobile.webp')">
      <img src="@asset('resources/images/woman-traveling-in-barcelona-3.webp')"
           alt=""
           fetchpriority="high"
           loading="eager"
           decoding="async"
           class="hero-slide absolute inset-0 w-full h-full object-cover opacity-100 transition-opacity duration-1000">
    </picture>

    <picture>
      <source media="(max-width: 768px)" srcset="@asset('resources/images/woman-traveling-in-barcelona-mobile.webp')">
      <img src="@asset('resources/images/woman-traveling-in-barcelona.webp')"
           alt=""
           loading="lazy"
           decoding="async"
           class="hero-slide absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-1000">
    </picture>

    <picture>
      <source media="(max-width: 768px)" srcset="@asset('resources/images/woman-traveling-in-porto-city-mobile.webp')">
      <img src="@asset('resources/images/woman-traveling-in-porto-city.webp')"
           alt=""
           loading="lazy"
           decoding="async"
           class="hero-slide absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-1000">
    </picture>
  </div>

  <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/25 to-black/60 z-10"></div>

  <div class="relative z-20 h-full flex flex-col items-center justify-center px-4 pt-16">

    <h1 class="text-white text-4xl md:text-6xl font-display text-center mb-10 max-w-3xl leading-tight drop-shadow-2xl">
      Tvoje sledeće putovanje počinje ovde
    </h1>

    <form method="GET" action="{{ home_url('/') }}"
      class="w-full max-w-2xl rounded-3xl md:rounded-full shadow-[0_8px_32px_rgba(0,0,0,0.25)] px-4 py-4 md:px-6 md:py-4 flex flex-col md:flex-row items-stretch md:items-center gap-3
             bg-white/70 backdrop-blur-xl border border-white/60
             ring-1 ring-inset ring-white/30">

  <div class="w-full md:flex-1 flex items-center gap-2 px-4 py-3 md:py-2 rounded-full border border-white/40 bg-white/40 backdrop-blur-sm transition-all focus-within:border-bagdala-orange focus-within:bg-white/60">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
         stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-bagdala-orange flex-shrink-0">
      <path stroke-linecap="round" stroke-linejoin="round"
            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
      <path stroke-linecap="round" stroke-linejoin="round"
            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
    </svg>
    <input type="text" name="q" placeholder="Destinacija"
           class="w-full bg-transparent text-stone-900 text-sm placeholder-stone-600 focus:outline-none">
  </div>

  <div class="w-full md:flex-1 flex items-center gap-2 px-4 py-3 md:py-2 rounded-full border border-white/40 bg-white/40 backdrop-blur-sm transition-all focus-within:border-bagdala-orange focus-within:bg-white/60">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
         stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-zinc-700 flex-shrink-0">
      <path stroke-linecap="round" stroke-linejoin="round"
            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
    </svg>
    <input type="date" name="date"
           class="w-full bg-transparent text-slate-700 text-sm focus:outline-none">
  </div>

  <button type="submit"
          class="w-full md:w-auto bg-bagdala-orange hover:bg-bagdala-orange-dark text-white font-semibold text-sm
                 px-6 py-3 rounded-full flex items-center justify-center gap-1.5 transition-all flex-shrink-0
                 shadow-lg shadow-bagdala-orange/30 hover:shadow-bagdala-orange/50 hover:scale-[1.02]">
    Pretraži
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
         stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
      <path stroke-linecap="round" stroke-linejoin="round"
            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
    </svg>
  </button>

  <input type="hidden" name="scroll" value="ponuda">
</form>

  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('#hero-slider .hero-slide');
    let current = 0;

    setInterval(function () {
      slides[current].classList.remove('opacity-100');
      slides[current].classList.add('opacity-0');
      current = (current + 1) % slides.length;
      slides[current].classList.remove('opacity-0');
      slides[current].classList.add('opacity-100');
    }, 5000);

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('q') || urlParams.has('date')) {
      const target = document.getElementById('ponuda');
      if (target) {
        setTimeout(() => target.scrollIntoView({ behavior: 'smooth', block: 'start' }), 300);
      }
    }
  });
</script>