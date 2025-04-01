<?php
session_start();
include 'connection.php';

if (!$conn) {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'message' => "Database connection failed: " . mysqli_connect_error(),
    ];
    header("Location: ../login.php");
    exit(0);
}

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $verify_query = "SELECT verification_token, verify_status FROM patient WHERE verification_token='$token' LIMIT 1";
    $verify_query_run = mysqli_query($conn, $verify_query);

    if (mysqli_num_rows($verify_query_run) > 0) {
        $row = mysqli_fetch_array($verify_query_run);
        if ($row['verify_status'] == "0") {
            $clicked_token = $row['verification_token'];
            $update_query = "UPDATE patient SET verify_status= '1', email_verified_at=NOW() WHERE verification_token='$clicked_token' LIMIT 1";
            $update_query_run = mysqli_query($conn, $update_query);

            if (!$update_query_run) {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'message' => "Failed to update verification status, try again. Database error: " . mysqli_error($conn),
                ];
                header("Location: ../login.php");
                exit(0);
            }

            if ($update_query_run) {
                $_SESSION['alert'] = [
                    'type' => 'success',
                    'message' => "Your email has been successfully verified! You can now log in with your account.",
                ];
                header("Location: ../patient/index.php");
                exit();
            } else {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'message' => "Failed to update verification status, try again.",
                ];
                header("Location: ../login.php");
                exit(0);
            }
        } else {
            $_SESSION['alert'] = [
                'type' => 'info',
                'message' => "This email has already been verified.",
            ];
            header("Location: ../login.php");
            exit(0);
        }
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => "Invalid verification token.",
        ];
        header("Location: ../login.php");
        exit(0);
    }
} else {
    $_SESSION['alert'] = [
        'type' => 'danger',
        'message' => "Invalid verification link.",
    ];
    header("Location: ../login.php");
    exit(0);
}
?>