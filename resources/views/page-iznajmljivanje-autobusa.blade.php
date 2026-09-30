@extends('layouts.app')

@section('content')

@php
  $hero_url = get_theme_file_uri('resources/images/bus1.webp');
  $bus1_url = get_theme_file_uri('resources/images/bus1.webp');
  $bus2_url = get_theme_file_uri('resources/images/bus2.webp');

  $email       = 'bagdalatravel@gmail.com';
  $phone_wa    = '381600455232';
  $phone_viber = '381600455232';
  $phone_1     = '060/04-55-232';
  $phone_2     = '060/44-55-230';
  $phone_1_tel = '+381600455232';
  $phone_2_tel = '+381604455230';

  $status = $_GET['contact'] ?? '';
@endphp

{{-- HERO --}}
<section class="relative overflow-hidden"
         style="height: 420px; background-image: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), url('{{ $hero_url }}'); background-size: cover; background-position: center;">
  <div class="relative z-10 h-full flex flex-col items-center justify-center px-6 pt-20">
    <h1 class="text-white text-4xl md:text-6xl lg:text-7xl font-display text-center mb-4"
        style="text-shadow: 0 4px 20px rgba(0,0,0,0.6);">
      Iznajmljivanje autobusa
    </h1>
    <p class="text-white/90 text-lg md:text-xl text-center max-w-3xl" style="text-shadow: 0 2px 10px rgba(0,0,0,0.6);">
      Komfor i sigurnost sa vrhunski opremljenim autobusima — za sve vaše potrebe.
    </p>
  </div>
</section>

{{-- INFO BAR --}}
<div class="bg-cyan-100 py-3">
  <div class="max-w-7xl mx-auto px-6 flex items-center justify-center gap-3 text-sm text-stone-800">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-cyan-700 flex-shrink-0">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
    </svg>
    <span>Moderni autobusi • Iskusni vozači • Povoljne cene</span>
  </div>
</div>

{{-- UVOD + FLEET --}}
<section class="bg-white py-20">
  <div class="max-w-7xl mx-auto px-6">

    <div class="text-center mb-14">
      <h2 class="text-3xl md:text-4xl lg:text-5xl font-display text-bagdala-blue mb-4">
        Vaš prevoz na putu
      </h2>
      <div class="w-20 h-1 bg-bagdala-orange mx-auto rounded-full mb-5"></div>
      <p class="text-stone-600 text-lg max-w-3xl mx-auto leading-relaxed">
        Bagdala Travel vam nudi uslugu iznajmljivanja autobusa za sve vaše potrebe — od izleta,
        višednevnih putovanja, do transfera i organizovanih grupnih putovanja. Bez obzira na
        destinaciju, naši moderni autobusi sa iskusnim vozačima garantuju udobno i sigurno putovanje.
      </p>
    </div>

    {{-- BUS IMAGES --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
      <div class="group overflow-hidden rounded-2xl shadow-lg">
        <img src="{{ $bus1_url }}" alt="Bagdala Travel autobus"
             class="w-full h-72 md:h-96 object-cover group-hover:scale-105 transition-transform duration-700">
      </div>
      <div class="group overflow-hidden rounded-2xl shadow-lg">
        <img src="{{ $bus2_url }}" alt="Bagdala Travel autobus"
             class="w-full h-72 md:h-96 object-cover group-hover:scale-105 transition-transform duration-700">
      </div>
    </div>

    {{-- FEATURES --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">

      <div class="bg-neutral-50 rounded-2xl p-8 text-center hover:shadow-lg transition-shadow">
        <div class="w-16 h-16 mx-auto mb-5 rounded-full bg-bagdala-orange/10 flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-8 h-8 text-bagdala-orange">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
          </svg>
        </div>
        <h3 class="text-xl font-display text-bagdala-blue mb-3">Udobnost</h3>
        <p class="text-stone-600 text-sm leading-relaxed">
          Klimatizovani autobusi sa udobnim sedištima, dovoljno prostora za noge i veliki prtljažnik.
        </p>
      </div>

      <div class="bg-neutral-50 rounded-2xl p-8 text-center hover:shadow-lg transition-shadow">
        <div class="w-16 h-16 mx-auto mb-5 rounded-full bg-bagdala-orange/10 flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-8 h-8 text-bagdala-orange">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
          </svg>
        </div>
        <h3 class="text-xl font-display text-bagdala-blue mb-3">Sigurnost</h3>
        <p class="text-stone-600 text-sm leading-relaxed">
          Iskusni vozači sa dugogodišnjim iskustvom, redovno servisirana vozila i potpuna dokumentacija.
        </p>
      </div>

      <div class="bg-neutral-50 rounded-2xl p-8 text-center hover:shadow-lg transition-shadow">
        <div class="w-16 h-16 mx-auto mb-5 rounded-full bg-bagdala-orange/10 flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-8 h-8 text-bagdala-orange">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
          </svg>
        </div>
        <h3 class="text-xl font-display text-bagdala-blue mb-3">Prilagodljivost</h3>
        <p class="text-stone-600 text-sm leading-relaxed">
          Organizujemo prevoz prema vašim željama — jednodnevni izleti, višednevna putovanja, transferi.
        </p>
      </div>

    </div>

    {{-- WHY US --}}
   <div class="bg-bagdala-blue rounded-2xl px-8 py-12 md:px-14 md:py-16 text-white">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-14 items-center">
    <div>
      <h2 class="text-3xl md:text-4xl font-display mb-8 leading-tight">Zašto izabrati Bagdala Travel?</h2>
          <ul class="space-y-4">
            <li class="flex items-start gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-bagdala-orange flex-shrink-0 mt-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
              </svg>
              <span>Preko 20 godina iskustva u turizmu</span>
            </li>
            <li class="flex items-start gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-bagdala-orange flex-shrink-0 mt-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
              </svg>
              <span>Licencirani prevoznici i osigurani putnici</span>
            </li>
            <li class="flex items-start gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-bagdala-orange flex-shrink-0 mt-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
              </svg>
              <span>Individualni pristup svakom klijentu</span>
            </li>
            <li class="flex items-start gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-bagdala-orange flex-shrink-0 mt-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
              </svg>
              <span>Povoljne cene i fleksibilni termini</span>
            </li>
          </ul>
        </div>

        <div class="text-center md:text-right">
          <p class="text-2xl md:text-3xl font-display mb-4">Spremni za polazak?</p>
          <p class="text-white/80 mb-6">Kontaktirajte nas i rezervišite vaš autobus već danas!</p>
          <a href="#kontakt-autobus"
             class="inline-flex items-center gap-2 bg-bagdala-orange hover:bg-bagdala-orange-dark text-stone-900 font-semibold px-8 py-4 rounded-full transition-all duration-300 hover:scale-105">
            Zatraži ponudu
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
          </a>
        </div>
      </div>
    </div>

  </div>
</section>

{{-- CONTACT FORM --}}
<section class="bg-neutral-50 py-20" id="kontakt-autobus">
  <div class="max-w-7xl mx-auto px-6">

    <div class="text-center mb-12">
      <h2 class="text-3xl md:text-4xl font-display text-bagdala-blue mb-4">
        Zatražite ponudu
      </h2>
      <div class="w-20 h-1 bg-bagdala-orange mx-auto rounded-full mb-5"></div>
      <p class="text-stone-600 text-lg max-w-2xl mx-auto">
        Popunite formu i kontaktiraćemo Vas u najkraćem roku sa ponudom.
      </p>
    </div>

    @if($status === 'success')
      <div class="max-w-3xl mx-auto mb-8 bg-green-50 border border-green-200 rounded-xl p-5 flex items-start gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <div>
          <p class="font-semibold text-green-800">Upit je poslat!</p>
          <p class="text-green-700 text-sm">Kontaktiraćemo Vas u najkraćem roku.</p>
        </div>
      </div>
    @elseif($status === 'error')
      <div class="max-w-3xl mx-auto mb-8 bg-red-50 border border-red-200 rounded-xl p-5 flex items-start gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
        </svg>
        <div>
          <p class="font-semibold text-red-800">Greška pri slanju</p>
          <p class="text-red-700 text-sm">Popunite obavezna polja (ime, email, poruka) i pokušajte ponovo.</p>
        </div>
      </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

      <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-lg border border-neutral-200 p-8 md:p-10">

          <form method="POST" action="{{ admin_url('admin-post.php') }}" class="space-y-5">
            <input type="hidden" name="action" value="bagdala_contact">
            @php(wp_nonce_field('bagdala_contact', 'bagdala_contact_nonce'))

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div>
                <label for="ime" class="block text-sm font-semibold text-stone-700 mb-2">
                  Ime i prezime <span class="text-bagdala-orange">*</span>
                </label>
                <input type="text" id="ime" name="ime" required
                       class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-bagdala-orange focus:ring-2 focus:ring-bagdala-orange/30 outline-none transition-all"
                       placeholder="Vaše ime">
              </div>
              <div>
                <label for="email" class="block text-sm font-semibold text-stone-700 mb-2">
                  Email <span class="text-bagdala-orange">*</span>
                </label>
                <input type="email" id="email" name="email" required
                       class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-bagdala-orange focus:ring-2 focus:ring-bagdala-orange/30 outline-none transition-all"
                       placeholder="vasa@email.com">
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div>
                <label for="telefon" class="block text-sm font-semibold text-stone-700 mb-2">Telefon</label>
                <input type="tel" id="telefon" name="telefon"
                       class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-bagdala-orange focus:ring-2 focus:ring-bagdala-orange/30 outline-none transition-all"
                       placeholder="060/00-00-000">
              </div>
              <div>
                <label for="putovanje" class="block text-sm font-semibold text-stone-700 mb-2">Destinacija / Tip prevoza</label>
                <input type="text" id="putovanje" name="putovanje"
                       class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-bagdala-orange focus:ring-2 focus:ring-bagdala-orange/30 outline-none transition-all"
                       placeholder="npr. transfer do aerodroma, izlet...">
              </div>
            </div>

            <div>
              <label for="poruka" class="block text-sm font-semibold text-stone-700 mb-2">
                Poruka <span class="text-bagdala-orange">*</span>
              </label>
              <textarea id="poruka" name="poruka" rows="5" required
                        class="w-full px-4 py-3 rounded-lg border border-neutral-300 focus:border-bagdala-orange focus:ring-2 focus:ring-bagdala-orange/30 outline-none transition-all resize-none"
                        placeholder="Opišite vaše potrebe — broj putnika, datum, relacija..."></textarea>
            </div>

            <button type="submit"
                    class="w-full md:w-auto bg-bagdala-orange hover:bg-bagdala-orange-dark text-stone-900 font-semibold px-10 py-4 rounded-full transition-all duration-300 hover:scale-105">
              Pošalji upit
            </button>

          </form>
        </div>
      </div>

      <aside class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-lg border border-neutral-200 overflow-hidden lg:sticky lg:top-32">

          <div class="bg-bagdala-orange px-6 py-4">
            <h3 class="text-stone-900 font-semibold text-lg">Kontakt informacije</h3>
          </div>

          <div class="p-6 space-y-5 text-sm">

            <div class="flex items-start gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-bagdala-orange flex-shrink-0 mt-0.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
              </svg>
              <span class="text-stone-700">Balkanska 36, 37000 Kruševac</span>
            </div>

            <div class="flex items-start gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-bagdala-orange flex-shrink-0 mt-0.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
              </svg>
              <a href="mailto:{{ $email }}" class="text-stone-700 hover:text-bagdala-orange transition-colors break-all">
                {{ $email }}
              </a>
            </div>

            <div class="flex items-start gap-3">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-5 h-5 text-bagdala-orange flex-shrink-0 mt-0.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
              </svg>
              <div class="flex flex-col gap-1">
                <a href="tel:{{ $phone_1_tel }}" class="text-stone-700 hover:text-bagdala-orange transition-colors">{{ $phone_1 }}</a>
                <a href="tel:{{ $phone_2_tel }}" class="text-stone-700 hover:text-bagdala-orange transition-colors">{{ $phone_2 }}</a>
              </div>
            </div>

            <div class="border-t border-neutral-200 pt-5">
              <p class="text-stone-500 mb-3 font-semibold uppercase tracking-wide text-xs">Piši nam direktno</p>
              <div class="flex items-center gap-3">
                <a href="https://wa.me/{{ $phone_wa }}" target="_blank" rel="noopener"
                   class="w-11 h-11 rounded-full bg-green-500 hover:bg-green-600 transition-colors flex items-center justify-center"
                   aria-label="WhatsApp">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" class="w-5 h-5">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                  </svg>
                </a>
                <a href="viber://chat?number=%2B{{ $phone_viber }}"
                   class="w-11 h-11 rounded-full bg-purple-600 hover:bg-purple-700 transition-colors flex items-center justify-center"
                   aria-label="Viber">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="white" viewBox="0 0 24 24" class="w-5 h-5">
                    <path d="M11.4 0C9.473.028 5.333.344 3.02 2.467 1.302 4.187.696 6.7.633 9.817c-.06 3.11-.13 8.945 5.48 10.535v2.405c0 .088.09 1.128 1.132.572l2.48-2.96c3.666.257 6.625-1.084 8.848-4.63l.008-.011c1.545-2.529 1.51-5.472 1.418-9.376-.025-.81-.088-2.945-.093-3.073-.088-1.99-.745-3.469-1.954-4.476C16.297.393 13.958.005 11.4 0z"/>
                  </svg>
                </a>
              </div>
            </div>

          </div>
        </div>
      </aside>

    </div>
  </div>
</section>

@endsection