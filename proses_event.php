<?php
session_start();
include('db.php');

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari POST
    $title = trim($_POST['title']);
    $short_desc = trim($_POST['short_description']);
    $description = trim($_POST['description']);
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $type = $_POST['type'];
    $location = trim($_POST['location']);
    $category = $_POST['category'];
    $capacity = trim($_POST['capacity']);
    $price = isset($_POST['price']) ? trim($_POST['price']) : "";

    // Validasi form kosong
    if (
        empty($title) ||
        empty($short_desc) ||
        empty($description) ||
        !isset($_FILES['event_image']) || $_FILES['event_image']['error'] != 0 ||
        empty($date) ||
        empty($start_time) ||
        empty($end_time) ||
        empty($type) ||
        empty($location) ||
        empty($category) ||
        empty($capacity) ||
        !isset($_POST['agreement'])
    ) {
        echo "<script>alert('Semua field wajib diisi, kecuali harga. Pastikan checkbox dicentang dan gambar diunggah.'); window.history.back();</script>";
        exit();
    }

    // Validasi panjang short_desc
    if (strlen($short_desc) > 150) {
        echo "<script>alert('Short Description tidak boleh lebih dari 150 karakter.'); window.history.back();</script>";
        exit();
    }

    // Jika harga kosong, anggap gratis
    if ($price == "") {
        $price = 0;
    } else {
        // Hapus format ribuan dan konversi ke float
        $price = str_replace('.', '', $price);
        $price = str_replace(',', '.', $price);
    }

    // Ambil user_id dari email login
    $email = $_SESSION['email'];
    $query_user = $mysqli->prepare("SELECT user_id FROM users WHERE email = ?");
    $query_user->bind_param("s", $email);
    $query_user->execute();
    $result_user = $query_user->get_result();
    $user = $result_user->fetch_assoc();
    $user_id = $user['user_id'];

    // Proses gambar
    $image_data = file_get_contents($_FILES['event_image']['tmp_name']);

    // Masukkan ke database (perhatikan urutan: event_type disisipkan dengan benar!)
    $stmt = $mysqli->prepare("INSERT INTO events 
        (user_id, title, short_desc, description, image, event_date, event_start_time, event_end_time, event_type, location, category, price, attendee_capacity)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("issssssssssdi",
        $user_id,        // i
        $title,          // s
        $short_desc,     // s
        $description,    // s
        $image_data,     // s
        $date,           // s
        $start_time,     // s
        $end_time,       // s
        $type,           // s
        $location,       // s
        $category,       // s
        $price,          // d
        $capacity        // i
    );


    if ($stmt->execute()) {
        echo "<script>alert('Event berhasil disimpan.'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Gagal menyimpan event: " . $stmt->error;
    }
}
?>
