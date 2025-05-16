<?php
include('db.php'); // Menghubungkan ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi password
    if ($password !== $confirm_password) {
        echo "Password dan konfirmasi password tidak cocok.";
        exit();
    }

    // Mengecek apakah email sudah ada di database
    $query = "SELECT * FROM regist WHERE email = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email sudah terdaftar.";
        exit();
    }

   // Simpan password tanpa hash 
    $hashed_password = $password;


    // Menyimpan data ke database
    $query = "INSERT INTO regist (name, gender, age, email, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssiss", $name, $gender, $age, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "Pendaftaran berhasil! <a href='login.php'>Login disini</a>";
    } else {
        echo "Terjadi kesalahan saat mendaftar.";
    }
}
?>
