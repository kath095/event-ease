<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventRegistId = $_POST['id'] ?? null;
    $rating = $_POST['rating'] ?? null;
    $review = $_POST['review'] ?? '';

    // Validasi sederhana
    if (!$eventRegistId || !$rating || $rating < 1 || $rating > 5) {
        die('Invalid input.');
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO event_regist_review (review, rating, event_regist_id) VALUES (:review, :rating, :event_regist_id)");
        $stmt->execute([
            ':review' => $review,
            ':rating' => $rating,
            ':event_regist_id' => $eventRegistId
        ]);

        // Redirect to the previous page with a success message using query string
        header("Location: my_activity_history.php?message=Review+submitted+successfully.");
        exit;  // Always call exit after header redirect to ensure no further code is executed
    } catch (PDOException $e) {
        // If an error occurs, redirect back with an error message
        header("Location: my_activity_history.php?message=Error:+" . $e->getMessage());
        exit;
    }
} else {
    echo "Invalid request method.";
}
