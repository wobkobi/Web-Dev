function submitSearch() {
    var xhr = new XMLHttpRequest();
    var bsearch = document.getElementById("bsearch").value;
    xhr.open("POST", "admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var json = JSON.parse(xhr.responseText);
            var table = document.getElementById("bookingTable");
            // Clear existing table rows
            while (table.rows.length > 1) {
                table.deleteRow(1);
            }
            // Populate table with new rows
            json.forEach(function (booking) {
                var row = table.insertRow(-1);
                row.insertCell(0).innerHTML = booking.bookingNumber;
                row.insertCell(1).innerHTML = booking.cname;
                row.insertCell(2).innerHTML = booking.phone;
                row.insertCell(3).innerHTML = booking.snumber;
                row.insertCell(4).innerHTML = booking.dsbname;
                row.insertCell(5).innerHTML = booking.date + " " + booking.time;
                row.insertCell(6).innerHTML = booking.status;
                var assignButton = document.createElement("BUTTON");
                assignButton.innerHTML = "Assign";
                assignButton.onclick = function () {
                    assignBooking(booking.bookingNumber);
                };
                row.insertCell(7).appendChild(assignButton);
            });
        }
    };
    xhr.send("bsearch=" + bsearch);
}

function assignBooking(bookingNumber) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var json = JSON.parse(xhr.responseText);
            if (json.success) {
                // Update the row with the booking number to show that it has been assigned
                var row = document.querySelector(
                    '#bookingTable tr[data-booking-number="' + bookingNumber + '"]'
                );
                if (row) {
                    var statusCell = row.querySelector("td.status");
                    if (statusCell) {
                        statusCell.textContent = "Assigned";
                    }
                }
                alert("Booking " + bookingNumber + " has been successfully assigned.");
            } else {
                alert("Failed to assign booking " + bookingNumber + ": " + json.error);
            }
        }
    };
    xhr.send("action=assign&bookingNumber=" + encodeURIComponent(bookingNumber));
}
