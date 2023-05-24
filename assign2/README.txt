--------------------------------------------------
CabsOnline System - User Guide
--------------------------------------------------

Thank you for using the CabsOnline system. This guide provides an overview of the files included in the system and instructions on how to use it effectively.

1. Files Included:
   - admin.html: The admin panel HTML file for managing bookings.
   - admin.js: The JavaScript file for handling admin panel functionality.
   - admin.php: The server-side PHP file for processing admin panel requests.
   - booking.html: The booking form HTML file for customers to make bookings.
   - booking.js: The JavaScript file for handling booking form functionality.
   - booking.php: The server-side PHP file for processing booking form submissions.
   - styles.css: The CSS file for styling the HTML pages.
   - images/icon.gif: An image file used for the system's favicon and background.

2. System Functionality:
   - Admin Panel: The admin panel allows you to search and manage bookings.
   - Booking Form: The booking form enables customers to make new bookings.

3. How to Use the System:
   - Admin Panel:
     - Access the admin panel by opening the admin.html file in a web browser.
     - To search for bookings, enter the booking reference number and click the "Search" button.
     - If the search input is empty, the system will fetch unassigned bookings within the next 2 hours.
     - If a valid booking reference number is provided, the system will retrieve the corresponding booking details.
     - You can assign a booking by clicking the "Assign" button next to the booking entry.
     - The system will update the status and display a success message upon successful assignment.

   - Booking Form:
     - Open the booking.html file in a web browser to access the booking form.
     - Fill in the required details: customer name, phone number, street number, street name, pickup date, and pickup time.
     - Optional details include unit number, suburb name, and destination suburb name.
     - Click the "Submit" button to submit the booking request.
     - Upon successful submission, the system will display a confirmation message with the booking reference, pickup date, and pickup time.

Please ensure that you have a compatible web server environment (e.g., Apache, PHP) to run the system files. Additionally, make sure the required database configuration is correctly set up in the sqlinfo.inc.php file.

For any questions or issues, please refer to the system documentation or contact our support team.

Thank you for using CabsOnline!
