<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM regist WHERE EMAIL = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['PASSWORD'] === $password) {
            session_regenerate_id(true);
            $_SESSION['email'] = $user['EMAIL'];
            $_SESSION['name'] = $user['NAME'];
            $_SESSION['id'] = $user['ID'];
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Email atau password salah!'); window.location.href='login.php';</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Terjadi kesalahan: " . $e->getMessage() . "'); window.location.href='login.php';</script>";
    }
}
