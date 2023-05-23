window.onload = searchEmptyBooking;

function searchBooking(e) {
  if (e) e.preventDefault();
  const searchInput = document.getElementById("bsearch").value;
  // Check if search input is empty
  if (searchInput.trim() === "") {
    searchEmptyBooking();
  } else {
    searchBookingByReference(searchInput);
  }
}

function searchEmptyBooking() {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "admin.php?bsearch=", true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      displaySearchResults(response);
    }
  };
  xhr.send();
}

function searchBookingByReference(reference) {
  if (!/^BRN\d{5}$/.test(reference)) {
    alert("Invalid booking reference number format. Example: BRN00001");
    return;
  }
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "admin.php?bsearch=" + reference, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      displaySearchResults(response);
    }
  };
  xhr.send();
}

function displaySearchResults(data) {
  const searchInput = document.getElementById("bsearch");
  const searchValue = searchInput.value;
  searchInput.value = "";

  const contentDiv = document.querySelector(".content");
  contentDiv.innerHTML = "";

  let html = `
    <table class="admin-table">
      <tr>
        <th>Booking reference number</th>
        <th>Customer name</th>
        <th>Phone</th>
        <th>Pickup suburb</th>
        <th>Destination suburb</th>
        <th>Pickup date and time</th>
        <th>Status</th>
        <th>Assign</th>
      </tr>`;

  if (data.error) {
    html += `
      <tr>
        <td colspan="8">No bookings found.</td>
      </tr>`;
  } else {
    data.forEach(function (booking) {
      const inputDate = new Date(`${booking.pickup_date}T${booking.pickup_time}`);
      const formattedDate = inputDate.toLocaleDateString("en-NZ", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        hour12: false,
      });

      let formattedPhone = booking.phone;
      if (!formattedPhone.includes("-") && formattedPhone.length > 3) {
        formattedPhone = formattedPhone.slice(0, 3) + "-" + formattedPhone.slice(3);
      }

      html += `
        <tr>
          <td>${booking.booking_ref}</td>
          <td>${booking.cname}</td>
          <td>${formattedPhone}</td>
          <td>${booking.snumber} ${booking.stname} ${booking.sbname}</td>
          <td>${booking.dsbname}</td>
          <td>${formattedDate.replace(",", "")}</td>
          <td>${booking.booking_status}</td>
          <td>
            <button class="assignBtn" data-ref="${booking.booking_ref}" ${booking.booking_status === "assigned" ? "disabled" : ""}>Assign</button>
          </td>
        </tr>`;
    });
  }

  html += `</table>`;
  contentDiv.innerHTML = html;
  const assignBtns = document.querySelectorAll(".assignBtn");
  for (const assignBtn of assignBtns) {
    assignBtn.addEventListener("click", assignBooking);
  }

  searchInput.value = searchValue;
}

function assignBooking(event) {
  const bookingRef = event.target.dataset.ref;
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "admin.php?assign=" + bookingRef, true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      const response = xhr.responseText;
      showConfirmation(response);
      event.target.disabled = true;
      const statusCell = event.target.parentNode.previousElementSibling;
      statusCell.textContent = "assigned";
    }
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 400) {
      const response = xhr.responseText;
      showError(response);
    }
  };
  xhr.send();
}

function showConfirmation(message) {
  const confirmationDiv = document.createElement("div");
  confirmationDiv.classList.add("success-message");
  confirmationDiv.textContent = message;
  const contentDiv = document.querySelector(".content");
  contentDiv.insertBefore(confirmationDiv, contentDiv.firstChild);
}

function showError(message) {
  const errorDiv = document.createElement("div");
  errorDiv.classList.add("error-message");
  errorDiv.textContent = message;
  const contentDiv = document.querySelector(".content");
  contentDiv.insertBefore(errorDiv, contentDiv.firstChild);
}

function submitSearch(event) {
  event.preventDefault();
  const searchInput = document.getElementById("bsearch").value.trim();
  if (searchInput === "") {
    searchEmptyBooking();
  } else {
    const url = `admin.html?bsearch=${searchInput}`;
    window.location.href = url;
  }

  document.getElementById("bsearch").value = ""; // Clear the search field
}
