// Import assets
import.meta.glob(['../images/**', '../fonts/**']);

document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('reservation-modal');
  if (!modal) return;

  const form        = modal.querySelector('[data-reservation-form]');
  const message     = modal.querySelector('[data-reservation-message]');
  const submitBtn   = form.querySelector('button[type="submit"]');
  const submitText  = modal.querySelector('[data-reservation-submit-text]');
  const spinner     = modal.querySelector('[data-reservation-spinner]');
  const tripIdInput = form.querySelector('input[name="putovanje_id"]');
  const tripTitle   = modal.querySelector('[data-reservation-trip-title]');
  const tripDates   = modal.querySelector('[data-reservation-trip-dates]');

  
  function openModal(data) {
    tripIdInput.value = data.tripId;
    tripTitle.textContent = data.tripTitle;
    tripDates.textContent = data.tripDates || '';

    message.classList.add('hidden');
    form.reset();
    tripIdInput.value = data.tripId;
        renderPassengers();

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
  }


  function closeModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
  }

  document.addEventListener('click', function (e) {
    const openBtn = e.target.closest('[data-reservation-open]');
    if (openBtn) {
      e.preventDefault();
      openModal({
        tripId:    openBtn.dataset.tripId,
        tripTitle: openBtn.dataset.tripTitle,
        tripDates: openBtn.dataset.tripDates,
      });
    }

    if (e.target.closest('[data-reservation-close]') || e.target === modal) {
      closeModal();
    }
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
      closeModal();
    }
  });
  const adultsInput    = form.querySelector('[data-adults]');
  const childrenInput  = form.querySelector('[data-children]');
  const toddlersInput  = form.querySelector('[data-toddlers]');
  const passContainer  = form.querySelector('[data-passengers-container]');

  function createPassengerField(idx, tip, label) {
    const wrap = document.createElement('div');
    wrap.innerHTML = `
      <label class="block text-sm font-medium text-stone-700 mb-1.5">${label}</label>
      <input type="text" name="putnici[${idx}][ime_prezime]" required
             placeholder="Ime i prezime"
             class="w-full px-4 py-2.5 rounded-xl border border-stone-200 focus:border-bagdala-orange focus:ring-2 focus:ring-bagdala-orange/20 outline-none transition-all text-sm text-stone-900">
      <input type="hidden" name="putnici[${idx}][tip]" value="${tip}">
    `;
    return wrap;
  }

    function renderPassengers() {
    if (!passContainer) return;
    const adults   = Math.max(1, parseInt(adultsInput.value)   || 1);
    const children = Math.max(0, parseInt(childrenInput.value) || 0);
    const toddlers = Math.max(0, parseInt(toddlersInput.value) || 0);

    const saved = [];
    passContainer.querySelectorAll('input[type="text"]').forEach(el => saved.push(el.value));

    passContainer.innerHTML = '';
    let idx = 0;

    const extraAdults = adults - 1;

    for (let i = 0; i < extraAdults; i++) {
      passContainer.appendChild(createPassengerField(idx++, 'odrastao', `Odrastao putnik ${i + 2}`));
    }
    for (let i = 0; i < children; i++) {
      passContainer.appendChild(createPassengerField(idx++, 'dete_6_12', `Dete 6-12 (${i + 1})`));
    }
    for (let i = 0; i < toddlers; i++) {
      passContainer.appendChild(createPassengerField(idx++, 'dete_do_6', `Dete do 6 (${i + 1})`));
    }

    passContainer.querySelectorAll('input[type="text"]').forEach((el, i) => {
      if (saved[i] !== undefined) el.value = saved[i];
    });
  }

  adultsInput?.addEventListener('input', renderPassengers);
  childrenInput?.addEventListener('input', renderPassengers);
  toddlersInput?.addEventListener('input', renderPassengers);
  
  form.addEventListener('submit', async function (e) {
    e.preventDefault();

    message.classList.add('hidden');
    submitBtn.disabled = true;
    submitText.textContent = 'Šaljem...';
    spinner.classList.remove('hidden');

    const formData = new FormData(form);
    formData.append('action', 'bagdala_submit_reservation');
    formData.append('nonce', window.bagdalaReservation?.nonce || '');

    try {
      const response = await fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: formData,
      });
      const data = await response.json();

      message.classList.remove('hidden', 'bg-green-50', 'text-green-700', 'bg-red-50', 'text-red-700');

      if (data.success) {
        message.classList.add('bg-green-50', 'text-green-700');
        message.textContent = data.data.message || 'Rezervacija primljena.';
        form.reset();
        setTimeout(closeModal, 3000);
      } else {
        message.classList.add('bg-red-50', 'text-red-700');
        message.textContent = data.data?.message || 'Greška. Pokušajte ponovo.';
      }
    } catch (err) {
      message.classList.remove('hidden');
      message.classList.add('bg-red-50', 'text-red-700');
      message.textContent = 'Greška u komunikaciji. Pokušajte ponovo.';
    } finally {
      submitBtn.disabled = false;
      submitText.textContent = 'Pošalji rezervaciju';
      spinner.classList.add('hidden');
    }
  });
});