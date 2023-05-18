const inputNames = [
  "cname",
  "phone",
  "unumber",
  "snumber",
  "stname",
  "sbname",
  "dsbname",
  "pickup_date",
  "pickup_date",
];

function validate() {
  const phone = document.querySelector('input[name="phone"]').value;
  const date = document.querySelector('input[name="date"]').value;
  const time = document.querySelector('input[name="time"]').value;

  const phoneRegex = /^\d{10,12}$/;
  const now = new Date();
  // combine date and time

  const inputDate = new Date(`${date}T${time}`);

  if (!phoneRegex.test(phone)) {
    alert("Phone number must be all numbers with length between 10-12.");
    return false;
  }
  // date valiated
  if (now > inputDate) {
    alert("Date must be in the future.");
    return false;
  }
  return true;
}

function submitBooking(e) {
  e.preventDefault();

  if (!validate()) return;

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "booking_requests.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  const formData = new FormData(document.querySelector("#bookingForm"));

  // foreach entry in formData, append to requestBody
  const requestBody = new URLSearchParams([...formData.entries()]).toString();

  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      // Assume server returns a JSON response with bookingid, pickupTime, and pickupDate
      const response = JSON.parse(xhr.responseText);

      // Convert the pickup date to the DD/MM/YYYY format
      const pickupDateArray = response.pickupDate.split('-');
      const formattedPickupDate = pickupDateArray[2] + '/' + pickupDateArray[1] + '/' + pickupDateArray[0];

      // Call changeContent with the booking ID, pickup time and formatted pickup date from the server response
      changeContent(response.bookingid, response.pickupTime, formattedPickupDate);
    }
  };

  xhr.send(requestBody);
}


function changeContent(bookingid, pickupTime, pickupDate) {
  const contentDiv = document.querySelector('#content');
  contentDiv.innerHTML = ""; // make sure it's empty
  let header = "<h1>Booking Successful!</h1>";
  let thankYouMessage = "<p>Thank you for your booking!</p>";
  let bookingIdMessage = "<p id='reference'>Booking reference number: " + bookingid + "</p>";
  let pickupTimeMessage = "<p>Pickup time: " + pickupTime + "</p>";
  let pickupDateMessage = "<p>Pickup date: " + pickupDate + "</p>";

  contentDiv.insertAdjacentHTML("afterbegin", header);
  contentDiv.insertAdjacentHTML("beforeend", thankYouMessage);
  contentDiv.insertAdjacentHTML("beforeend", bookingIdMessage);
  contentDiv.insertAdjacentHTML("beforeend", pickupTimeMessage);
  contentDiv.insertAdjacentHTML("beforeend", pickupDateMessage);
}
