<?php
require '../tresspass/connection.php';

$userId = $_GET['user_id'];

$patientSql = "SELECT fname, lname, age, gender, cnumber FROM patient WHERE user_id = ?";
$stmt = $conn->prepare($patientSql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$patientResult = $stmt->get_result()->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($patientResult);
?>