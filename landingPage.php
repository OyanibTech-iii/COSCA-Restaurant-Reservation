<?php
require 'db_connect.php';
include 'authentication.php';
// Get the username from the session, default to 'Guest' if not logged in
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

// Capitalize the first letter and separate it from the rest of the string
$firstLetter = ucfirst(substr($username, 0, 1)); // Get the first character and make it uppercase
$remainingLetters = substr($username, 1); // Get the remaining part of the username
// Concatenate the formatted username with "username" on a new line
$styledUsername = "Hi, " . $firstLetter . $remainingLetters;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COSCARestaurantReservationAngBillingSystem/HomePage</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="landingpage.css">
    <link rel="icon" type="image/webp" href="assets/logo.webp">

</head>

<body>
    <aside class="sidebar">
        <div class="logo-container">
            <h3 class="company-name"><?php echo nl2br($styledUsername); ?></h3>
        </div>
        <ul class="ulsp">
            <ul class="ulsp">
                <li class="dashboard-item" data-url="dashboard.php"><i class="fa-solid fa-gauge-high"></i> <span>Dashboard</span></li>
                <li data-url="Reservation.php"><i class="fa-solid fa-calendar-check"></i> <span>Reservation</span></li>
                <li data-url="orders.php"><i class="fa-solid fa-concierge-bell"></i> <span>Orders</span></li>
                <li data-url="location.php"><i class="fa-solid fa-map-marker-alt"></i> <span>Location</span></li>
                <li data-url="termsAndPolicy.php"><i class="fa-solid fa-scroll"></i> <span>Policy</span></li>
                <li data-url="settings.php"><i class="fa-solid fa-gear"></i> <span>Settings</span></li>
                <li data-url="feedback.php"> <i class="fa-solid fa-comment-dots"></i> <span>Feedback</span></li>
                <li data-url="logout.php"><i class="fa-solid fa-right-from-bracket"></i> <span>Log out</span></li>
            </ul>
            <div class="footerStyling">
                <p class="footer">
                <p>8844+GM7, <br>Bishop Epifanio B,<br>Bishop Epifanio Surban St,<br>Dumaguete,<br>Negros Oriental.</p>
                    <p><b>(032) 123 4567</b></p>
                </p>
            </div>
    </aside>

    <div class="main-content">
        <img src="assets/cosca.jpg" alt="Building">
        <div class="overlay-text">Restaurant Reservation and Billing System.</div>
        <div class="foot">  <?php include 'footer.php' ?></div>
    </div>
    <script>
        document.querySelectorAll('.ulsp li').forEach(item => {
            item.addEventListener('click', () => {
                const url = item.dataset.url; // Get the URL from data-url attribute
                if (url) {
                    window.location.href = url;
                }
            });
        });
    </script>
</body>

</html>