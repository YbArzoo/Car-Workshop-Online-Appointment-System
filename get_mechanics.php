<?php
$conn = new mysqli("localhost", "root", "", "workshop");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, max_clients, current_clients FROM mechanics";
$result = $conn->query($sql);

$mechanics = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mechanics[] = $row;
    }
}

echo json_encode($mechanics);
$conn->close();
?>
