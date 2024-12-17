<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html"); // Redirect to login if not an admin
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Admin Panel</h1>

    <!-- Table for displaying appointments -->
    <h2>Appointment List</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Client Name</th>
                <th>Phone</th>
                <th>Car Registration</th>
                <th>Appointment Date</th>
                <th>Mechanic</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="appointments-list">
            <!-- Rows will be populated dynamically -->
        </tbody>
    </table>

    <!-- Table for displaying mechanic availability -->
    <h2>Mechanic Availability</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Mechanic ID</th>
                <th>Mechanic Name</th>
                <th>Max Clients</th>
                <th>Current Clients</th>
                <th>Available Slots</th>
            </tr>
        </thead>
        <tbody id="mechanics-list">
            <!-- Rows will be populated dynamically -->
        </tbody>
    </table>

    <script src="admin_script.js"></script>
</body>
</html>
