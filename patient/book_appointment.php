<?php
session_start();
require '../tresspass/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book'])) {
    $user_id = $_SESSION['auth_user']['user_id'];
    $appointment_date = date("Y-m-d");

    // Check if user already has an appointment
    $stmt = $conn->prepare("SELECT * FROM appointment WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "You already have an appointment."]);
        exit;
    }

    // Get next appointment number
    $result = $conn->query("SELECT COUNT(appointment_id) + 1 AS next_appointment_num FROM appointment");
    $appointment_num = ($result->num_rows > 0) ? $result->fetch_assoc()['next_appointment_num'] : 1;

    // Insert new appointment
    $stmt = $conn->prepare("INSERT INTO appointment (user_id, appointment_num, appointment_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $appointment_num, $appointment_date);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error: " . $conn->error]);
    }
    $stmt->close();
}
?>