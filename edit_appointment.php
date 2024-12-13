<?php
$conn = new mysqli("localhost", "root", "", "workshop");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

$appointmentId = $data['appointment_id'];
$newDate = $data['new_date'];
$newMechanicId = $data['new_mechanic_id'];

// Fetch current mechanic of the appointment
$sql = "SELECT mechanic_id FROM appointments WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $appointmentId);
$stmt->execute();
$currentMechanic = $stmt->get_result()->fetch_assoc()['mechanic_id'];

// Update the appointment
$sql = "UPDATE appointments SET date = ?, mechanic_id = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $newDate, $newMechanicId, $appointmentId);
$stmt->execute();

// Update current_clients for old and new mechanics
$sql = "UPDATE mechanics SET current_clients = current_clients - 1 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $currentMechanic);
$stmt->execute();

$sql = "UPDATE mechanics SET current_clients = current_clients + 1 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $newMechanicId);
$stmt->execute();

echo "Appointment updated successfully.";
$conn->close();
?>
