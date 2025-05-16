<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/regular/style.css">
</head>

<body>
    <header class="header-dashboard">
        <nav class="navbar">
            <div class="nav-container">
                <div class="nav-links">
                    <a href="#">Home</a>
                    <a href="#">Event</a>
                    <a href="#">Payment</a>
                    <a href="#">Reminder</a>
                    <?php if (isset($_SESSION['id'])) : ?>
                        <!-- TRUE -->
                        <a href="my_activity_history.php">Your Events</a>
                    <?php endif ?>
                </div>
                <div class="nav-login">
                    <span class="user-email">Welcome, <?= htmlspecialchars($_SESSION['email']); ?></span>
                    <a href="logout.php" class="btn-logout">Logout</a>
                </div>
            </div>

        </nav>
    </header>

    <main>
        <section class="slider-container">
            <div class="slider-item">
                <img src="assets/img4.jpg" alt="" class="slider-img" />
                <div class="slider-content">
                    <h1 class="slider-title">Welcome to EventEase</h1>
                    <p class="slider-desc">Manage your events, payments, and reminders easily.</p>
                </div>
            </div>
            <div class="slider-item">
                <img src="assets/img2.jpg" alt="" class="slider-img" />
                <div class="slider-content">
                    <h1 class="slider-title">Welcome to EventEase</h1>
                    <p class="slider-desc">Manage your events, payments, and reminders easily.</p>
                </div>
            </div>
            <div class="slider-item">
                <img src="assets/img3.jpg" alt="" class="slider-img" />
                <div class="slider-content">
                    <h1 class="slider-title">Welcome to EventEase</h1>
                    <p class="slider-desc">Manage your events, payments, and reminders easily.</p>
                </div>
            </div>
        </section>

        <section id="event">
            <div class="event container">
                <h1>Upcoming Events</h1>
                <div class="filter-buttons">
                    <button class="filter-btn">
                        Event Type <i class="ph ph-caret-down"></i>
                    </button>
                    <button class="filter-btn">
                        Any Category <i class="ph ph-caret-down"></i>
                    </button>
                </div>



                <div class="event-bottom">
                    <div class="event-item">
                        <img src="assets/event1.png" alt="Event" class="event-img" />
                        <div class="event-details">
                            <div class="date">
                                <span>APR</span><br>
                                <strong>14</strong>
                            </div>
                            <div class="desc">
                                <h2>EVENT NAME</h2>
                                <p>some event description</p>
                            </div>
                        </div>
                    </div>
                    <div class="event-item">
                        <img src="assets/event1.png" alt="Event" class="event-img" />
                        <div class="event-details">
                            <div class="date">
                                <span>MTH</span><br>
                                <strong>00</strong>
                            </div>
                            <div class="desc">
                                <h2>EVENT NAME</h2>
                                <p>some event description</p>
                            </div>
                        </div>
                    </div>
                    <div class="event-item">
                        <img src="assets/event1.png" alt="Event" class="event-img" />
                        <div class="event-details">
                            <div class="date">
                                <span>MTH</span><br>
                                <strong>00</strong>
                            </div>
                            <div class="desc">
                                <h2>EVENT NAME</h2>
                                <p>some event description</p>
                            </div>
                        </div>
                    </div>
                    <div class="event-item">
                        <img src="assets/event1.png" alt="Event" class="event-img" />
                        <div class="event-details">
                            <div class="date">
                                <span>MTH</span><br>
                                <strong>00</strong>
                            </div>
                            <div class="desc">
                                <h2>EVENT NAME</h2>
                                <p>some event description</p>
                            </div>
                        </div>
                    </div>
                    <div class="event-item">
                        <img src="assets/event1.png" alt="Event" class="event-img" />
                        <div class="event-details">
                            <div class="date">
                                <span>MTH</span><br>
                                <strong>00</strong>
                            </div>
                            <div class="desc">
                                <h2>EVENT NAME</h2>
                                <p>some event description</p>
                            </div>
                        </div>
                    </div>
                    <div class="event-item">
                        <img src="assets/event1.png" alt="Event" class="event-img" />
                        <div class="event-details">
                            <div class="date">
                                <span>MTH</span><br>
                                <strong>00</strong>
                            </div>
                            <div class="desc">
                                <h2>EVENT NAME</h2>
                                <p>some event description</p>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="load-more">Load More</button>
            </div>
        </section>

        <section class="create-events">
            <div class="create-events-container">
                <div class="create-events-left"></div>
                <div class="create-events-right">
                    <h2>Make your own Event</h2>
                    <p>Come and join us to make your event more <br>fun and......</p>
                    <a href="#" class="btn-create-event">Create Events</a>
                </div>
            </div>
        </section>

        <section class="review">
            <h2>Review</h2>
            <div class="review-container">
                <div class="review-item">
                    <img src="assets/review1.png" alt="Utsuru 2.5">
                    <h3>Utsuru 2.5</h3>
                    <div class="rating">
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                        <span class="star">&#9734;</span>
                    </div>
                </div>
                <div class="review-item">
                    <img src="assets/review2.png" alt="K-POP FEST 2.1">
                    <h3>K-POP FEST 2.1</h3>
                    <div class="rating">
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                        <span class="star">&#9734;</span>
                    </div>
                </div>
                <div class="review-item">
                    <img src="assets/review3.png" alt="Workshop SPACE SCIFI">
                    <h3>Workshop SPACE SCIFI</h3>
                    <div class="rating">
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                        <span class="star filled">&#9733;</span>
                        <span class="star half">&#9733;</span>
                    </div>
                </div>
            </div>
        </section>
    </main>

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
        <p class="cr">&copy; 2025 EventEase. All Rights Reserved.</p>
    </footer>
    <script src="sliderdashboard.js" defer></script>
</body>