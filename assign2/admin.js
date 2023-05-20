function fetchBooking() {
  let bsearch = document.getElementById('bsearch').value;
  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let bookings = JSON.parse(this.responseText);
      populateTable(bookings);
    }
  };

  xhr.open("GET", "admin.php?bsearch=" + bsearch, true);
  xhr.send();
}

function populateTable(bookings) {
  let table = document.getElementById('bookingTable');
  table.innerHTML = '';

  bookings.forEach(booking => {
    let row = table.insertRow();
    row.insertCell(0).innerText = booking.reference;
    row.insertCell(1).innerText = booking.name;
    row.insertCell(2).innerText = booking.phone;
    row.insertCell(3).innerText = booking.pickup;
    row.insertCell(4).innerText = booking.destination;
    row.insertCell(5).innerText = booking.pickupTime;
    row.insertCell(6).innerText = booking.status;

    let assignCell = row.insertCell(7);
    let assignButton = document.createElement('button');
    assignButton.innerText = 'Assign';
    assignButton.onclick = function () { assignTaxi(booking.reference); };
    assignCell.appendChild(assignButton);
  });
}

function assignTaxi(bookingRef) {
  let xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      alert('Booking ' + bookingRef + ' assigned!');
      fetchBooking();
    }
  };

  xhr.open("GET", "admin.php?assign=" + bookingRef, true);
  xhr.send();
}
