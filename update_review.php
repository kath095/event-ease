<?php
require 'config.php'; // koneksi database 

// Cek apakah data dari form sudah ada (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $eventRegistId = $_POST['id']; // ID registrasi acara
    $rating = $_POST['rating']; // Rating yang dipilih
    $review = $_POST['review']; // Ulasan yang diberikan

    if (!empty($eventRegistId) && !empty($rating) && !empty($review)) {
        $stmt = $pdo->prepare("
            UPDATE event_regist_review
            SET rating = :rating, review = :review
            WHERE id = :event_regist_id
        ");

        $stmt->execute([
            ':rating' => $rating,
            ':review' => $review,
            ':event_regist_id' => $eventRegistId
        ]);

        if ($stmt->rowCount() > 0) {
            header('Location: my_activity_history.php?message=Review+berhasil+di+perbarui');
        } else {
            header('Location: my_activity_history.php?message=Tidak+ada+perubahan');
            exit; // Pastikan script berhenti setelah redirect
        }
    } else {
        header('Location: my_activity_history.php?message=Semua+harus+diisi');
        exit; // Pastikan script berhenti setelah redirect
    }
}
