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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                </div>
                <div class="nav-login">
                    <span class="user-email"></span>
                    <a href="logout.php" class="btn-logout">Logout</a>
                </div>
            </div>
        </nav>
    </header>