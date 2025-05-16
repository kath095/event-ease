<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include('db.php');

// Ambil email dari session
$email = $_SESSION['email'];

// Ambil user_id
$stmt = $mysqli->prepare("SELECT user_id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$user_id = $user['user_id'];

// Ambil 1 event terbaru yang dibuat oleh user
$event_result = $mysqli->query("SELECT * FROM events WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 1");
$latest_event = $event_result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event - EventEase</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="kelolaevent.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>
<body>
<header class="header-dashboard">
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

<main>
    <section class="hero-text-section">
        <div class="container">
            <h1>Promote Your Event, Your Way</h1>
            <p>Create, manage and promote your event easily with EventEase.<br>
            Invite participants to join and make your event an unforgettable moment!</p>
        </div>
    </section>

    <section class="hero-image-section">
        <div class="container">
            <img src="assets/kelolaevent.jpg" alt="Create Event Banner" class="hero-image">
        </div>
    </section>

    <section class="form-section">
        <div class="form-left">
            <h2>Fill the form</h2>
            <form action="proses_event.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" name="title">
                </div>
                <div class="form-group">
                    <label>Short Description (max. 150 characters):</label>
                    <input type="text" name="short_description">
                </div>
                <div class="form-group">
                    <label>Description:</label>
                    <textarea name="description"></textarea>
                </div>
                <div class="form-group">
                    <label>Upload Images:</label>
                    <input type="file" name="event_image" accept="image/jpeg, image/jpg, image/png">
                </div>
                <div class="form-group">
                    <label>Date:</label>
                    <input type="date" name="date">
                </div>
                <div class="form-group time-group">
                    <div>
                        <label>Start Time:</label>
                        <input type="text" name="start_time" placeholder="00:00:00">
                    </div>
                    <div>
                        <label>End Time:</label>
                        <input type="text" name="end_time" placeholder="00:00:00">
                    </div>
                </div>
                <div class="form-group">
                    <label>Type:</label>
                    <select name="type" required>
                        <option value="">Choose</option>
                        <option value="offline">Offline</option>
                        <option value="online">Online</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Location:</label>
                    <input type="text" name="location">
                </div>
                <div class="form-group">
                    <label>Category:</label>
                    <select name="category">
                        <option value="">Choose</option>
                        <option value="Olahraga">Olahraga</option>
                        <option value="Hiburan">Hiburan</option>
                        <option value="Edukasi">Edukasi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Attendee Capacity:</label>
                    <input type="text" name="capacity" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
                <div class="form-group">
                    <label>Price:</label>
                    <input type="text" name="price">
                </div>
                <div class="form-group checkbox-wrapper">
                    <input type="checkbox" id="agreement" name="agreement" required>
                    <label for="agreement" class="checkbox-label">
                        I declare that the event data I have filled in is correct, and 
                        <span class="important-text">EventEase is not responsible</span> 
                        for any false information provided by me.
                    </label>
                </div>
                <button type="submit" class="submit-btn">Submit</button>
            </form>
            <script>
                window.addEventListener('DOMContentLoaded', (event) => {
                    const dateInput = document.querySelector('input[type="date"]');
                    const today = new Date();
                    today.setDate(today.getDate() + 1);
                    const yyyy = today.getFullYear();
                    const mm = String(today.getMonth() + 1).padStart(2, '0');
                    const dd = String(today.getDate()).padStart(2, '0');
                    const minDate = `${yyyy}-${mm}-${dd}`;
                    dateInput.setAttribute('min', minDate);
                });
            </script>
        </div>

        <div class="form-right">
            <h2>Check your event</h2>
            <div class="preview-section">
                <?php if ($latest_event): ?>
                    <div style="text-align: left;">
                        <?php
                            if (!empty($latest_event['image'])) {
                                $image_data = base64_encode($latest_event['image']);
                                $image_src = 'data:image/jpeg;base64,' . $image_data;
                                echo '<img src="' . $image_src . '" style="width: 100%; max-height: 200px; object-fit: cover; border-radius: 10px; margin-bottom: 10px;">';
                            }
                        ?>
                        <h4><?= htmlspecialchars($latest_event['title']) ?></h4>
                        <p><strong>Date:</strong> <?= $latest_event['event_date'] ?></p>
                        <p><strong>Time:</strong> <?= $latest_event['event_start_time'] ?> - <?= $latest_event['event_end_time'] ?></p>
                        <p><strong>Location:</strong> <?= htmlspecialchars($latest_event['location']) ?></p>
                        <p><strong>Category:</strong> <?= $latest_event['category'] ?></p>
                        <p><strong>Type:</strong> <?= $latest_event['event_type'] ?></p>
                        <p><strong>Price:</strong> Rp <?= number_format($latest_event['price'], 0, ',', '.') ?></p>
                    </div>
                <?php else: ?>
                    <p>No event created yet.</p>
                <?php endif; ?>
            </div>
        </div>


    </section>
</main>

<footer class="footer">
    <div class="footer-container">
        <div class="footer-left">
            <h3><i class="ph ph-house"></i> EventEase</h3>
            <p>EventEase is a national self-service ticketing platform for live experiences that allows anyone to create, share, find and attend events that fuel their passions and enrich their lives.</p>
            <div class="social-media">
                <a href="#" class="social-icon"><i class="ph ph-facebook-logo"></i></a>
                <a href="#" class="social-icon"><i class="ph ph-linkedin-logo"></i></a>
                <a href="#" class="social-icon"><i class="ph ph-instagram-logo"></i></a>
            </div>
        </div>
        <div class="footer-center-left">
            <h4>Plan Events</h4>
            <ul>
                <li><a href="#">Create and Set Up</a></li>
                <li><a href="#">Sell Tickets</a></li>
                <li><a href="#">Online RSVP</a></li>
                <li><a href="#">Online Events</a></li>
            </ul>
        </div>
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
    <p class="cr">&copy; 2025 EventEase. All Rights Reserved.</p>
</footer>
</body>
</html>
