<?php
$conn = new mysqli("localhost", "root", "", "workshop");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT 
            appointments.id AS appointment_id,
            clients.name AS client_name,
            clients.phone,
            clients.car_license,
            appointments.date,
            mechanics.name AS mechanic_name
        FROM appointments
        JOIN clients ON appointments.client_id = clients.id
        JOIN mechanics ON appointments.mechanic_id = mechanics.id";

$result = $conn->query($sql);

$appointments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

echo json_encode($appointments);
$conn->close();
?>
