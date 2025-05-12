<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Payment</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="nav-left">
            <a href="dashboard.php">Home</a>
            <a href="#">Event</a>
            <a href="#">Payment</a>
            <a href="#">Reminder</a>
        </div>
        <div class="nav-right">
            <div class="user-icon"></div>
            <span>Nama user</span>
        </div>
    </div>

    <!-- Main Section -->
    <div class="container">
        <!-- Left Column -->
        <div class="left">
            <h2>Payment</h2>
            <h3>Event Title :</h3>

            <label>Price :</label>
            <input type="text" placeholder="Auto generated" disabled>

            <label>Via :</label>
            <select>
                <option disabled selected>Type here...</option>
                <option>QR</option>
                <option>eWallet</option>
            </select>

            <p class="disclaimer">
                *By continuing the registration or payment, I understand that EventExec only acts as an information provider platform and is not responsible for the content, implementation, or validity of the event created by the organizer. Any form of fraud or loss incurred is the responsibility of the event organizer.
            </p>

            <label class="checkbox">
                <input type="checkbox"> I agree and understand the above statement
            </label>

            <button onclick="location.href='payment_status.php'" class="booked-btn">Booked</button>

        </div>

        <!-- Right Column -->
        <div class="right">
            <h3>Activity History :</h3>

            <div class="card">
                <img src="https://via.placeholder.com/300x150" alt="Event Image">
                <div class="card-info">
                    <p><strong>SEP 18</strong></p>
                    <p>Boys/Girls Band</p>
                    <p>Battle Flip 2025</p>
                    <p class="status">Status</p>
                </div>
            </div>

            <div class="card">
                <img src="https://via.placeholder.com/300x150" alt="Event Image">
                <div class="card-info">
                    <p><strong>SEP 18</strong></p>
                    <p>Boys/Girls Band</p>
                    <p>Battle Flip 2025</p>
                    <p class="status">Status</p>
                </div>
            </div>

            <div class="card">
                <img src="https://via.placeholder.com/300x150" alt="Event Image">
                <div class="card-info">
                    <p><strong>SEP 18</strong></p>
                    <p>Boys/Girls Band</p>
                    <p>Battle Flip 2025</p>
                    <p class="status">Status</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
