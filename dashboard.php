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
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="nav-container">
                <div class="nav-links">
                    <a href="#">Home</a>
                    <a href="#">Event</a>
                    <a href="#">Payment</a>
                    <a href="#">Reminder</a>
                </div>
                <div class="nav-login">
                    <span class="user-email">Welcome, <?= htmlspecialchars($_SESSION['email']); ?></span>
                    <a href="logout.php" class="btn-logout">Logout</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section class="dashboard-content">
            <h1>Welcome to Your Dashboard</h1>
            <p>Manage your events, payments, and reminders easily.</p>
        </section>

        <section id="event">
            <div class="event container">
                <h1>Upcoming Events</h1>
            <div class="event-bottom">
                <div class="event-item">
                    <img src="assets/img1.jpg" alt="Event" class="event-img" />
                    <div class="event-details">
                        <div class="date">
                            <span>MTH</span><br>
                            <span>00</span>
                        </div>
                        <div class="desc">
                            <h2>EVENT NAME</h2>
                            <p>some event description</p>
                        </div>
                    </div>
                </div>
                <div class="event-item">
                    <img src="assets/img1.jpg" alt="Event" class="event-img" />
                    <div class="event-details">
                        <div class="date">
                            <span>MTH</span><br>
                            <span>00</span>
                        </div>
                        <div class="desc">
                            <h2>EVENT NAME</h2>
                            <p>some event description</p>
                        </div>
                    </div>
                </div>
                <div class="event-item">
                    <img src="assets/img1.jpg" alt="Event" class="event-img" />
                    <div class="event-details">
                        <div class="date">
                            <span>MTH</span><br>
                            <span>00</span>
                        </div>
                        <div class="desc">
                            <h2>EVENT NAME</h2>
                            <p>some event description</p>
                        </div>
                    </div>
                </div>
                <div class="event-item">
                    <img src="assets/img1.jpg" alt="Event" class="event-img" />
                    <div class="event-details">
                        <div class="date">
                            <span>MTH</span><br>
                            <span>00</span>
                        </div>
                        <div class="desc">
                            <h2>EVENT NAME</h2>
                            <p>some event description</p>
                        </div>
                    </div>
                </div>
                <div class="event-item">
                    <img src="assets/img1.jpg" alt="Event" class="event-img" />
                    <div class="event-details">
                        <div class="date">
                            <span>MTH</span><br>
                            <span>00</span>
                        </div>
                        <div class="desc">
                            <h2>EVENT NAME</h2>
                            <p>some event description</p>
                        </div>
                    </div>
                </div>
                <div class="event-item">
                    <img src="assets/img1.jpg" alt="Event" class="event-img" />
                    <div class="event-details">
                        <div class="date">
                            <span>MTH</span><br>
                            <span>00</span>
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

        <section id="add">
            <div class="add-container">
                <div class="left-side">
                    <!-- sementara masih blank -->
                </div>
                <div class="right-side">
                    <h1>Make your own Event</h1>
                    <p>Come and join us to make your event more fun and...</p>
                    <button class="create-event-btn">Create Events</button>
                </div>
            </div>
        </section>

        <section class="review">
            <h2>Review</h2>
                <div class="review-container">
                    <div class="review-item">
                        <img src="assets/img1.jpg" alt="Utsuru 2.5">
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
                        <img src="assets/img1.jpg" alt="K-POP FEST 2.1">
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
                        <img src="assets/img1.jpg" alt="Workshop SPACE SCIFI">
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

    <footer>
        <p>&copy; 2025 Your Website. All Rights Reserved.</p>
    </footer>
</body>