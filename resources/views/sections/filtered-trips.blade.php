@php
  $selected_kategorije = isset($_GET['kategorija']) && is_array($_GET['kategorija'])
    ? array_map('sanitize_text_field', $_GET['kategorija'])
    : [];
  $selected_gradovi = isset($_GET['grad']) && is_array($_GET['grad'])
    ? array_map('sanitize_text_field', $_GET['grad'])
    : [];
  $has_filter = !empty($selected_kategorije) || !empty($selected_gradovi);

  $args = [
    'post_type'      => 'putovanje',
    'posts_per_page' => -1,
    'meta_key'       => 'datum_polaska',
    'orderby'        => 'meta_value',
    'order'          => 'ASC',
  ];

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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              @while($putovanja->have_posts()) @php($putovanja->the_post())
                @include('partials.card-trip')
              @endwhile
            </div>
            @php(wp_reset_postdata())
          @else
            <div class="bg-white rounded-2xl p-12 text-center border border-neutral-200">
              <p class="text-stone-500 mb-4">Nema putovanja koja odgovaraju filterima.</p>
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

@if($has_filter)
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const target = document.getElementById('ponuda');
      if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  </script>
@endif