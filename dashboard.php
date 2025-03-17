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
    <link rel="stylesheet" href="styles-dashboard.css">
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
    </main>

    <footer>
        <p>&copy; 2025 Your Website. All Rights Reserved.</p>
    </footer>
</body>
