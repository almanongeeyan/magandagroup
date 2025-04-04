<?php
session_start();
if (!isset($_SESSION['admin_auth']) || $_SESSION['admin_auth'] !== true) {
    header("Location: ../tresspass/notresspass.php");
    exit();
}

require '../tresspass/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && is_numeric($_POST['id'])) {
    $vaccination_id = $_POST['id'];

    // Collect data, prioritizing non-disabled fields
    $D0_date = isset($_POST['D0_date']) && $_POST['D0_date'] !== '' ? htmlspecialchars($_POST['D0_date']) : (isset($_POST['D0_date_hidden']) ? htmlspecialchars($_POST['D0_date_hidden']) : null);
    $D0_site = isset($_POST['D0_site']) && $_POST['D0_site'] !== '' ? htmlspecialchars($_POST['D0_site']) : (isset($_POST['D0_site_hidden']) ? htmlspecialchars($_POST['D0_site_hidden']) : null);
    $D0_given = isset($_POST['D0_given']) && $_POST['D0_given'] !== '' ? htmlspecialchars($_POST['D0_given']) : (isset($_POST['D0_given_hidden']) ? htmlspecialchars($_POST['D0_given_hidden']) : null);

    $D3_date = isset($_POST['D3_date']) && $_POST['D3_date'] !== '' ? htmlspecialchars($_POST['D3_date']) : (isset($_POST['D3_date_hidden']) ? htmlspecialchars($_POST['D3_date_hidden']) : null);
    $D3_site = isset($_POST['D3_site']) && $_POST['D3_site'] !== '' ? htmlspecialchars($_POST['D3_site']) : (isset($_POST['D3_site_hidden']) ? htmlspecialchars($_POST['D3_site_hidden']) : null);
    $D3_given = isset($_POST['D3_given']) && $_POST['D3_given'] !== '' ? htmlspecialchars($_POST['D3_given']) : (isset($_POST['D3_given_hidden']) ? htmlspecialchars($_POST['D3_given_hidden']) : null);

    $D7_date = isset($_POST['D7_date']) && $_POST['D7_date'] !== '' ? htmlspecialchars($_POST['D7_date']) : (isset($_POST['D7_date_hidden']) ? htmlspecialchars($_POST['D7_date_hidden']) : null);
    $D7_site = isset($_POST['D7_site']) && $_POST['D7_site'] !== '' ? htmlspecialchars($_POST['D7_site']) : (isset($_POST['D7_site_hidden']) ? htmlspecialchars($_POST['D7_site_hidden']) : null);
    $D7_given = isset($_POST['D7_given']) && $_POST['D7_given'] !== '' ? htmlspecialchars($_POST['D7_given']) : (isset($_POST['D7_given_hidden']) ? htmlspecialchars($_POST['D7_given_hidden']) : null);

    $D14_date = isset($_POST['D14_date']) && $_POST['D14_date'] !== '' ? htmlspecialchars($_POST['D14_date']) : (isset($_POST['D14_date_hidden']) ? htmlspecialchars($_POST['D14_date_hidden']) : null);
    $D14_site = isset($_POST['D14_site']) && $_POST['D14_site'] !== '' ? htmlspecialchars($_POST['D14_site']) : (isset($_POST['D14_site_hidden']) ? htmlspecialchars($_POST['D14_site_hidden']) : null);
    $D14_given = isset($_POST['D14_given']) && $_POST['D14_given'] !== '' ? htmlspecialchars($_POST['D14_given']) : (isset($_POST['D14_given_hidden']) ? htmlspecialchars($_POST['D14_given_hidden']) : null);

    $D28_date = isset($_POST['D28_date']) && $_POST['D28_date'] !== '' ? htmlspecialchars($_POST['D28_date']) : (isset($_POST['D28_date_hidden']) ? htmlspecialchars($_POST['D28_date_hidden']) : null);
    $D28_site = isset($_POST['D28_site']) && $_POST['D28_site'] !== '' ? htmlspecialchars($_POST['D28_site']) : (isset($_POST['D28_site_hidden']) ? htmlspecialchars($_POST['D28_site_hidden']) : null);
    $D28_given = isset($_POST['D28_given']) && $_POST['D28_given'] !== '' ? htmlspecialchars($_POST['D28_given']) : (isset($_POST['D28_given_hidden']) ? htmlspecialchars($_POST['D28_given_hidden']) : null);

    // Prepare and execute the update query
    $update_sql = "UPDATE vaccination_data SET
                        D0_date = ?,
                        D0_site = ?,
                        D0_given = ?,
                        D3_date = ?,
                        D3_site = ?,
                        D3_given = ?,
                        D7_date = ?,
                        D7_site = ?,
                        D7_given = ?,
                        D14_date = ?,
                        D14_site = ?,
                        D14_given = ?,
                        D28_date = ?,
                        D28_site = ?,
                        D28_given = ?
                    WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);

    $update_stmt->bind_param("sssssssssssssssi",
                        $D0_date, $D0_site, $D0_given, $D3_date, $D3_site, $D3_given,
                        $D7_date, $D7_site, $D7_given, $D14_date, $D14_site, $D14_given,
                        $D28_date, $D28_site, $D28_given, $vaccination_id);

    if ($update_stmt->execute()) {
        $_SESSION['update_success'] = "Vaccination schedule updated successfully!";
    } else {
        $_SESSION['update_error'] = "Error updating vaccination schedule: " . $update_stmt->error;
    }
    $update_stmt->close();

    // Redirect to record.php
    header("Location: record.php");
    exit();

} else {
    // If the request method is not POST or ID is missing/invalid
    header("Location: record.php");
    exit();
}

$conn->close();
?>