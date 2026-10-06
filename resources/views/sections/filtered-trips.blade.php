@php
  $selected_kategorije = isset($_GET['kategorija']) && is_array($_GET['kategorija'])
    ? array_map('sanitize_text_field', $_GET['kategorija'])
    : [];
  $selected_gradovi = isset($_GET['bg_grad']) && is_array($_GET['bg_grad'])
    ? array_map('sanitize_text_field', $_GET['bg_grad'])
    : [];
  $search_q    = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';
  $search_date = isset($_GET['date']) ? sanitize_text_field($_GET['date']) : '';

  $has_filter = !empty($selected_kategorije)
             || !empty($selected_gradovi)
             || !empty($search_q)
             || !empty($search_date);

  $args = [
    'post_type'      => 'putovanje',
    'posts_per_page' => -1,
  ];

  if (!empty($search_q)) {
    $args['s'] = $search_q;
  }

  if (!empty($search_date)) {
    $args['meta_query'] = [[
      'key'     => 'datum_polaska',
      'value'   => $search_date,
      'compare' => '>=',
      'type'    => 'DATE',
    ]];
  }

  $tax_query = ['relation' => 'AND'];
  if (!empty($selected_kategorije)) {
    $tax_query[] = [
      'taxonomy' => 'kategorija_putovanja',
      'field'    => 'slug',
      'terms'    => $selected_kategorije,
    ];
  }
  if (!empty($selected_gradovi)) {
    $tax_query[] = [
      'taxonomy' => 'grad',
      'field'    => 'slug',
      'terms'    => $selected_gradovi,
    ];
  }
  if (count($tax_query) > 1) {
    $args['tax_query'] = $tax_query;
  }

  $putovanja = new WP_Query($args);
@endphp

<section id="ponuda" class="bg-neutral-50 py-16">
  <div class="max-w-7xl mx-auto px-6">

    <div class="text-center mb-12">
      <h2 class="text-3xl md:text-4xl font-display text-bagdala-blue mb-4">
        {{ $has_filter ? 'Rezultati pretrage' : 'Pronadji svoje putovanje' }}
      </h2>
      <div class="w-20 h-1 bg-bagdala-orange mx-auto rounded-full mb-4"></div>
      <p class="text-stone-600 max-w-2xl mx-auto">
        {{ $has_filter ? 'Prikazujemo putovanja po vašim filterima.' : 'Filtriraj po tipu putovanja ili destinaciji, ili pregledaj ponudu ispod.' }}
      </p>

      @if(!empty($search_q) || !empty($search_date))
        <div class="mt-6 inline-flex flex-wrap items-center gap-3 text-sm">
          @if(!empty($search_q))
            <span class="inline-flex items-center gap-2 bg-white border border-neutral-200 rounded-full px-4 py-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-bagdala-orange">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
              </svg>
              <strong>{{ $search_q }}</strong>
            </span>
          @endif
          @if(!empty($search_date))
            <span class="inline-flex items-center gap-2 bg-white border border-neutral-200 rounded-full px-4 py-2">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-bagdala-orange">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
              </svg>
              od <strong>{{ date('d.m.Y', strtotime($search_date)) }}</strong>
            </span>
          @endif
          <a href="{{ home_url('/') }}#ponuda"
             class="text-stone-500 hover:text-bagdala-orange underline transition-colors">
            Obriši
          </a>
        </div>
      @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

      <aside class="lg:col-span-1">
        @include('partials.filters')
      </aside>

      <div class="lg:col-span-3">
        @if($has_filter)
          @if($putovanja->have_posts())
            <div class="mb-6 text-sm text-stone-600">
              Prikazano <strong>{{ $putovanja->found_posts }}</strong>
              {{ $putovanja->found_posts == 1 ? 'putovanje' : 'putovanja' }}
              po vašim filterima.
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              @while($putovanja->have_posts()) @php($putovanja->the_post())
                @include('partials.card-trip')
              @endwhile
            </div>
            @php(wp_reset_postdata())
          @else
            <div class="bg-white rounded-2xl p-12 text-center border border-neutral-200">
              <p class="text-stone-500 mb-4">Nema putovanja koja odgovaraju pretrazi.</p>
              <a href="{{ home_url('/') }}#ponuda"
                 class="inline-block text-bagdala-orange hover:text-bagdala-orange-dark font-semibold transition-colors">
                Prikaži sve ponude
              </a>
            </div>
          @endif
        @else
          @include('sections.trips')
        @endif
      </div>

    </div>
  </div>
</section>