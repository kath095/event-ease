<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/config.php';

// Initialize variables
$error = null;
$event = null;
$eventDate = null;
$timeStart = null;
$timeEnd = null;
$location = null;
$remind = null;
$isReminded = false; // New variable to track if event is already reminded
$daysRemaining = 0;  // Initialize days remaining variable

// Process event title from URL
if (isset($_GET['event_title']) && !empty($_GET['event_title'])) {
    // Decode the event title, replacing hyphens back to spaces
    $eventTitle = htmlspecialchars(str_replace('-', ' ', $_GET['event_title']));

    try {
        // Prepare the SQL query to get event details based on event title
        $stmt = $pdo->prepare("SELECT * FROM events WHERE title = :event_title LIMIT 1");
        $stmt->execute(['event_title' => $eventTitle]);

        // Fetch the event data
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($event) {
            // Format the event date and times
            $date = new DateTime($event['event_date']);
            $eventDate = $date->format('d M Y');
            $timeStart = (new DateTime($event['time_start']))->format('H:i');
            $timeEnd = (new DateTime($event['time_end']))->format('H:i');
            $location = $event['location'];
            
            // Check if remind value exists and get days remaining
            $isReminded = !empty($event['remind']);
            $daysRemaining = isset($event['days_remaining']) ? (int)$event['days_remaining'] : 0;
        } else {
            $error = "Event not found.";
        }
    } catch (PDOException $e) {
        $error = "Database error occurred. Please try again later.";
        // Log the actual error for administrators
        error_log("Event details error: " . $e->getMessage());
    }
} else {
    $error = "No event title specified.";
}

// Handle AJAX request for updating reminder status
if (isset($_POST['action']) && $_POST['action'] === 'updateRemind') {
    $response = ['success' => false, 'message' => ''];
    
    if (isset($_POST['event_id']) && isset($_POST['remind_status'])) {
        $eventId = $_POST['event_id'];
        $remindStatus = $_POST['remind_status'] ? 1 : 0;
        $daysRemaining = isset($_POST['days_remaining']) ? (int)$_POST['days_remaining'] : null;
        
        try {
            // If turning on reminder and days are specified
            if ($remindStatus && $daysRemaining !== null) {
                $updateStmt = $pdo->prepare("UPDATE events SET remind = :remind_status, days_remaining = :days_remaining WHERE id = :event_id");
                $result = $updateStmt->execute([
                    'remind_status' => $remindStatus,
                    'days_remaining' => $daysRemaining,
                    'event_id' => $eventId
                ]);
            } else {
                // If turning off reminder
                $updateStmt = $pdo->prepare("UPDATE events SET remind = :remind_status, days_remaining = NULL WHERE id = :event_id");
                $result = $updateStmt->execute([
                    'remind_status' => $remindStatus,
                    'event_id' => $eventId
                ]);
            }
            
            if ($result) {
                $response = ['success' => true, 'message' => 'Reminder status updated successfully'];
            } else {
                $response = ['success' => false, 'message' => 'Failed to update reminder status'];
            }
        } catch (PDOException $e) {
            $response = ['success' => false, 'message' => 'Database error occurred'];
            error_log("Reminder update error: " . $e->getMessage());
        }
    } else {
        $response = ['success' => false, 'message' => 'Missing required parameters'];
    }
    
    // Return JSON response for AJAX
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Get message from URL if present (with proper sanitization)
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';
?>

<main class="main-container">
    <div class="page-header">
        <h1>Activity History</h1>
        <h2>Your Upcoming Event</h2>
    </div>

    <div class="event-details-container">
        <?php if ($error): ?>
            <p class="error-message"><?= $error ?></p>
        <?php else: ?>
            <div class="main-event">
                <div class="event-image">
                    <img src="assets/<?= htmlspecialchars($event['photo_event']) ?>" alt="Event Image">
                </div>
                <div class="event-content">
                    <h2 class="event-title"><?= htmlspecialchars($event['title']) ?></h2>
                    <p class="event-meta"><?= $eventDate ?> 🗺 <?= htmlspecialchars($location) ?></p>
                    <p class="event-description"><?= htmlspecialchars($event['description']) ?></p>
                    <p class="event-time">Time: <?= $timeStart ?> - <?= $timeEnd ?></p>
                    
                    <?php if (!$isReminded): ?>
                        <button class="btn-remind" id="remindBtn">Remind me</button>
                    <?php endif; ?>
                    
                    <div id="remindActions">
                        <?php if ($isReminded): ?>
                            <button class="btn-remind" id="dayRemainingBtn"><?= $daysRemaining ?> days remaining</button>
                            <button class="btn-stop-remind" id="stopRemindBtn">Stop Remind</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
    </div>

            <div class="upcoming-activities">
                <h3>Other Upcoming Events</h3>
                <div class="events-grid">
                    <?php
                    try {
                        if (isset($_SESSION['id'])) {
                            $userId = $_SESSION['id'];
                            $stmt = $pdo->prepare("
                                SELECT e.*
                                FROM events e
                                INNER JOIN events_regist er ON er.event_id = e.id
                                WHERE er.regist_id = :user_id AND er.status = 'belum'
                                ORDER BY e.event_date ASC
                            ");
                            $stmt->execute(['user_id' => $userId]);

                            $eventCount = 0;
                            while ($upcomingEvent = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $eventCount++;
                                $eventDate = new DateTime($upcomingEvent['event_date']);
                                $day = $eventDate->format('d');
                                $month = strtoupper($eventDate->format('M'));
                                $eventTitle = htmlspecialchars($upcomingEvent['title']);
                                $eventSlug = str_replace(' ', '-', $eventTitle);
                                ?>
                                <a href="event_details.php?event_title=<?= urlencode($eventSlug) ?>" class="event-card-link">
                                    <div class="event-card">
                                        <img src="assets/<?= htmlspecialchars($upcomingEvent['photo_event']) ?>" alt="<?= $eventTitle ?>">
                                        <div class="card-content">
                                            <div class="event-date">
                                                <div class="month"><?= $month ?></div>
                                                <div class="day"><?= $day ?></div>
                                            </div>
                                            <div class="event-info">
                                                <h3><?= $eventTitle ?></h3>
                                                <p><?= htmlspecialchars(substr($upcomingEvent['description'], 0, 100)) ?>...</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <?php
                            }
                            
                            if ($eventCount === 0) {
                                echo '<p class="no-events">No upcoming events found.</p>';
                            }
                        } else {
                            echo '<p class="login-required">Please log in to view your upcoming events.</p>';
                        }
                    } catch (PDOException $e) {
                        echo '<p class="error-message">Unable to load upcoming events.</p>';
                        error_log("Upcoming events error: " . $e->getMessage());
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
    .main-container {
        margin: 50px 50px;
        text-align: start;
        max-width: 1400px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .page-header {
        margin-bottom: 30px;
    }
    
    .error-message {
        color: #dc3545;
        font-weight: bold;
        padding: 15px;
        background-color: #f8d7da;
        border-radius: 5px;
    }
    
    .event-details-container {
        margin-top: 0;
    }
    
    .main-event {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        align-items: start;
        margin-bottom: 40px;
        max-width: 1400px;
    }
    
    .event-image img {
        width: 100%;
        max-width: 700px;
        height: auto;
        border-radius: 20px;
        object-fit: cover;
    }
    
    .event-content {
        max-width: 500px;
        padding-top: 0;
        margin-top: 0;
    }
    
    .event-title {
        font-size: 24px;
        color: #1a1a1a;
        margin-top: 0;
        margin-bottom: 10px;
    }
    
    .event-meta {
        color: #666;
        margin-bottom: 15px;
        line-height: 1.3;
    }
    
    .event-description {
        margin-bottom: 15px;
        line-height: 1.5;
    }
    
    .event-time {
        font-weight: bold;
        margin-bottom: 20px;
    }
    
    .btn-remind {
        padding: 10px 20px;
        background-color: #dc3545;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
    
    .btn-remind:hover {
        background-color: #c82333;
    }

    .btn-stop-remind {
    padding: 10px 20px;
    background-color: #6c757d;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    margin-left: 10px;
}

.btn-stop-remind:hover {
    background-color: #5a6268;
}
    
    .upcoming-activities h3 {
        margin-bottom: 20px;
        color: #333;
    }
    
    .events-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .event-card-link {
        text-decoration: none;
        color: inherit;
        width: calc(33.33% - 14px);
        min-width: 250px;
        transition: transform 0.3s ease;
    }
    
    .event-card-link:hover {
        transform: translateY(-5px);
    }
    
    .event-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: white;
    }
    
    .event-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    
    .card-content {
        padding: 15px;
        display: flex;
        gap: 15px;
    }
    
    .event-date {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 5px 10px;
        background-color: #f8f9fa;
        border-radius: 5px;
        min-width: 50px;
    }
    
    .month {
        font-size: 14px;
        font-weight: bold;
        color: #dc3545;
    }
    
    .day {
        font-size: 18px;
        font-weight: bold;
    }
    
    .event-info h3 {
        margin-top: 0;
        margin-bottom: 10px;
        color: #333;
    }
    
    .event-info p {
        color: #666;
        font-size: 14px;
        line-height: 1.4;
        margin: 0;
    }
    
    .no-events, .login-required {
        color: #666;
        font-style: italic;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 5px;
        text-align: center;
    }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
        .main-container {
            margin: 40px 20px;
        }
        
        .main-event {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .event-image {
            text-align: center;
        }
        
        .event-image img {
            width: 100%;
            max-width: 600px;
        }
        
        .event-content {
            padding-top: 0;
            max-width: 100%;
        }
        
        .event-card-link {
            width: calc(50% - 10px);
        }
    }
    
    @media (max-width: 576px) {
        .event-card-link {
            width: 100%;
        }
        
        .event-image img {
            max-width: 100%;
        }
    }
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Only proceed if we have an event
    <?php if (isset($event) && $event): ?>
    const remindBtn = document.getElementById('remindBtn');
    const remindActions = document.getElementById('remindActions');
    const eventId =                                       <?php echo $event['id'] ?>;
    const eventTitle = "<?php echo addslashes($event['title']) ?>";
    const eventDate = "<?php echo $event['event_date'] ?>"; // Format: YYYY-MM-DD
    const eventLocation = "<?php echo addslashes($location) ?>";

    // Function to request notification permission
    function requestNotificationPermission() {
        if (!("Notification" in window)) {
            alert("This browser does not support desktop notifications");
            return false;
        }

        if (Notification.permission === "granted") {
            return true;
        } else if (Notification.permission !== "denied") {
            Notification.requestPermission().then(function (permission) {
                return permission === "granted";
            });
        }
        return Notification.permission === "granted";
    }

    // Function to show notification
    function showNotification(title, body, tag) {
        if (Notification.permission === "granted") {
            const options = {
                body: body,
                icon: '/assets/favicon.ico', // Replace with your site's favicon or logo
                tag: tag,
                requireInteraction: true // Notification remains until user interacts with it
            };

            const notification = new Notification(title, options);

            notification.onclick = function() {
                window.focus();
                notification.close();
            };

            return notification;
        }
    }

    // Function to schedule a reminder notification
    function scheduleReminder(days) {
        // Store reminder information in localStorage
        const reminderData = {
            eventId: eventId,
            eventTitle: eventTitle,
            eventDate: eventDate,
            eventLocation: eventLocation,
            reminderDate: new Date(new Date().getTime() + days * 24 * 60 * 60 * 1000).toISOString()
        };

        localStorage.setItem(`eventReminder_${eventId}`, JSON.stringify(reminderData));


        // Show immediate notification that reminder has been set
        showNotification(
            "Reminder Set",
            `You will be reminded about${eventTitle} in ${days} days.`,
            `reminder_set_${eventId}`
        );

        // Check if the event is due today
        checkTodayEvents();
    }

    // Function to check and trigger notifications for today's events
    function checkTodayEvents() {
        // Check all reminders in localStorage
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);

            if (key && key.startsWith('eventReminder_')) {
                try {
                    const reminderData = JSON.parse(localStorage.getItem(key));
                    const reminderDate = new Date(reminderData.reminderDate);
                    const today = new Date();

                    // Reset hours to compare just the dates
                    today.setHours(0, 0, 0, 0);
                    reminderDate.setHours(0, 0, 0, 0);

                    // If reminder date is today or in the past
                    if (reminderDate <= today) {
                        showNotification(
                            'Event Reminder: ${reminderData.eventTitle}',
                            `Your event is coming up on ${new Date(reminderData.eventDate).toLocaleDateString()}. Location: ${reminderData.eventLocation}`,
                            `event_reminder_${reminderData.eventId}`
                        );

                        // Remove the reminder after it's triggered
                        localStorage.removeItem(key);
                    }
                } catch (e) {
                    console.error('Error processing reminder:', e);
                }
            }
        }
    }

    // Function to cancel a reminder
    function cancelReminder() {
        localStorage.removeItem('eventReminder_${eventId}');

        // Show notification that reminder has been cancelled
        showNotification(
            "Reminder Cancelled",
            `Reminder for "${eventTitle}" has been cancelled.`,
            `reminder_cancel_${eventId}`
        );
    }

    // If remind button exists, add event listener
    if (remindBtn) {
        remindBtn.addEventListener('click', function () {
            // Request permission for notifications
            if (requestNotificationPermission()) {
                // Hide the main button
                remindBtn.style.display = 'none';

                // Calculate days remaining
                const today = new Date();
                today.setHours(0, 0, 0, 0); // Reset time to midnight

                const eventDateObj = new Date(eventDate);
                eventDateObj.setHours(0, 0, 0, 0); // Reset time to midnight

                // Calculate difference in days
                const oneDayMs = 24 * 60 * 60 * 1000; // milliseconds in one day
                const diffDays = Math.round((eventDateObj - today) / oneDayMs);

                // If event is in the future, use the days remaining, otherwise 0
                const dayRemaining = diffDays > 0 ? diffDays : 0;

                // Display the reminder buttons
                remindActions.innerHTML = `
                    <button class="btn-remind" id="dayRemainingBtn">${dayRemaining} days remaining</button>
                    <button class="btn-stop-remind" id="stopRemindBtn">Stop Remind</button>
                `;

                // Schedule browser notification
                scheduleReminder(dayRemaining);

                // Update database with remind status = 1 and days_remaining
                updateRemindStatus(eventId, true, dayRemaining);

                // Add event listener for Stop Remind button
                addStopRemindListener();
            } else {
                alert("Notification permission is required to set reminders.");
            }
        });
    }

    // Add event listener for Stop Remind button if it exists
    addStopRemindListener();

    // Function to add event listener to Stop Remind button
    function addStopRemindListener() {
        const stopRemindBtn = document.getElementById('stopRemindBtn');
        if (stopRemindBtn) {
            stopRemindBtn.addEventListener('click', function () {
                // Cancel browser notification
                cancelReminder();

                // Remove reminder buttons
                remindActions.innerHTML = '';

                // Show the "Remind me" button again if it exists
                if (remindBtn) {
                    remindBtn.style.display = 'inline-block';
                } else {
                    // Create the remind button if it doesn't exist
                    const newRemindBtn = document.createElement('button');
                    newRemindBtn.className = 'btn-remind';
                    newRemindBtn.id = 'remindBtn';
                    newRemindBtn.textContent = 'Remind me';

                    // Insert before remindActions
                    remindActions.parentNode.insertBefore(newRemindBtn, remindActions);

                    // Add event listener to new button
                    newRemindBtn.addEventListener('click', function() {
                        if (requestNotificationPermission()) {
                            newRemindBtn.style.display = 'none';

                            // Calculate days remaining
                            const today = new Date();
                            today.setHours(0, 0, 0, 0); // Reset time to midnight

                            const eventDateObj = new Date(eventDate);
                            eventDateObj.setHours(0, 0, 0, 0); // Reset time to midnight

                            // Calculate difference in days
                            const oneDayMs = 24 * 60 * 60 * 1000; // milliseconds in one day
                            const diffDays = Math.round((eventDateObj - today) / oneDayMs);

                            // If event is in the future, use the days remaining, otherwise 0
                            const dayRemaining = diffDays > 0 ? diffDays : 0;

                            // Display reminder buttons
                            remindActions.innerHTML = `
                                <button class="btn-remind" id="dayRemainingBtn">${dayRemaining} days remaining</button>
                                <button class="btn-stop-remind" id="stopRemindBtn">Stop Remind</button>
                            `;

                            // Schedule browser notification
                            scheduleReminder(dayRemaining);

                            // Update database with remind status=1 and days_remaining
                            updateRemindStatus(eventId, true, dayRemaining);

                            // Add event listener for new Stop Remind button
                            addStopRemindListener();
                        } else {
                            alert("Notification permission is required to set reminders.");
                        }
                    });
                }

                // Update database with remind status = 0
                updateRemindStatus(eventId, false);
            });
        }
    }

    // Function to update remind status in the database
    function updateRemindStatus(eventId, status, daysRemaining = null) {
        // Create form data
        const formData = new FormData();
        formData.append('action', 'updateRemind');
        formData.append('event_id', eventId);
        formData.append('remind_status', status ? 1 : 0);

        // If days remaining provided, add to form data
        if (daysRemaining !== null) {
            formData.append('days_remaining', daysRemaining);
        }

        // Send AJAX request
        fetch('event_details.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Error updating remind status:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Set up periodic check for event reminders (every hour)
    setInterval(checkTodayEvents, 60 * 60 * 1000);

    // Check for reminders on page load
    checkTodayEvents();

    <?php endif; ?>
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>