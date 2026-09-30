<section class="relative w-full h-[600px] overflow-hidden" id="hero-section">

  <div class="absolute inset-0" id="hero-slider">
    <img src="@asset('resources/images/woman-traveling-in-barcelona-3.webp')"
         alt=""
         class="hero-slide absolute inset-0 w-full h-full object-cover opacity-100 transition-opacity duration-1000">
    <img src="@asset('resources/images/woman-traveling-in-barcelona.webp')"
         alt=""
         class="hero-slide absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-1000">
    <img src="@asset('resources/images/woman-traveling-in-porto-city.webp')"
         alt=""
         class="hero-slide absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-1000">
  </div>

  <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/25 to-black/60 z-10"></div>

  <div class="relative z-20 h-full flex flex-col items-center justify-center px-4 pt-16">

    <h1 class="text-white text-4xl md:text-6xl font-display text-center mb-10 max-w-3xl leading-tight drop-shadow-2xl">
      Tvoje sledeće putovanje počinje ovde
    </h1>

    <div class="w-full max-w-2xl bg-white rounded-full shadow-2xl px-6 py-5 flex items-center gap-3">

      <div class="flex-1 flex items-center gap-2 px-4 py-2 rounded-full border border-neutral-200 transition-colors focus-within:border-bagdala-orange">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-bagdala-orange flex-shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
        </svg>
        <input type="text" placeholder="Destinacija"
               class="w-full bg-transparent text-stone-900 text-sm placeholder-stone-900 focus:outline-none">
      </div>

      <div class="flex-1 flex items-center gap-2 px-4 py-2 rounded-full border border-slate-500 transition-colors focus-within:border-bagdala-orange">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-zinc-800 flex-shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
        </svg>
        <input type="text" placeholder="Datum polaska"
               class="w-full bg-transparent text-slate-500 text-sm placeholder-slate-500 focus:outline-none">
      </div>

      <button type="button"
              class="bg-bagdala-orange hover:bg-bagdala-orange-dark text-stone-900 font-semibold text-sm
                     px-6 py-3 rounded-full flex items-center gap-1.5 flex-shrink-0
                     transition-all duration-300 hover:scale-105 hover:shadow-lg">
        Pretraži
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
        </svg>
      </button>

    </div>

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
  });
</script>