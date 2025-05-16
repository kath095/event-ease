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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Wishlist</title>
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.1.1/src/regular/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
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

   <main class="wishlist-container">
    <br><br><br>
    <h1 class="wishlist-title">Wishlist</h1>
    <div class="wishlist-grid">
        <?php
            $wishlist = [
                ["title" => "Event Title 1", "image" => "assets/event1.png"],
                ["title" => "Event Title 2", "image" => "assets/event1.png"],
                ["title" => "Event Title 3", "image" => "assets/event1.png"]
            ];

            foreach ($wishlist as $item) {
                echo '
                <div class="wishlist-item">
                    <img src="' . $item["image"] . '" alt="Event Image" class="wishlist-img">
                    <div class="wishlist-content">
                        <h2 class="wishlist-name">' . $item["title"] . '</h2>
                        <div class="wishlist-buttons">
                            <a href="event.php" class="btn btn-detail-event">Detail Event</a>
                            <form method="post" action="hapus_wishlist.php" style="display:inline;">
                                <input type="hidden" name="event_title" value="' . htmlspecialchars($item["title"]) . '">
                                <button type="submit" class="btn btn-remove">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>';
            }
        ?>
    </div>
</main>

</body>
</html>
