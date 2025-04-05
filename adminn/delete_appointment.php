<?php
session_start();
if (!isset($_SESSION['admin_auth']) || $_SESSION['admin_auth'] !== true) {
    header("Location: ../tresspass/notresspass.php");
    exit();
}

require '../tresspass/connection.php';

if (isset($_POST['user_id'])) {
    $user_id_to_delete = $_POST['user_id'];

    // Sanitize the input to prevent SQL injection
    $user_id_to_delete = mysqli_real_escape_string($conn, $user_id_to_delete);

    // Prepare the SQL query to delete the appointment for the given user ID
    $sql = "DELETE FROM appointment WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $user_id_to_delete);
        if ($stmt->execute()) {
            // Deletion successful
            $_SESSION['delete_message'] = "Appointment for User ID: " . $user_id_to_delete . " has been deleted successfully.";
            $_SESSION['message_type'] = 'success';
        } else {
            // Error during deletion
            $_SESSION['delete_message'] = "Error deleting appointment: " . $stmt->error;
            $_SESSION['message_type'] = 'danger';
        }
        $stmt->close();
    } else {
        // Error preparing the statement
        $_SESSION['delete_message'] = "Error preparing SQL statement: " . $conn->error;
        $_SESSION['message_type'] = 'danger';
    }
} else {
    // User ID not provided
    $_SESSION['delete_message'] = "Invalid request: User ID not provided.";
    $_SESSION['message_type'] = 'danger';
}

// Redirect back to the appointments page
header("Location: appointment.php");
exit();
?>