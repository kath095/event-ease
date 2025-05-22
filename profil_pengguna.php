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
    <title>profile</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://unpkg.com/@phosphor-icons/web@2.1.1"></script>
</head>
<body>
<?php include 'includes/header.php'; ?>

<section class="profile-container">
  <div class="profile-left">
    <div class="profile-pic">
      <img src="prfile_user" id="profile-image">
      <input type="file" id="upload-photo" accept="image/*" style="display: none;">
      <div class="icons">
        <i class="ph ph-trash" onclick="hapusFoto()"></i>
        <i class="ph ph-pencil" onclick="document.getElementById('upload-photo').click()"></i>
      </div>
    </div>
  </div>
  <div class="profile-right">
    <div class="input-group">
      <label>Name :</label>
      <div class="input-with-icon">
        <input type="text" placeholder="Name" readonly>
        <i class="ph ph-pencil"></i>
      </div>
    </div>
    <div class="input-group">
      <label>Email :</label>
      <div class="input-with-icon">
        <input type="email" placeholder="@gmail" readonly>
        <i class="ph ph-pencil"></i>
      </div>
    </div>
  </div>
</section>

<div class="info-list">
  <a href="wishlist.php" class="info-item">
    Wishlist <i class="ph ph-caret-right"></i>
  </a>
  <a href="/activity.html" class="info-item">
    Activity History <i class="ph ph-caret-right"></i>
  </a>
  <a href="/reminder.html" class="info-item">
    Reminder <i class="ph ph-caret-right"></i>
  </a>
</div>

<div class="logout-container">
  <a href="login.php" class="logout-btn">Logout</a>
</div>

<script src="profile.js"></script>

</body>
</html>