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

            @if($cena)
              <div class="pt-4 border-t border-neutral-200">
                <p class="text-3xl font-display text-bagdala-blue">{{ $cena }} €</p>
              </div>
            @endif

            <a href="{{ home_url('/kontakt') }}"
               class="block w-full text-center bg-bagdala-orange hover:bg-bagdala-orange-dark text-stone-900 font-semibold py-3 rounded-full transition-colors mt-3">
              Rezerviši
            </a>

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
<section class="bg-bagdala-blue py-16">
  <div class="max-w-4xl mx-auto px-6 text-center">
    <h2 class="text-3xl md:text-4xl font-display text-white mb-4">
      Zainteresovani za ovo putovanje?
    </h2>
    <p class="text-white/80 mb-8 max-w-2xl mx-auto">
      Kontaktirajte nas za rezervaciju ili dodatne informacije.
    </p>
    <a href="{{ home_url('/kontakt') }}"
       class="inline-flex items-center gap-2 bg-bagdala-orange hover:bg-bagdala-orange-dark text-stone-900 font-semibold px-8 py-4 rounded-full transition-colors">
      Kontaktiraj nas
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
      </svg>
    </a>
  </div>
</section>

@endsection