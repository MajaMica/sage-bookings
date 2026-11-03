@php
  $selected_kategorije = isset($_GET['kategorija']) && is_array($_GET['kategorija'])
    ? array_map('sanitize_text_field', $_GET['kategorija'])
    : [];
  $selected_gradovi = isset($_GET['bg_grad']) && is_array($_GET['bg_grad'])
    ? array_map('sanitize_text_field', $_GET['bg_grad'])
    : [];

  $sve_kategorije = get_terms(['taxonomy' => 'kategorija_putovanja', 'hide_empty' => true]);
  $svi_gradovi = get_terms(['taxonomy' => 'grad', 'hide_empty' => true]);
@endphp

<form method="GET" action="{{ home_url('/') }}#ponuda" class="bg-white rounded-2xl border border-neutral-200 p-6 space-y-6 lg:sticky lg:top-32">

  <div>
    <h2 class="font-display text-lg text-bagdala-blue">Filteri pretrage</h2>
  </div>

  @if(!is_wp_error($sve_kategorije) && !empty($sve_kategorije))
    <details open class="border-t border-neutral-200 pt-5">
      <summary class="cursor-pointer flex items-center justify-between font-semibold text-stone-900 hover:text-bagdala-orange transition-colors list-none">
        <span class="flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
               stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-bagdala-orange">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
          </svg>
          Tip putovanja
        </span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
          <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
      </summary>
      <div class="mt-4 space-y-2.5">
        @foreach($sve_kategorije as $kat)
          <label class="flex items-center gap-3 cursor-pointer group">
            <input type="checkbox"
                   name="kategorija[]"
                   value="{{ $kat->slug }}"
                   {{ in_array($kat->slug, $selected_kategorije) ? 'checked' : '' }}
                   class="w-4 h-4 rounded border-stone-400 accent-[#E87B3A]">
            <span class="text-sm text-stone-700 group-hover:text-bagdala-orange transition-colors">
              {{ $kat->name }}
            </span>
          </label>
        @endforeach
      </div>
    </details>
  @endif

  @if(!is_wp_error($svi_gradovi) && !empty($svi_gradovi))
    <details open class="border-t border-neutral-200 pt-5">
      <summary class="cursor-pointer flex items-center justify-between font-semibold text-stone-900 hover:text-bagdala-orange transition-colors list-none">
        <span class="flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
               stroke-width="1.8" stroke="currentColor" class="w-4 h-4 text-bagdala-orange">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
          </svg>
          Destinacija
        </span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
             stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
          <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
      </summary>
      <div class="mt-4 space-y-2.5 max-h-64 overflow-y-auto pr-1">
        @foreach($svi_gradovi as $grad)
          <label class="flex items-center gap-3 cursor-pointer group">
            <input type="checkbox"
                   name="bg_grad[]"
                   value="{{ $grad->slug }}"
                   {{ in_array($grad->slug, $selected_gradovi) ? 'checked' : '' }}
                   class="w-4 h-4 rounded border-stone-400 accent-[#E87B3A]">
            <span class="text-sm text-stone-700 group-hover:text-bagdala-orange transition-colors">
              {{ $grad->name }}
            </span>
          </label>
        @endforeach
      </div>
    </details>
  @endif

  <div class="border-t border-neutral-200 pt-5 space-y-3">
    <button type="submit"
            class="w-full bg-bagdala-orange hover:bg-bagdala-orange-dark text-stone-900 font-semibold py-3 rounded-full transition-all duration-300 hover:scale-105 flex items-center justify-center gap-2">
      Pretraži
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
           stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
      </svg>
    </button>

    @if(!empty($selected_kategorije) || !empty($selected_gradovi))
      <a href="{{ home_url('/') }}#ponuda"
         class="block text-center text-sm text-stone-500 hover:text-bagdala-orange transition-colors">
        Obriši filtere
      </a>
    @endif
  </div>

</form>