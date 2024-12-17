<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli("localhost", "root", "", "workshop");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);
$appointmentId = $data['appointment_id'];

if (empty($appointmentId)) {
    echo json_encode(["error" => "Appointment ID is required"]);
    exit;
}

// Delete the appointment
$conn->begin_transaction();
try {
    // Fetch mechanic_id to decrement current_clients
    $sql = "SELECT mechanic_id FROM appointments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointmentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $mechanicId = $result->fetch_assoc()['mechanic_id'];

    // Delete the appointment
    $sql = "DELETE FROM appointments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointmentId);
    $stmt->execute();

    // Decrement the mechanic's current_clients
    $sql = "UPDATE mechanics SET current_clients = current_clients - 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $mechanicId);
    $stmt->execute();

    $conn->commit();
    echo json_encode(["success" => "Appointment deleted successfully"]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["error" => "Failed to delete appointment: " . $e->getMessage()]);
}

$conn->close();
?>
