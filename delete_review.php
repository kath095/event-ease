<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id) {
        try {
            // Prepare and execute the delete query
            $stmt = $pdo->prepare("DELETE FROM event_regist_review WHERE id = :id");
            $stmt->execute(['id' => $id]);

            // Redirect to my_activity_history.php with a success message
            header("Location: my_activity_history.php?message=Review+deleted+successfully.");
            exit;  // Ensure no further code is executed after the redirect
        } catch (PDOException $e) {
            // Handle the error by redirecting with an error message
            header("Location: my_activity_history.php?message=Error:+" . $e->getMessage());
            exit;
        }
    } else {
        echo "Invalid request.";
    }
} else {
    echo "Invalid request method.";
}
