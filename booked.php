<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
// Dummy data (seharusnya dari database)
$event = [
    "title" => "Events Title",
    "date" => "18 September 2025",
    "location" => "Stadium XYZ",
    "description" => "This is pakyu",
    "time" => "09.30 - 10.30",
    "image" => "assets/event1.png"
];

$tickets = [
    [
        "title" => "Boys/Girls Band Battle Flip 2025",
        "date" => "18",
        "month" => "SEP",
        "desc" => "Directly seated and inside for you to enjoy the show.",
        "image" => "band.jpg"
    ],
    [
        "title" => "Boys/Girls Band Battle Flip 2025",
        "date" => "18",
        "month" => "SEP",
        "desc" => "Directly seated and inside for you to enjoy the show.",
        "image" => "band.jpg"
    ]
];
?>


<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <title>Booked Events</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/regular/style.css">
    <style>
        body { margin: 0; font-family: sans-serif; background: #f9f9f9; }
        .event-detail, .tickets-section, footer { padding: 2rem; }
        .event-container { display: flex; background: #fff; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        .event-container img { width: 50%; border-radius: 12px 0 0 12px; }
        .event-info { padding: 1rem 2rem; width: 50%; }
        .tickets { display: flex; gap: 1rem; margin-top: 1rem; }
        .ticket-card { background: #fff; border-radius: 12px; padding: 1rem; width: 250px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .ticket-card img { width: 100%; border-radius: 8px; }
        .subscribe input[type=email] { padding: 0.5rem; border-radius: 6px; border: none; }
        .subscribe button { background: blue; color: #fff; padding: 0.5rem 1rem; border: none; border-radius: 6px; }
    </style>
</head>

<!-- Navbar -->
<header class="header-booked">
        <nav class="navbar">
            <div class="nav-container">
                <div class="nav-links">
                    <a href="dashboard.php">Home</a>
                    <a href="event.php">Event</a>
                    <a href="payment.php">Payment</a>
                    <a href="reminder.php">Reminder</a>
                </div>
               <div class="nav-login">
                 <span class="user-email"></span>
                    <a href="profil_pengguna.html" class="user-email">Welcome, <?= htmlspecialchars($_SESSION['email']); ?></a>
                    <a href="logout.php" class="btn-logout">Logout</a>
               </div>
            </div>
        </nav>
    </header>

<!-- Event Detail -->
<div class="event-detail">
    <div class="event-container">
        <img src="<?= $event['image']; ?>" alt="Event Image">
        <div class="event-info">
            <h2><?= $event['title']; ?></h2>
            <p><?= $event['date']; ?></p>
            <p>📍 <?= $event['location']; ?></p>
            <p><?= $event['description']; ?></p>
            <p>Time: <?= $event['time']; ?></p>
            <form action="payment.php" method="POST">
                <button type="submit" name="book" value="1">Book Now</button>
            </form>
        </div>
    </div>
</div>

<!-- Tickets Booked -->
<div class="tickets-section" style="background: #0a1a3f; color: white;">
    <div class="ticket-card" style="color: black;" >
    <h3>View event tickets you have booked</h3>
    <div class="tickets">
        <?php if (empty($tickets)): ?>
            <p>Tidak ada tiket yang dibooking</p>
        <?php else: ?>
            <?php foreach ($tickets as $ticket): ?>
                <div class="ticket-card">
                    <img src="assets/event1.png" alt="Ticket Image">
                    <p><strong><?= $ticket['month']; ?> <?= $ticket['date']; ?></strong></p>
                    <h4><?= $ticket['title']; ?></h4>
                    <p><?= $ticket['desc']; ?></p>
                    <button>🗑️ DELETE</button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<footer class="footer">
    <div class="footer-container">
        <!-- Left Side -->
        <div class="footer-left">
            <h3><i class="ph ph-house"></i> EventEase</h3>
            <p>EventEase is a national self-service ticketing platform for live experiences that allows anyone to create, share, find and attend events that fuel their passions and enrich their lives.</p>
            <div class="social-media">
                <a href="#" class="social-icon"><i class="ph ph-facebook-logo"></i></a>
                <a href="#" class="social-icon"><i class="ph ph-linkedin-logo"></i></a>
                <a href="#" class="social-icon"><i class="ph ph-instagram-logo"></i></a>
            </div>
        </div>

        <!-- Center Left Side (Plan Events) -->
        <div class="footer-center-left">
            <h4>Plan Events</h4>
            <ul>
                <li><a href="#">Create and Set Up</a></li>
                <li><a href="#">Sell Tickets</a></li>
                <li><a href="#">Online RSVP</a></li>
                <li><a href="#">Online Events</a></li>
            </ul>
        </div>

        <!-- Center Right Side (Eventick) -->
        <div class="footer-center-right">
            <h4>Eventick</h4>
            <ul>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Press</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">Help Center</a></li>
                <li><a href="#">How it Works</a></li>
                <li><a href="#">Privacy</a></li>
                <li><a href="#">Terms</a></li>
            </ul>
        </div>

        <!-- Right Side (Stay In The Loop) -->
        <div class="footer-right">
            <h4>Stay In The Loop</h4>
            <p>Join our mailing list to stay in the loop with our newest events and concerts.</p>
            <form action="#">
                <div class="email-container">
                    <input type="email" placeholder="Enter your email..." required>
                    <button type="submit" class="subscribe-btn">Subscribe Now</button>
                </div>
            </form>
        </div>
    </div>
        <p class = "cr">&copy; 2025 EventEase. All Rights Reserved.</p>
    </footer>
    <script src="sliderdashboard.js" defer></script>

</body>
</html>
