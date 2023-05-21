document.addEventListener("DOMContentLoaded", function() {
	const searchForm = document.getElementById("searchForm");
	const contentDiv = document.querySelector(".content");

	function searchBooking(event) {
		event.preventDefault();
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
		xhr.onreadystatechange = function() {
			if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
				const response = JSON.parse(xhr.responseText);
				displaySearchResults(response);
			}
		};
		// Send the request
		xhr.send();
	}

	function displaySearchResults(data) {
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
        </tr>
    `;
		data.forEach(function(booking) {
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
        </tr>
      `;
		});
		html += `</table>`;
		contentDiv.innerHTML = html;
		const assignBtns = document.querySelectorAll(".assignBtn");
		for (const assignBtn of assignBtns) {
			assignBtn.addEventListener("click", assignBooking);
		}
	}

	function assignBooking(event) {
		const bookingRef = event.target.dataset.ref;
		// Create an XMLHttpRequest object
		const xhr = new XMLHttpRequest();
		// Set up the request
		xhr.open("GET", "admin.php?assign=" + bookingRef, true);
		// Define the callback function
		xhr.onreadystatechange = function() {
			if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
				const response = xhr.responseText;
				showConfirmation(response);
				event.target.disabled = true;
				// Update the booking status in the table
				const statusCell = event.target.parentNode.previousElementSibling;
				statusCell.textContent = "assigned";
			}
		};
		// Send the request
		xhr.send();
	}

	function showConfirmation(message) {
		const confirmationDiv = document.createElement("div");
		confirmationDiv.classList.add("success-message");
		confirmationDiv.textContent = message;
		contentDiv.insertBefore(confirmationDiv, contentDiv.firstChild);
	}
	// Attach the event listener to the form submit event
	if (searchForm) {
		searchForm.addEventListener("submit", searchBooking);
	}
});