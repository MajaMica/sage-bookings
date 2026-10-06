<div id="reservation-modal"
     class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
     role="dialog"
     aria-modal="true"
     aria-labelledby="reservation-modal-title">

  <div class="relative w-full max-w-lg bg-white rounded-3xl shadow-2xl overflow-hidden max-h-[90vh] overflow-y-auto">

    <button type="button"
            data-reservation-close
            class="absolute top-4 right-4 z-10 w-9 h-9 flex items-center justify-center rounded-full bg-stone-100 hover:bg-stone-200 text-stone-600 transition-colors">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
      </svg>
    </button>

    <div class="px-6 pt-8 pb-6 bg-gradient-to-br from-bagdala-blue to-bagdala-blue-light text-white">
      <h2 id="reservation-modal-title" class="text-2xl font-bold font-display mb-1">
        Rezervacija
      </h2>
      <p data-reservation-trip-title class="text-white/80 text-sm"></p>
      <p data-reservation-trip-dates class="text-white/60 text-xs mt-1"></p>
    </div>

    <form data-reservation-form class="p-6 space-y-4">

      <input type="hidden" name="putovanje_id" value="">

      <div>
        <label class="block text-sm font-medium text-stone-700 mb-1.5">
          Ime i prezime <span class="text-red-500">*</span>
        </label>
        <input type="text" name="ime_prezime" required
               class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:border-bagdala-orange focus:ring-2 focus:ring-bagdala-orange/20 outline-none transition-all text-sm">
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-stone-700 mb-1.5">
            Email <span class="text-red-500">*</span>
          </label>
          <input type="email" name="email" required
                 class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:border-bagdala-orange focus:ring-2 focus:ring-bagdala-orange/20 outline-none transition-all text-sm">
        </div>
        <div>
          <label class="block text-sm font-medium text-stone-700 mb-1.5">
            Telefon <span class="text-red-500">*</span>
          </label>
          <input type="tel" name="telefon" required
                 class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:border-bagdala-orange focus:ring-2 focus:ring-bagdala-orange/20 outline-none transition-all text-sm">
        </div>
      </div>

      <div class="grid grid-cols-3 gap-3">
        <div>
          <label class="block text-sm font-medium text-stone-700 mb-1.5">Odrasli</label>
          <input type="number" name="broj_odraslih" min="1" value="1" required
                 class="w-full px-3 py-2.5 rounded-xl border border-stone-200 focus:border-bagdala-orange focus:ring-2 focus:ring-bagdala-orange/20 outline-none transition-all text-sm text-center">
        </div>
        <div>
          <label class="block text-sm font-medium text-stone-700 mb-1.5">Deca 6-12</label>
          <input type="number" name="broj_dece_6_12" min="0" value="0"
                 class="w-full px-3 py-2.5 rounded-xl border border-stone-200 focus:border-bagdala-orange focus:ring-2 focus:ring-bagdala-orange/20 outline-none transition-all text-sm text-center">
        </div>
        <div>
          <label class="block text-sm font-medium text-stone-700 mb-1.5">Deca do 6</label>
          <input type="number" name="broj_dece_do_6" min="0" value="0"
                 class="w-full px-3 py-2.5 rounded-xl border border-stone-200 focus:border-bagdala-orange focus:ring-2 focus:ring-bagdala-orange/20 outline-none transition-all text-sm text-center">
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-stone-700 mb-1.5">Napomena (opciono)</label>
        <textarea name="napomena" rows="3"
                  placeholder="npr. mesto do prozora, posebni zahtevi..."
                  class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:border-bagdala-orange focus:ring-2 focus:ring-bagdala-orange/20 outline-none transition-all text-sm resize-none"></textarea>
      </div>

      <div data-reservation-message class="hidden text-sm rounded-xl px-4 py-3"></div>

      <button type="submit"
              class="w-full px-6 py-3 rounded-full bg-bagdala-orange hover:bg-bagdala-orange-dark text-white font-semibold transition-colors flex items-center justify-center gap-2">
        <span data-reservation-submit-text>Pošalji rezervaciju</span>
        <svg data-reservation-spinner class="hidden animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
      </button>

      <p class="text-xs text-stone-500 text-center">
        Javićemo vam se uskoro radi potvrde rezervacije.
      </p>

    </form>
  </div>
</div>