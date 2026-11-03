@php
  $cena           = get_field('cena');
  $datum_polaska  = get_field('datum_polaska');
  $datum_dolaska  = get_field('datum_dolaska');
  $broj_nocenja   = get_field('broj_nocenja');
  $napomena       = get_field('napomena');
  $gradovi        = get_the_terms(get_the_ID(), 'grad');

  $putovanje_id = get_the_ID();
  $ukupno       = get_field('ukupno_mesta', $putovanje_id);
  $rucno        = (int) get_field('rezervisano_rucno', $putovanje_id);
  $istaknuto    = get_field('istaknuto_mesta', $putovanje_id);

  $has_limit = $ukupno !== null && $ukupno !== '' && (int) $ukupno > 0;
  $slobodno  = 0;

  if ($has_limit) {
      $web = \App\bagdala_count_web_reservations($putovanje_id);
      $slobodno = max(0, (int) $ukupno - $web - $rucno);
  }

  $datum_formatiran = '';
  if ($datum_polaska && $datum_dolaska) {
      $datum_formatiran = date('d.m', strtotime($datum_polaska)) . ' – ' . date('d.m.Y', strtotime($datum_dolaska));
  }

  $nocenja_label = '';
  if ($broj_nocenja) {
      $nocenja_label = $broj_nocenja == 1 ? '1 noćenje' : $broj_nocenja . ' noćenja';
  }
@endphp

<article class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-neutral-100 flex flex-col">

  <a href="{{ get_permalink() }}" class="block">

    <div class="relative aspect-[16/10] overflow-hidden bg-neutral-100">
      @if(has_post_thumbnail())
        {!! get_the_post_thumbnail(get_the_ID(), 'trip-card', [
          'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500',
          'sizes' => '(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw',
          'loading' => 'lazy',
          'decoding' => 'async',
        ]) !!}
      @else
        <img src="@asset('resources/images/woman-traveling-in-barcelona-3.webp')"
             alt=""
             loading="lazy"
             decoding="async"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
      @endif

      @if($has_limit && $slobodno <= 0)
        <span class="absolute top-3 right-3 z-10 inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-gradient-to-r from-red-600 to-red-700 text-white text-xs font-bold shadow-lg shadow-red-500/30 ring-1 ring-white/20">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3.5 h-3.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
          </svg>
          Rasprodato
        </span>
      @elseif($has_limit && $slobodno <= 3)
        <span class="absolute top-3 right-3 z-10 inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-gradient-to-r from-bagdala-orange to-amber-500 text-white text-xs font-bold shadow-lg shadow-bagdala-orange/40 ring-1 ring-white/30 animate-pulse">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
            <path fill-rule="evenodd" d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.176 7.547 7.547 0 0 1-1.705-1.715.75.75 0 0 0-1.152-.082A9 9 0 1 0 15.68 4.534a7.46 7.46 0 0 1-2.717-2.248ZM15.75 14.25a3.75 3.75 0 1 1-7.313-1.172c.628.465 1.35.81 2.133 1a5.99 5.99 0 0 1 1.925-3.545 3.75 3.75 0 0 1 3.255 3.717Z" clip-rule="evenodd" />
          </svg>
          {{ $istaknuto ?: 'Još ' . $slobodno . ' ' . ($slobodno === 1 ? 'mesto' : 'mesta') . '!' }}
        </span>
      @elseif($has_limit)
        <span class="absolute top-3 right-3 z-10 inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-gradient-to-r from-bagdala-blue to-bagdala-blue-light text-white text-xs font-semibold shadow-lg shadow-bagdala-blue/30 ring-1 ring-white/20">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5 text-bagdala-orange">
            <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
          </svg>
          {{ $istaknuto ?: 'Slobodno ' . $slobodno . ' mesta' }}
        </span>
      @elseif($istaknuto)
        <span class="absolute top-3 right-3 z-10 inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-gradient-to-r from-bagdala-orange to-amber-500 text-white text-xs font-bold shadow-lg shadow-bagdala-orange/40 ring-1 ring-white/30">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
            <path fill-rule="evenodd" d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.176 7.547 7.547 0 0 1-1.705-1.715.75.75 0 0 0-1.152-.082A9 9 0 1 0 15.68 4.534a7.46 7.46 0 0 1-2.717-2.248ZM15.75 14.25a3.75 3.75 0 1 1-7.313-1.172c.628.465 1.35.81 2.133 1a5.99 5.99 0 0 1 1.925-3.545 3.75 3.75 0 0 1 3.255 3.717Z" clip-rule="evenodd" />
          </svg>
          {{ $istaknuto }}
        </span>
      @endif
    </div>

    <div class="p-6 pb-0">

      @if($gradovi && !is_wp_error($gradovi))
        <p class="text-bagdala-orange font-semibold text-sm uppercase tracking-wide mb-1">
          {{ $gradovi[0]->name }}
        </p>
      @endif

      <h3 class="text-lg font-semibold text-stone-900 mb-3 group-hover:text-bagdala-orange transition-colors">
        {{ get_the_title() }}
      </h3>

      @if($datum_formatiran)
        <div class="flex items-center gap-2 text-sm text-stone-600 mb-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
               stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-bagdala-blue">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
          </svg>
          {{ $datum_formatiran }}
        </div>
      @endif

      @if($nocenja_label)
        <div class="flex items-center gap-2 text-sm text-stone-600 mb-3">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
               stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-bagdala-blue">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
          </svg>
          {{ $nocenja_label }}
        </div>
      @endif

      @if($napomena)
        <p class="text-sm text-stone-500 italic mb-3">
          {{ $napomena }}
        </p>
      @endif

      <div class="flex items-center justify-between pt-3 border-t border-neutral-100">
        <span class="text-xl font-bold text-bagdala-blue">
          {{ $cena }} €
        </span>
        <span class="text-bagdala-orange font-semibold text-sm flex items-center gap-1 group-hover:gap-2 transition-all">
          Detalji
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
               stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
          </svg>
        </span>
      </div>

    </div>
  </a>

  <div class="p-6 pt-4 mt-auto">
    @if($has_limit && $slobodno <= 0)
      <span class="inline-flex items-center justify-center gap-1.5 w-full px-4 py-2.5 rounded-full bg-stone-200 text-stone-500 font-semibold text-sm cursor-not-allowed">
        Rasprodato
      </span>
    @else
      <button type="button"
              data-reservation-open
              data-trip-id="{{ $putovanje_id }}"
              data-trip-title="{{ get_the_title() }}"
              data-trip-dates="{{ $datum_formatiran }}"
              class="inline-flex items-center justify-center gap-1.5 w-full px-4 py-2.5 rounded-full bg-bagdala-blue hover:bg-bagdala-blue-light text-white font-semibold text-sm transition-colors cursor-pointer">
        Rezerviši
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
        </svg>
      </button>
    @endif
  </div>

</article>