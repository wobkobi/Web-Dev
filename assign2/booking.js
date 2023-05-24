// Harrison Raynes 20121017
// The JavaScript file for handling booking form functionality.

// Initialize input object to store form values
const input = { cname: "", phone: "", unumber: "", snumber: "", stname: "", sbname: "", dsbname: "", date: "", time: "" };

// Function to get the value of an input element by its name
const getElementValue = (key) =>
	document.querySelector(`input[name="${key}"]`).value;

// Function to set the value of an input element by its name
const setElementValue = (key, value) =>
	(document.querySelector(`input[name="${key}"]`).value = value);

// Form validation function
function validate() {
	// Retrieve values from input elements
	for (const key in input) {
		input[key] = getElementValue(key);
	}

	// Check if required fields are filled
	if (!input.cname || !input.phone || !input.snumber || !input.stname || !input.date || !input.time) {
		alert("Please fill in all required fields");
		return false;
	}

	// Regular expressions for validation
	const nonAlphanumericRegex = /[^a-z0-9 \-]/gi;
	const phoneRegex = /^\d{10,12}$/;

	// Current date and time
	const now = new Date();
	const inputDate = new Date(`${input.date}T${input.time}`);
	// Validate phone number format
	if (!phoneRegex.test(input.phone)) {
		alert("Invalid phone number. Please enter a 10-digit phone number");
		return false;
	}

	// Validate pickup date and time
	if (now > inputDate) {
		alert("Pickup date and time must not be earlier than the current date and time");
		return false;
	}

	// Clean up input values and update the form
	for (const key in input) {
		// inless its date or time 
		if (key === "date" || key === "time") continue;
		input[key] = input[key].replace(nonAlphanumericRegex, "");
		setElementValue(key, input[key]);
	}

	return true;
}

// Form submission function
function submitBooking(e) {
	if (e) e.preventDefault();
	if (!validate()) return;

	// Create FormData object and append form values
	const formData = new FormData();
	for (const key in input) {
		if (input.hasOwnProperty(key)) {
			formData.append(key, input[key]);
		}
	}

	// Create request body
	const requestBody = new URLSearchParams([...formData.entries()]).toString();

	// Create new XMLHttpRequest
	const xhr = new XMLHttpRequest();
	xhr.open("POST", "booking.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.onload = function () {
		if (xhr.status === 200) {
			console.log(xhr.responseText)
			const data = JSON.parse(xhr.responseText);
			changeContent(data);
			clearForm();
		} else {
			console.error("Error: ", xhr.status, xhr.statusText);
		}
	};
	xhr.onerror = function () {
		console.error("Request failed");
	};
	xhr.send(requestBody);
}


// Function to clear the form
function clearForm() {
	for (const key in input) {
		if (input.hasOwnProperty(key)) {
			setElementValue(key, "");
		}
	}
	load();
}

// Function to update the content after successful submission
function changeContent(response) {
	const ref = response.booking_ref;
	const date = new Date(response.pickup_date);
	const time = response.pickup_time;
	const formattedDate =
		date.getDate().toString().padStart(2, "0") +
		"/" +
		(date.getMonth() + 1).toString().padStart(2, "0") +
		"/" +
		date.getFullYear();

	const referenceElement = document.getElementById("reference");
	referenceElement.innerHTML = `<h2>Thank you for your booking!</h2><p>Booking reference number: ${ref}</p><p>Pickup time: ${time}</p><p>Pickup date: ${formattedDate}</p>`;
	referenceElement.removeAttribute("hidden");
	referenceElement.scrollIntoView({ behavior: "smooth" });
}

// Function to initialize form values with current date and time
function load() {
	const dateInput = document.querySelector("#date");
	const timeInput = document.querySelector("#time");

	function updateDateTime() {
		const now = new Date();
		const year = now.getFullYear();
		const month = ("0" + (now.getMonth() + 1)).slice(-2);
		const date = ("0" + now.getDate()).slice(-2);
		const hours = ("0" + now.getHours()).slice(-2);
		const minutes = ("0" + now.getMinutes()).slice(-2);

		dateInput.value = `${year}-${month}-${date}`;
		timeInput.value = `${hours}:${minutes}`;
	}

	updateDateTime();

	setInterval(updateDateTime, 1);
}

// Register the load function to be executed when the window is loaded
window.onload = load();