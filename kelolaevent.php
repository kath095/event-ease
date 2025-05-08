<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
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

<header class="navbar">
    <div class="nav-container">
        <div class="nav-links">
            <a href="dashboard.php">Home</a>
            <a href="#">Event</a>
            <a href="#">Payment</a>
            <a href="#">Reminder</a>
        </div>
        <div class="nav-login">
            <div class="nav-profile">
                <i class="ph ph-user-circle"></i>
            </div>
            <span><?php echo htmlspecialchars($_SESSION['email']); ?></span>
        </div>
    </div>
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
            <form action="#" method="POST" enctype="multipart/form-data">
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
                        <select name="start_time">
                            <option>Choose</option>
                        </select>
                    </div>
                    <div>
                        <label>End Time:</label>
                        <select name="end_time">
                            <option>Choose</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Type:</label>
                    <select name="type">
                        <option>Choose</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Location:</label>
                    <input type="text" name="location">
                </div>
                <div class="form-group">
                    <label>Category:</label>
                    <select name="category">
                        <option>Choose</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Attendee Capacity:</label>
                    <input type="number" name="capacity">
                </div>
                <div class="form-group">
                    <label>Ticket Type:</label>
                    <select name="ticket_type">
                        <option>Choose</option>
                    </select>
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
                There's no event here
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
</body>
</html>