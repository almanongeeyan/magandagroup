<?php
session_start();
require '../tresspass/connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_auth']) || $_SESSION['admin_auth'] !== true) {
    http_response_code(403); // Forbidden
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

// Check if user_id is provided via POST
if (!isset($_POST['user_id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'message' => 'User ID not provided.']);
    exit();
}

$userId = $_POST['user_id'];

// Prepare and execute the DELETE statement
$stmt = $conn->prepare("DELETE FROM appointments WHERE user_id = ?"); // corrected the table name to 'appointments'
$stmt->bind_param("i", $userId);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Appointment deleted successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Appointment not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>