@php
  $cena           = get_field('cena');
  $datum_polaska  = get_field('datum_polaska');
  $datum_dolaska  = get_field('datum_dolaska');
  $broj_nocenja   = get_field('broj_nocenja');
  $napomena       = get_field('napomena');
  $gradovi        = get_the_terms(get_the_ID(), 'grad');

  $datum_formatiran = '';
  if ($datum_polaska && $datum_dolaska) {
      $datum_formatiran = date('d.m', strtotime($datum_polaska)) . ' – ' . date('d.m.Y', strtotime($datum_dolaska));
  }

  $nocenja_label = '';
  if ($broj_nocenja) {
      if ($broj_nocenja == 1) {
          $nocenja_label = '1 noćenje';
      } else {
          $nocenja_label = $broj_nocenja . ' noćenja';
      }
  }
@endphp

<article class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-neutral-100">
  <a href="{{ get_permalink() }}" class="block">

    <div class="aspect-[16/10] overflow-hidden bg-neutral-100">
      @if(has_post_thumbnail())
        {!! get_the_post_thumbnail(get_the_ID(), 'medium_large', [
          'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500'
        ]) !!}
      @else
        <img src="@asset('resources/images/woman-traveling-in-barcelona-3.webp')"
             alt=""
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
      @endif
    </div>

    <div class="p-6">

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
</article>