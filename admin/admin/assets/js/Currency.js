document.addEventListener("DOMContentLoaded", loadCurrencies);

function loadCurrencies() {
  fetch("fetchCurrency.php")
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById("currencyTableBody");
      if (!tbody) return console.warn('currencyTableBody not found');
      tbody.innerHTML = "";
      data.forEach(row => {
        // store encoded JSON in data-row to avoid quoting issues
        const encoded = encodeURIComponent(JSON.stringify(row));
        tbody.innerHTML += `
          <tr>
            <td>${row.id}</td>
            <td>${row.currency}</td>
            <td>${row.country}</td>
            <td>${row.LKR}</td>
            <td>${row.updatedAt}</td>
            <td>
              <button class="btn btn-sm btn-warning" type="button" data-row="${encoded}" onclick="confirmOpenUpdateModal(this)">
                <i class="fas fa-edit"></i>
              </button>
            </td>
          </tr>`;
      });
    })
    .catch(err => {
      console.error('loadCurrencies error', err);
    });
}

// Confirmation before opening modal
function confirmOpenUpdateModal(elOrEncoded) {
  let encoded;
  if (elOrEncoded && elOrEncoded.dataset && elOrEncoded.dataset.row) {
    encoded = elOrEncoded.dataset.row;
  } else if (typeof elOrEncoded === 'string') {
    encoded = elOrEncoded;
  } else {
    console.warn('confirmOpenUpdateModal: invalid argument', elOrEncoded);
    return;
  }

  const row = JSON.parse(decodeURIComponent(encoded));

  const proceed = () => openUpdateModal(row);

  if (window.Swal) {
    Swal.fire({
      title: 'Open editor',
      text: `Edit currency rate for ${row.currency} (${row.country})?`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, open',
      cancelButtonText: 'Cancel'
    }).then(result => { if (result.isConfirmed) proceed(); });
  } else {
    if (confirm(`Edit currency rate for ${row.currency} (${row.country})?`)) proceed();
  }
}

function openUpdateModal(row) {
  document.getElementById("currency_id").value = row.id;
  document.getElementById("currency_name").value = row.currency;
  document.getElementById("currency_country").value = row.country;
  document.getElementById("currency_rate").value = row.LKR;
  // updatedAt handled server-side; do not set a date input
  new bootstrap.Modal(document.getElementById("updateCurrencyModal")).show();
}

function updateCurrency() {
  // confirm first using SweetAlert2 if available, fallback to confirm()
  const proceed = function () {
    const form = document.getElementById("updateCurrencyForm");
    const formData = new FormData(form);

    // use absolute path from site root to avoid relative-path mistakes
    fetch("/BLAZE-TOURS/admin/process/updateCurrency.php", {
      method: "POST",
      body: formData
    })
      .then(async res => {
        const txt = await res.text();
        try {
          const json = JSON.parse(txt);
          return json;
        } catch (err) {
          // Show full server response (HTML or error) for debugging
          console.error('updateCurrency: invalid JSON response:', txt);
          throw new Error('Invalid JSON response from server');
        }
      })
      .then(response => {
        const msgBox = document.getElementById("update-message-currency");
        if (msgBox) {
          msgBox.classList.remove("d-none", "alert-success", "alert-danger");
          msgBox.classList.add(response.success ? "alert-success" : "alert-danger");
          msgBox.textContent = response.message;
        }
        if (response.success) {
          loadCurrencies();
          if (window.Swal) {
            Swal.fire({ icon: 'success', title: 'Updated', text: response.message, timer: 1500, showConfirmButton: false });
          } else {
            alert(response.message);
          }
          // reset modal form and message, then hide modal
          setTimeout(() => {
            resetCurrencyModal();
            const modalEl = document.getElementById("updateCurrencyModal");
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
          }, 900);
        } else {
          if (window.Swal) {
            Swal.fire({ icon: 'error', title: 'Error', text: response.message });
          }
        }
      })
      .catch(err => {
        console.error('updateCurrency fetch error', err);
        if (window.Swal) {
          Swal.fire({ icon: 'error', title: 'Error', text: 'Request failed. See console for details.' });
        } else {
          alert('Request failed. See console for details.');
        }
      });
  };

  if (window.Swal) {
    Swal.fire({
      title: 'Confirm update',
      text: 'Are you sure you want to update this currency rate? The updated date will be set to today.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, update',
      cancelButtonText: 'Cancel'
    }).then(result => { if (result.isConfirmed) proceed(); });
  } else {
    if (confirm('Update currency rate?')) proceed();
  }
}

function resetCurrencyModal() {
  const form = document.getElementById("updateCurrencyForm");
  if (form) form.reset();
  const idField = document.getElementById("currency_id");
  if (idField) idField.value = '';
  const msgBox = document.getElementById("update-message-currency");
  if (msgBox) {
    msgBox.className = 'alert d-none';
    msgBox.textContent = '';
  }
}
