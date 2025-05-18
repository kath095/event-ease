<?php
require 'config.php'; // koneksi ke database

// Ambil data dari POST
$event_id = $_POST['event_id'];
$remind = $_POST['remind'] === 'true' ? 1 : 0;

// Cek validasi dasar
if (!is_numeric($event_id)) {
    echo json_encode(['success' => false, 'message' => 'Invalid event ID']);
    exit;
}

// Update kolom remind
$stmt = $conn->prepare("UPDATE your_table_name SET remind = ? WHERE id = ?");
$stmt->bind_param("ii", $remind, $event_id);
$success = $stmt->execute();

echo json_encode(['success' => $success]);
?>