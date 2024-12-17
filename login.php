<?php
session_start(); // Start the session

$conn = new mysqli("localhost", "root", "", "workshop");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

// Validate user credentials
$sql = "SELECT id, role, password FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verify password
    if (hash('sha256', $password) === $user['password']) {
        // Store user details in the session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] === 'admin') {
            header("Location: admin_panel.php");
        } else {
            header("Location: user_panel.php");
        }
        exit;
    }
}

echo "Invalid username or password.";
?>
