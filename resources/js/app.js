import.meta.glob([ '../images/**', '../fonts/**' ]);
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('reservation-modal');
  if (!modal) return;

  const form       = modal.querySelector('[data-reservation-form]');
  const msg        = modal.querySelector('[data-reservation-message]');
  const submitBtn  = form.querySelector('button[type="submit"]');
  const submitText = modal.querySelector('[data-reservation-submit-text]');
  const spinner    = modal.querySelector('[data-reservation-spinner]');
  const inputId    = form.querySelector('input[name="putovanje_id"]');
  const tripTitle  = modal.querySelector('[data-reservation-trip-title]');
  const tripDates  = modal.querySelector('[data-reservation-trip-dates]');

  function openModal(data) {
    inputId.value   = data.tripId;
    tripTitle.textContent = data.tripTitle;
    tripDates.textContent = data.tripDates || '';
    msg.classList.add('hidden');
    form.reset();
    inputId.value = data.tripId;
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
    const opener = e.target.closest('[data-reservation-open]');
    if (opener) {
      e.preventDefault();
      openModal({
        tripId:    opener.dataset.tripId,
        tripTitle: opener.dataset.tripTitle,
        tripDates: opener.dataset.tripDates,
      });
    }
    if (e.target.closest('[data-reservation-close]') || e.target === modal) {
      closeModal();
    }
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && ! modal.classList.contains('hidden')) {
      closeModal();
    }
  });

  form.addEventListener('submit', async function (e) {
    e.preventDefault();

    msg.classList.add('hidden');
    submitBtn.disabled = true;
    submitText.textContent = 'Šaljem...';
    spinner.classList.remove('hidden');

    const formData = new FormData(form);
    formData.append('action', 'bagdala_submit_reservation');
    formData.append('nonce', window.bagdalaReservation?.nonce || '');

    try {
      const res  = await fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        body:   formData,
      });
      const data = await res.json();

      msg.classList.remove('hidden', 'bg-green-50', 'text-green-700', 'bg-red-50', 'text-red-700');

      if (data.success) {
        msg.classList.add('bg-green-50', 'text-green-700');
        msg.textContent = data.data.message || 'Rezervacija primljena.';
        form.reset();
        setTimeout(closeModal, 3000);
      } else {
        msg.classList.add('bg-red-50', 'text-red-700');
        msg.textContent = data.data?.message || 'Greška. Pokušajte ponovo.';
      }
    } catch (err) {
      msg.classList.remove('hidden');
      msg.classList.add('bg-red-50', 'text-red-700');
      msg.textContent = 'Greška u komunikaciji. Pokušajte ponovo.';
    } finally {
      submitBtn.disabled = false;
      submitText.textContent = 'Pošalji rezervaciju';
      spinner.classList.add('hidden');
    }
  });
});