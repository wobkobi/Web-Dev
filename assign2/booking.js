const input = ["cname", "phone", "unumber", "snumber", "stname", "sbname", "dsbname", "date", "time"];

function validate() {
  let name = document.querySelector('input[name="cname"]').value;
  let phone = document.querySelector('input[name="phone"]').value;
  let unumber = document.querySelector('input[name="unumber"]').value;
  let snumber = document.querySelector('input[name="snumber"]').value;
  let stname = document.querySelector('input[name="stname"]').value;
  let sbname = document.querySelector('input[name="sbname"]').value;
  let dsbname = document.querySelector('input[name="dsbname"]').value;
  const date = document.querySelector('input[name="date"]').value;
  const time = document.querySelector('input[name="time"]').value;
  // if these fields dont have data alert
  if (!name || !phone || !snumber || !stname || !date || !time) {
    alert("Please fill in all required fields");
    return false;
  }
  const nonAlphanumericRegex = /[^a-z0-9 \-]/gi;
  const phoneRegex = /^\d{10,12}$/;
  const now = new Date();
  const inputDate = new Date(`${date}T${time}`);
  // if required feilds arent filled alert
  if (!phoneRegex.test(phone)) {
    alert("Invalid phone number. Please enter a 10-digit phone number");
    return false;
  }
  // date valiated
  if (now > inputDate) {
    alert("Pickup date and time must not be earlier than current date and time");
    return false;
  }
  name = name.replace(nonAlphanumericRegex, '');
  unumber = unumber.replace(nonAlphanumericRegex, '');
  snumber = snumber.replace(nonAlphanumericRegex, '');
  stname = stname.replace(nonAlphanumericRegex, '');
  sbname = sbname.replace(nonAlphanumericRegex, '');
  dsbname = dsbname.replace(nonAlphanumericRegex, '');
  document.querySelector('input[name="cname"]').value = name;
  document.querySelector('input[name="unumber"]').value = unumber;
  document.querySelector('input[name="snumber"]').value = snumber;
  document.querySelector('input[name="stname"]').value = stname;
  document.querySelector('input[name="sbname"]').value = sbname;
  document.querySelector('input[name="dsbname"]').value = dsbname;
  return true;
}

function submitBooking(e) {
  if (e) e.preventDefault();
  if (!validate()) return;
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'booking.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  const formData = new FormData(document.querySelector('#bookingForm'));
  const requestBody = new URLSearchParams([...formData.entries()]).toString();
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      const response = JSON.parse(xhr.responseText);
      changeContent(response);
    }
  };
  xhr.send(requestBody);
}

function changeContent(res) {
  const ref = res.booking_ref;
  const date = new Date(res.pickup_date);
  const time = res.pickup_time;
  let formattedDate = date.getDate().toString().padStart(2, '0') + '/' + (date.getMonth() + 1).toString().padStart(2, '0') + '/' + date.getFullYear();
  document.getElementById("reference").innerHTML = "<h2>Thank you for your booking!</h1><p>Booking reference number: " + ref + "</p><p>Pickup time: " + time + "</p><p>Pickup date: " + formattedDate + "</p>";
  document.getElementById("reference").removeAttribute('hidden');
}
