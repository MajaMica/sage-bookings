@php
  $putovanje_id = get_the_ID();
  $ukupno       = get_field('ukupno_mesta', $putovanje_id);
  $rucno        = (int) get_field('rezervisano_rucno', $putovanje_id);
  $istaknuto    = get_field('istaknuto_mesta', $putovanje_id);
  $link         = get_permalink($putovanje_id) . '#rezervisi';

  $slobodno = 0;
  $has_limit = $ukupno !== null && $ukupno !== '' && (int) $ukupno > 0;

  if ($has_limit) {
    $web = function_exists('bagdala_count_web_reservations')
      ? bagdala_count_web_reservations($putovanje_id)
      : 0;
    $slobodno = max(0, (int) $ukupno - $web - $rucno);
  }
@endphp

@if($has_limit)
  <div class="mb-3">
    @if($slobodno <= 0)
      <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-red-600">
        <span class="w-2 h-2 rounded-full bg-red-500"></span>
        Rasprodato
      </span>
    @elseif($slobodno <= 3)
      <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-orange-600">
        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
        {{ $istaknuto ?: 'Još samo ' . $slobodno . ' ' . ($slobodno === 1 ? 'mesto' : 'mesta') . '!' }}
      </span>
    @else
      <span class="inline-flex items-center gap-1.5 text-sm font-medium text-green-700">
        <span class="w-2 h-2 rounded-full bg-green-500"></span>
        {{ $istaknuto ?: 'Slobodno ' . $slobodno . ' mesta' }}
      </span>
    @endif
  </div>
@elseif($istaknuto)
  <div class="mb-3">
    <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-orange-600">
      <span class="w-2 h-2 rounded-full bg-orange-500"></span>
      {{ $istaknuto }}
    </span>
  </div>
@endif

@if($slobodno <= 0 && $has_limit)
  <span class="inline-flex items-center justify-center gap-1.5 w-full px-4 py-2.5 rounded-full
               bg-stone-200 text-stone-500 font-semibold text-sm cursor-not-allowed">
    Rasprodato
  </span>
@else
  <a href="{{ $link }}"
     class="inline-flex items-center justify-center gap-1.5 w-full px-4 py-2.5 rounded-full
            bg-bagdala-blue hover:bg-bagdala-blue-light text-white font-semibold text-sm
            transition-colors">
    Rezerviši
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
         stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
      <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
    </svg>
  </a>
@endif