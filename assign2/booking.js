window.onload = load;
const input = { cname: "", phone: "", unumber: "", snumber: "", stname: "", sbname: "", dsbname: "", date: "", time: "" };

/**
 * The function validates form input fields and returns true if all required fields are filled and the
 * input is valid.
 * @returns a boolean value (true or false) depending on whether the form input values pass the
 * validation checks or not.
 */
function validate() {
	// save form to array
	input.cname = document.querySelector('input[name="cname"]').value;
	input.phone = document.querySelector('input[name="phone"]').value;
	input.unumber = document.querySelector('input[name="unumber"]').value;
	input.snumber = document.querySelector('input[name="snumber"]').value;
	input.stname = document.querySelector('input[name="stname"]').value;
	input.sbname = document.querySelector('input[name="sbname"]').value;
	input.dsbname = document.querySelector('input[name="dsbname"]').value;
	input.date = document.querySelector('input[name="date"]').value;
	input.time = document.querySelector('input[name="time"]').value;

	// if these fields don't have data alert
	if (!input.cname || !input.phone || !input.snumber || !input.stname || !input.date || !input.time) {
		alert("Please fill in all required fields");
		return false;
	}

	const nonAlphanumericRegex = /[^a-z0-9 \-]/gi;
	const phoneRegex = /^\d{10,12}$/;
	const now = new Date();
	const inputDate = new Date(`${input.date}T${input.time}`);

	// if required fields aren't filled, alert
	if (!phoneRegex.test(input.phone)) {
		alert("Invalid phone number. Please enter a 10-digit phone number");
		return false;
	}

	// date validated
	if (now > inputDate) {
		alert("Pickup date and time must not be earlier than the current date and time");
		return false;
	}

	input.cname = input.cname.replace(nonAlphanumericRegex, '');
	input.unumber = input.unumber.replace(nonAlphanumericRegex, '');
	input.snumber = input.snumber.replace(nonAlphanumericRegex, '');
	input.stname = input.stname.replace(nonAlphanumericRegex, '');
	input.sbname = input.sbname.replace(nonAlphanumericRegex, '');
	input.dsbname = input.dsbname.replace(nonAlphanumericRegex, '');

	document.querySelector('input[name="cname"]').value = input.cname;
	document.querySelector('input[name="unumber"]').value = input.unumber;
	document.querySelector('input[name="snumber"]').value = input.snumber;
	document.querySelector('input[name="stname"]').value = input.stname;
	document.querySelector('input[name="sbname"]').value = input.sbname;
	document.querySelector('input[name="dsbname"]').value = input.dsbname;

	return true;
}

/**
 * The function submits a booking form via AJAX and clears the form after a successful submission.
 * @param e - The "e" parameter is an event object that is passed to the function. It is used to
 * prevent the default behavior of a form submission when the function is called.
 * @returns There is no return statement in this code snippet.
 */
function submitBooking(e) {
	if (e) e.preventDefault();
	if (!validate()) return;

	const xhr = new XMLHttpRequest();
	xhr.open('POST', 'booking.php', true);
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

	// Convert input object to form data
	const formData = new FormData();
	for (const key in input) {
		if (input.hasOwnProperty(key)) {
			formData.append(key, input[key]);
		}
	}

	const requestBody = new URLSearchParams([...formData.entries()]).toString();
	xhr.onreadystatechange = function () {
		if (xhr.readyState == 4 && xhr.status == 200) {
			const response = JSON.parse(xhr.responseText);
			changeContent(response);
			// Clear form after successful submit
			clearForm();
		}
	};
	xhr.send(requestBody);
}

/**
 * The function clears all input fields in a form.
 */
function clearForm() {
	for (const key in input) {
		if (input.hasOwnProperty(key)) {
			document.querySelector(`input[name="${key}"]`).value = '';
		}
	}
	load();
}


/**
 * The function changes the content of an HTML element with booking information.
 * @param response - The response object that contains the booking reference number, pickup date, and
 * pickup time.
 */
function changeContent(response) {
	const ref = response.booking_ref;
	const date = new Date(response.pickup_date);
	const time = response.pickup_time;
	let formattedDate = date.getDate().toString().padStart(2, '0') + '/' + (date.getMonth() + 1).toString().padStart(2, '0') + '/' + date.getFullYear();
	document.getElementById("reference").innerHTML = "<h2>Thank you for your booking!</h1><p>Booking reference number: " + ref + "</p><p>Pickup time: " + time + "</p><p>Pickup date: " + formattedDate + "</p>";
	document.getElementById("reference").removeAttribute('hidden');
}

/**
 * The function loads the current date and time, sets them as default values in the corresponding input
 * fields, and attaches event listeners for form submission and phone number formatting.
 */
function load() {
	const now = new Date();

	// Get date and time elements
	const dateInput = document.querySelector('#date');
	const timeInput = document.querySelector('#time');
	const phoneInput = document.querySelector('input[name="phone"]');

	// Format date and time
	let year = now.getFullYear();
	let month = ("0" + (now.getMonth() + 1)).slice(-2);
	let date = ("0" + now.getDate()).slice(-2);
	let hours = ("0" + now.getHours()).slice(-2);
	let minutes = ("0" + now.getMinutes()).slice(-2);

	// Set date and time in inputs
	dateInput.value = `${year}-${month}-${date}`;
	timeInput.value = `${hours}:${minutes}`;

	const form = document.querySelector('#bookingForm');

	// Attach an event listener for the submit event
}