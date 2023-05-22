/**
 * The function searches for a booking using a booking reference number and displays the search
 * results.
 * @param {Event} e - The event parameter is an object that represents the event that triggered the
 * function. In this case, it is the "submit" event of a form.
 */
function searchBooking(e) {
  if (e) e.preventDefault();
  const searchInput = document.getElementById("bsearch").value;
  // Check if search input is empty
  if (searchInput.trim() === "") {
    return; // Exit the function
  }
  // Validate the booking reference number format
  if (!/^BRN\d{5}$/.test(searchInput)) {
    alert("Invalid booking reference number format. Example: BRN00001");
    return; // Exit the function
  }
  // Create an XMLHttpRequest object
  const xhr = new XMLHttpRequest();
  // Set up the request
  xhr.open("GET", "admin.php?bsearch=" + searchInput, true);
  // Define the callback function
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      displaySearchResults(response);
    }
  };
  // Send the request
  xhr.send();
}

/**
 * The function displays search results in a table format with booking details and an assign button
 * for each booking.
 * @param {Array} data - The data parameter is an array of objects containing information about bookings.
 * Each object represents a single booking and contains properties such as booking reference number,
 * customer name, phone number, pickup and destination suburbs, pickup date and time, and booking
 * status. The function uses this data to generate an HTML table displaying the search results.
 */
function displaySearchResults(data) {
  const contentDiv = document.querySelector(".content");
  contentDiv.innerHTML = ""; // Clear previous search results
  if (data.error) {
    alert(data.error);
    return; // Exit the function
  }
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
          <button class="assignBtn" data-ref="${booking.booking_ref}" ${booking.booking_status === "assigned" ? "disabled" : ""
      }>Assign</button>
        </td>
      </tr>`;
  });
  html += `</table>`;
  contentDiv.innerHTML = html;
  const assignBtns = document.querySelectorAll(".assignBtn");
  for (const assignBtn of assignBtns) {
    assignBtn.addEventListener("click", assignBooking);
  }
}

/**
 * This function assigns a booking by sending a GET request to the server and updating the booking
 * status in the table.
 * @param {Event} event - The event parameter is the event object that is passed to the function when it is
 * called. It contains information about the event that triggered the function, such as the target
 * element and any data associated with it.
 */
function assignBooking(event) {
  const bookingRef = event.target.dataset.ref;
  // Create an XMLHttpRequest object
  const xhr = new XMLHttpRequest();
  // Set up the request
  xhr.open("GET", "admin.php?assign=" + bookingRef, true);
  // Define the callback function
  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      const response = xhr.responseText;
      showConfirmation(response);
      event.target.disabled = true;
      // Update the booking status in the table
      const statusCell = event.target.parentNode.previousElementSibling;
      statusCell.textContent = "assigned";
    }
    // if theres a error
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 400) {
      const response = xhr.responseText;
      showError(response);
    }
  };
  // Send the request
  xhr.send();
}

/**
 * The function creates a success message element with a given message and inserts it as the first
 * child of a content element.
 * @param message - The message to be displayed in the confirmation div.
 */
function showConfirmation(message) {
  const confirmationDiv = document.createElement("div");
  confirmationDiv.classList.add("success-message");
  confirmationDiv.textContent = message;
  const contentDiv = document.querySelector(".content");
  contentDiv.insertBefore(confirmationDiv, contentDiv.firstChild);
}

/**
 * The function creates and inserts an error message into the first child of a content div.
 * @param message - The error message that will be displayed in the errorDiv element.
 */
function showError(message){
  const errorDiv = document.createElement("div");
  errorDiv.classList.add("error-message");
  errorDiv.textContent = message;
  const contentDiv = document.querySelector(".content");
  contentDiv.insertBefore(errorDiv, contentDiv.firstChild);
}
