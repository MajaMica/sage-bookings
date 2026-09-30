@php
  $sekcije = get_field('sekcije', 'option');
@endphp

@if($sekcije)
  @foreach($sekcije as $sekcija)
    @php
      $args = [
        'post_type'      => 'putovanje',
        'posts_per_page' => $sekcija['broj'] ?: 6,
        'meta_key'       => 'datum_polaska',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
      ];

      if (!empty($sekcija['kategorija'])) {
  $terms = is_array($sekcija['kategorija'])
    ? $sekcija['kategorija']
    : [$sekcija['kategorija']];

  $args['tax_query'] = [[
    'taxonomy' => 'kategorija_putovanja',
    'field'    => 'term_id',
    'terms'    => $terms,
  ]];
}

      $putovanja = new WP_Query($args);
    @endphp

    @if($putovanja->have_posts())
      <section class="bg-white py-10">
        <div class="max-w-7xl mx-auto px-6">

          <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-display text-bagdala-blue">
              {{ $sekcija['naslov'] }}
            </h2>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @while($putovanja->have_posts()) @php($putovanja->the_post())
              @include('partials.card-trip')
            @endwhile
          </div>

          @if(!empty($sekcija['link']))
            <div class="text-center mt-12">
              <a href="{{ $sekcija['link'] }}"
                 class="inline-flex items-center gap-2 border-2 border-bagdala-orange text-bagdala-orange hover:bg-bagdala-orange hover:text-white font-semibold px-8 py-3 rounded-full transition-colors">
                Vidi sve
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                  <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
              </a>
            </div>
          @endif

        </div>
      </section>
    @endif
    @php(wp_reset_postdata())
  @endforeach
@endif