@extends('layouts.app')

@section('content')

@php
  $gradovi       = get_the_terms(get_the_ID(), 'grad');
  $cena          = get_field('cena');
  $datum_polaska = get_field('datum_polaska');
  $datum_dolaska = get_field('datum_dolaska');
  $broj_nocenja  = get_field('broj_nocenja');
  $napomena      = get_field('napomena');
  $program       = get_field('program');
  $galerija      = get_field('galerija');

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

  $grad_name = ($gradovi && !is_wp_error($gradovi)) ? $gradovi[0]->name : '';

  $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
  if (!$thumb_url) {
      $thumb_url = get_theme_file_uri('resources/images/woman-traveling-in-barcelona-3.webp');
  }

  $datum_format = '';
  if ($datum_polaska && $datum_dolaska) {
      $datum_format = date('d.m.Y', strtotime($datum_polaska)) . ' – ' . date('d.m.Y', strtotime($datum_dolaska));
  }

  $nocenja_label = '';
  if ($broj_nocenja == 1) {
      $nocenja_label = '1 noćenje';
  } elseif ($broj_nocenja > 1) {
      $nocenja_label = $broj_nocenja . ' noćenja';
  }
@endphp

{{-- HERO --}}
<section class="relative overflow-hidden"
         style="height: 500px; background-image: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), url('{{ $thumb_url }}'); background-size: cover; background-position: center;">
  <div class="relative z-10 h-full flex items-center justify-center px-6 pt-24">
    <h1 class="text-white text-4xl md:text-6xl lg:text-7xl font-display text-center leading-tight max-w-5xl"
        style="text-shadow: 0 4px 20px rgba(0,0,0,0.6);">
      {{ get_the_title() }}
    </h1>
  </div>
</section>

{{-- INFO BAR --}}
<div class="bg-cyan-100 py-3">
  <div class="max-w-7xl mx-auto px-6 flex items-center justify-center gap-3 text-sm text-stone-800">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-cyan-700 flex-shrink-0">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
      <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
    </svg>
    <span>{{ $grad_name ?: 'Detalji putovanja' }}@if($datum_format) — {{ $datum_format }}@endif</span>
  </div>
</div>

{{-- MAIN CONTENT --}}
<section class="bg-white py-16">
  <div class="max-w-7xl mx-auto px-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

      {{-- LEFT --}}
      <div class="lg:col-span-2">

        @if($grad_name)
          <p class="text-bagdala-orange text-lg font-bold tracking-wide mb-3">
            {{ $grad_name }}
          </p>
        @endif

        <h1 class="text-3xl md:text-4xl font-display text-stone-800 tracking-wide mb-8 leading-tight">
          {{ get_the_title() }}
        </h1>

      @if($program)
  <div class="program-content">
    {!! $program !!}
  </div>
@else
  <p class="text-stone-500 italic">Program putovanja još nije unet.</p>
@endif

      </div>

      {{-- RIGHT: SIDEBAR --}}
      <aside class="lg:col-span-1">
        <div class="bg-white rounded-xl overflow-hidden lg:sticky lg:top-32"
             style="box-shadow: 0 6px 11px 0 rgba(0,0,0,0.10); border: 1px solid #e5e5e5;">

          <div class="bg-bagdala-orange px-6 py-3">
            <h3 class="text-stone-900 font-semibold text-base">Sve informacije:</h3>
          </div>

          <div class="px-6 py-5 space-y-3">

            @if($datum_format)
              <div class="flex items-center gap-3 text-sm text-stone-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
                <span>{{ $datum_format }}</span>
              </div>
            @endif

            @if($nocenja_label)
              <div class="flex items-center gap-3 text-sm text-stone-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>{{ $nocenja_label }}</span>
              </div>
            @endif

            @if($napomena)
              <div class="flex items-start gap-3 text-sm text-stone-800">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-bagdala-orange flex-shrink-0 mt-0.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
                <span>{{ $napomena }}</span>
              </div>
            @endif

            {{-- SEATS INFO --}}
            @if($has_limit && $slobodno <= 0)
              <div class="flex items-center gap-3 text-sm font-semibold text-red-600 pt-2 border-t border-neutral-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
                <span>Rasprodato</span>
              </div>
            @elseif($has_limit && $slobodno <= 3)
              <div class="flex items-center gap-3 text-sm font-semibold text-bagdala-orange pt-2 border-t border-neutral-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                </svg>
                <span>{{ $istaknuto ?: 'Još ' . $slobodno . ' ' . ($slobodno === 1 ? 'mesto' : 'mesta') }}</span>
              </div>
            @elseif($has_limit)
              <div class="flex items-center gap-3 text-sm font-semibold text-green-700 pt-2 border-t border-neutral-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                <span>{{ $istaknuto ?: 'Slobodno ' . $slobodno . ' mesta' }}</span>
              </div>
            @elseif($istaknuto)
              <div class="flex items-center gap-3 text-sm font-semibold text-bagdala-orange pt-2 border-t border-neutral-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 flex-shrink-0">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0 1 12 21 8.25 8.25 0 0 1 6.038 7.047 8.287 8.287 0 0 0 9 9.601a8.983 8.983 0 0 1 3.361-6.867 8.21 8.21 0 0 0 3 2.48Z" />
                </svg>
                <span>{{ $istaknuto }}</span>
              </div>
            @endif

            @if($cena)
              <div class="pt-4 border-t border-neutral-200">
                <p class="text-3xl font-display text-bagdala-blue">{{ $cena }} €</p>
              </div>
            @endif

            @if($has_limit && $slobodno <= 0)
              <span class="block w-full text-center bg-stone-200 text-stone-500 font-semibold py-3 rounded-full mt-3 cursor-not-allowed">
                Rasprodato
              </span>
            @else
              <button type="button"
                      data-reservation-open
                      data-trip-id="{{ $putovanje_id }}"
                      data-trip-title="{{ get_the_title() }}"
                      data-trip-dates="{{ $datum_format }}"
                      class="block w-full text-center bg-bagdala-orange hover:bg-bagdala-orange-dark text-stone-900 font-semibold py-3 rounded-full transition-colors mt-3 cursor-pointer">
                Rezerviši
              </button>
            @endif

          </div>
        </div>
      </aside>

    </div>
  </div>
</section>

{{-- GALLERY --}}
<section class="bg-neutral-50 py-16">
  <div class="max-w-7xl mx-auto px-6">

    <div class="text-center mb-10">
      <h2 class="text-3xl md:text-4xl font-display text-bagdala-blue mb-4">Galerija</h2>
      <div class="w-20 h-1 bg-bagdala-orange mx-auto rounded-full"></div>
    </div>

    @if($galerija && is_array($galerija) && count($galerija) > 0)
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($galerija as $slika)
          <a href="{{ $slika['url'] }}" target="_blank"
             class="group block aspect-square overflow-hidden rounded-xl bg-neutral-100">
            <img src="{{ $slika['sizes']['medium_large'] ?? $slika['url'] }}"
                 alt="{{ $slika['alt'] }}"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
          </a>
        @endforeach
      </div>
    @else
      <div class="rounded-xl overflow-hidden">
        <img src="{{ $thumb_url }}" alt="" class="w-full h-auto">
      </div>
    @endif

  </div>
</section>

{{-- CTA --}}
<section class="relative overflow-hidden bg-gradient-to-br from-bagdala-blue via-bagdala-blue to-bagdala-blue-light py-20">

  {{-- Decorative blur circles --}}
  <div class="absolute -top-20 -left-20 w-80 h-80 rounded-full bg-bagdala-orange/20 blur-3xl pointer-events-none"></div>
  <div class="absolute -bottom-20 -right-20 w-96 h-96 rounded-full bg-bagdala-orange/10 blur-3xl pointer-events-none"></div>

  {{-- Subtle grid pattern --}}
  <div class="absolute inset-0 opacity-[0.04] pointer-events-none"
       style="background-image: linear-gradient(white 1px, transparent 1px), linear-gradient(90deg, white 1px, transparent 1px); background-size: 40px 40px;"></div>

  <div class="relative max-w-4xl mx-auto px-6 text-center">

    <h2 class="text-3xl md:text-4xl lg:text-5xl font-display text-white mb-5 leading-tight">
      Zainteresovani za ovo putovanje?
    </h2>

    <p class="text-white/70 text-lg mb-10 max-w-2xl mx-auto">
      Rezervišite svoje mesto ili nas kontaktirajte za dodatne informacije.
    </p>

    @if($has_limit && $slobodno <= 0)
      <span class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 text-white/60 font-semibold px-8 py-4 rounded-full cursor-not-allowed">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
          <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
        </svg>
        Rasprodato
      </span>
    @else
      <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <button type="button"
                data-reservation-open
                data-trip-id="{{ $putovanje_id }}"
                data-trip-title="{{ get_the_title() }}"
                data-trip-dates="{{ $datum_format }}"
                class="inline-flex items-center gap-2 bg-bagdala-orange hover:bg-bagdala-orange-dark text-white font-semibold px-8 py-4 rounded-full transition-all duration-300 shadow-lg shadow-bagdala-orange/30 hover:shadow-bagdala-orange/50 hover:scale-[1.02] cursor-pointer">
          Rezerviši
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
          </svg>
        </button>

        <a href="{{ home_url('/kontakt') }}"
           class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 hover:bg-white/20 hover:border-white/30 text-white font-semibold px-8 py-4 rounded-full transition-all duration-300">
          Kontaktiraj nas
        </a>
      </div>
    @endif

  </div>
</section>

@endsection