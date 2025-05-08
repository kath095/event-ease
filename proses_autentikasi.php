<?php
session_start();
include 'db.php'; // koneksi ke database

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$sql = "SELECT * FROM regist WHERE EMAIL = ? AND PASSWORD = ?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "ss", $email, $password);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['email'] = $row['EMAIL']; // simpan ke session
    header("Location: dashboard.php");
    exit();
} else {
    echo "Email atau password salah!";
}
?>
