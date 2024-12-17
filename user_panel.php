<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Panel</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <h1>Car Workshop Appointment</h1>
    <form id="appointment-form" action="process_appointment.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>
        
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>
        
        <label for="car_license">Car License Number:</label>
        <input type="text" id="car_license" name="car_license" required>
        
        <label for="car_engine">Car Engine Number:</label>
        <input type="text" id="car_engine" name="car_engine" required>
        
        <label for="date">Appointment Date:</label>
        <input type="date" id="date" name="date" required>
        
        <label for="mechanic">Choose Mechanic:</label>
        <select id="mechanic" name="mechanic" required>
            <!-- Mechanics will be populated here through DBs -->
        </select>
        
        <button type="submit">Book Appointment</button>
    </form>

    <script src="script.js"></script>
</body>
</html>
