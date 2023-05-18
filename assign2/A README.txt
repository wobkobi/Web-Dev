README

FILE LIST:

1. booking.html - Main booking form
2. booking.php - Server-side processing for booking requests
3. booking.js - Client-side processing and AJAX requests for booking form
4. admin.html - Administration page for viewing and assigning bookings
5. admin.php - Server-side processing for administration tasks
6. admin.js - Client-side processing and AJAX requests for admin page
7. conf/assign2.php - Database connection configuration
8. styles.css - Stylesheet for the application
9. readme.txt - This file

USAGE INSTRUCTIONS:

1. Open `booking.html` in a web browser to access the booking form.
2. Fill out the form fields and click "Submit" to create a new booking. 
   If successful, you will see a booking reference number, pickup date and time.
3. Open `admin.html` in a web browser to access the admin page.
4. Here you can search for a booking by its reference number using the search bar and "Search" button.
5. If the search bar is left empty, it will return all bookings within the next 2 hours.
6. Click "Assign" next to a booking to assign it. The status of the booking will be updated to "Assigned".

Note: To connect to a different database, edit the `$host`, `$user`, `$password`, and `$dbName` variables in `conf/assign2.php`.
