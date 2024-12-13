<?php
$conn = new mysqli("localhost", "root", "", "workshop");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$car_license = $_POST['car_license'];
$car_engine = $_POST['car_engine'];
$date = $_POST['date'];
$mechanic_id = $_POST['mechanic'];

// Check if the client already has an appointment on the selected date
$sql = "SELECT * FROM appointments WHERE client_id = (SELECT id FROM clients WHERE car_license = ?) AND date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $car_license, $date);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "You already have an appointment on this date.";
    exit;
}

// Check if the mechanic has available slots
$sql = "SELECT current_clients, max_clients FROM mechanics WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $mechanic_id);
$stmt->execute();
$mechanic = $stmt->get_result()->fetch_assoc();

if ($mechanic['current_clients'] >= $mechanic['max_clients']) {
    echo "Selected mechanic is fully booked.";
    exit;
}

// Insert client and appointment
$conn->begin_transaction();

try {
    // Insert or update client
    $sql = "INSERT INTO clients (name, address, phone, car_license, car_engine) VALUES (?, ?, ?, ?, ?) 
            ON DUPLICATE KEY UPDATE name = VALUES(name), address = VALUES(address), phone = VALUES(phone)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $address, $phone, $car_license, $car_engine);
    $stmt->execute();

    $client_id = $conn->insert_id;

    // Insert appointment
    $sql = "INSERT INTO appointments (client_id, mechanic_id, date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $client_id, $mechanic_id, $date);
    $stmt->execute();

    // Update mechanic slots
    $sql = "UPDATE mechanics SET current_clients = current_clients + 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $mechanic_id);
    $stmt->execute();

    $conn->commit();
    echo "Appointment booked successfully!";
} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>
