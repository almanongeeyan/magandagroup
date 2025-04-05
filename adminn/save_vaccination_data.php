<?php
session_start();
if (!isset($_SESSION['admin_auth']) || $_SESSION['admin_auth'] !== true) {
    header("Location: ../tresspass/notresspass.php");
    exit();
}

require '../tresspass/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = isset($_POST['user_id']) ? $_POST['user_id'] : null;
    $dateExposure = isset($_POST['date_exposure']) ? $_POST['date_exposure'] : null;
    $dateTreatment = isset($_POST['date_treatment']) ? $_POST['date_treatment'] : null;
    $bittenBy = isset($_POST['bitten_by']) ? $_POST['bitten_by'] : null; // Added bitten_by
    $vaccine = isset($_POST['vaccine']) ? $_POST['vaccine'] : null; // Removed implode as it is now one value
    $brandName = isset($_POST['brand_name']) ? $_POST['brand_name'] : null;
    $route = isset($_POST['route']) ? $_POST['route'] : null; // Removed implode
    $D0Date = isset($_POST['D0_date']) ? $_POST['D0_date'] : null;
    $D0Site = isset($_POST['D0_site']) ? $_POST['D0_site'] : null;
    $D0Given = isset($_POST['D0_given']) ? $_POST['D0_given'] : null;
    $D3Date = isset($_POST['D3_date']) ? $_POST['D3_date'] : null;
    $D3Site = isset($_POST['D3_site']) ? $_POST['D3_site'] : null;
    $D3Given = isset($_POST['D3_given']) ? $_POST['D3_given'] : null;
    $D7Date = isset($_POST['D7_date']) ? $_POST['D7_date'] : null;
    $D7Site = isset($_POST['D7_site']) ? $_POST['D7_site'] : null;
    $D7Given = isset($_POST['D7_given']) ? $_POST['D7_given'] : null;
    $D14Date = isset($_POST['D14_date']) ? $_POST['D14_date'] : null;
    $D14Site = isset($_POST['D14_site']) ? $_POST['D14_site'] : null;
    $D14Given = isset($_POST['D14_given']) ? $_POST['D14_given'] : null;
    $D28Date = isset($_POST['D28_date']) ? $_POST['D28_date'] : null;
    $D28Site = isset($_POST['D28_site']) ? $_POST['D28_site'] : null;
    $D28Given = isset($_POST['D28_given']) ? $_POST['D28_given'] : null;

    $sql = "INSERT INTO vaccination_data (user_id, date_exposure, date_treatment, bitten_by, vaccine, brand_name, route, D0_date, D0_site, D0_given, D3_date, D3_site, D3_given, D7_date, D7_site, D7_given, D14_date, D14_site, D14_given, D28_date, D28_site, D28_given) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("isssssssssssssssssssss", $userId, $dateExposure, $dateTreatment, $bittenBy, $vaccine, $brandName, $route, $D0Date, $D0Site, $D0Given, $D3Date, $D3Site, $D3Given, $D7Date, $D7Site, $D7Given, $D14Date, $D14Site, $D14Given, $D28Date, $D28Site, $D28Given);

        if ($stmt->execute()) {
            // Data insertion successful, now delete from appointment table
            $deleteSql = "DELETE FROM appointment WHERE user_id = ?";
            $deleteStmt = $conn->prepare($deleteSql);

            if ($deleteStmt) {
                $deleteStmt->bind_param("i", $userId);
                if ($deleteStmt->execute()) {
                    header("Location: appointment.php?success=Vaccination data saved and appointment removed successfully.");
                    exit();
                } else {
                    error_log("Error deleting appointment: " . $deleteStmt->error);
                    echo "Error deleting appointment: " . $deleteStmt->error;
                }
                $deleteStmt->close();
            } else {
                error_log("Error preparing delete statement: " . $conn->error);
                echo "Error preparing delete statement: " . $conn->error;
            }
        } else {
            error_log("Error executing statement: " . $stmt->error);
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        error_log("Error preparing statement: " . $conn->error);
        echo "Error: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>