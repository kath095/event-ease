<?php
session_start();
if (isset($_SESSION['email'])) {
    header("Location: dashboard.php");
    // exit();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>

<body style="display: flex;">
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-links">
                <a href="#">Home</a>
                <a href="#">Event</a>
                <a href="#">Payment</a>
                <a href="#">Reminder</a>
            </div>
            <div class="nav-login">
                <div class="nav-profile">
                    <i class="ph ph-user-circle"></i>
                </div>
                <span>Login/Register</span>
            </div>
        </div>
    </nav>
    <div class="login-container">
        <h1>Login</h1><br>
        <form action="proses_autentikasi.php" method="post">
            <div class="profile-section">
                <label for="username">
                    <i class="ph ph-envelope"></i> Email :
                </label>
                <input type="text" name="username" placeholder="Type here..." required>
            </div>
            <div class="password-section">
                <label for="password">
                    <i class="ph-fill ph-lock-key"></i> Password :
                </label>
                <input type="password" name="password" placeholder="Type here..." required>
            </div>

            <input class="btn-login" type="submit" value="Login">
        </form>
        <p class="login-footer"> Don't have an account? <a href="register.html">Sign up here!</a></p>
    </div>
</body>