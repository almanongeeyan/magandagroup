<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

function sendemail_verify($fname, $email, $verification_token): bool
{
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Disable verbose debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'almanongeeyan@gmail.com';
        $mail->Password = 'tanjndbjbiftykhb';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('almanongeeyan@gmail.com', $fname); // Use your Gmail address as sender
        $mail->addAddress($email);                                     //Add a recipient

        //Content
        $mail->isHTML(true);                                        //Set email format to HTML
        $mail->Subject = 'Email Verification mo beh, verify mo na yan!';

        $email_template = "
        <h2> You have registered with ABC Malaria <h2>
        <h5> Verify your email address to Login with the given link belowwwwww, kapagod<h5>
        <a href='http://localhost/animall/magandagroup/verify-email.php?token=$verification_token'> Click mo 'ko beh </a>
        ";

        $mail->Body = $email_template; // Correct assignment
        $mail->AltBody = strip_tags($email_template); // Plain text version for non-HTML clients

        $mail->send();
        return true; // Indicate success
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false; // Indicate failure
    }
}

if (isset($_POST["register"])) {
    $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
    $lname = mysqli_real_escape_string($conn, $_POST["lname"]);
    $age = mysqli_real_escape_string($conn, $_POST["age"]);
    $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
    $cnumber = mysqli_real_escape_string($conn, $_POST["cnumber"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $verification_token = md5(rand());

    // Check if the database connection is established
    if ($conn) {
        // Check if email already exists BEFORE sending email
        $check_email_query = "SELECT email FROM patient WHERE email = '$email' LIMIT 1";
        $check_email_query_run = mysqli_query($conn, $check_email_query);

        if ($check_email_query_run) {
            if (mysqli_num_rows($check_email_query_run) > 0) {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'message' => "Email already exists",
                ];
                header("location: registration.php");
                exit(); // Stop further execution
            } else {
                $email_sent = sendemail_verify($fname, $email, $verification_token);

                if ($email_sent) {
                    $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
                    $query = "INSERT INTO patient(fname, lname, age, gender, cnumber, password, email, verification_token, email_verified_at, verify_status)
                                 VALUES ('$fname', '$lname', '$age', '$gender', '$cnumber', '$encrypted_password', '$email', '$verification_token', NULL, '0')";
                    $query_run = mysqli_query($conn, $query);

                    if ($query_run) {
                        $_SESSION['alert'] = [
                            'type' => 'success',
                            'message' => "Registration Successful! Please verify your Email Address to Login.",
                        ];
                        header("location: login.php");
                    } else {
                        $_SESSION['alert'] = [
                            'type' => 'danger',
                            'message' => "Registration Failed, Try again",
                        ];
                        header("location: registration.php");
                    }
                    exit(); // Stop further execution
                } else {
                    $_SESSION['alert'] = [
                        'type' => 'danger',
                        'message' => "Failed to send verification email.",
                    ];
                    header("location: registration.php");
                    exit(); // Stop further execution
                }
            }
            mysqli_free_result($check_email_query_run); // Free the result set
        } else {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'message' => "Database error during email check: " . mysqli_error($conn),
            ];
            header("location: registration.php");
            exit();
        }
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => "Database connection error.",
        ];
        header("location: registration.php");
        exit();
    }
}

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($email) || empty($password)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => "Please enter both email and password.",
        ];
        header("Location: login.php");
        exit();
    }

    $query = "SELECT fname, password, verify_status FROM patient WHERE email = '$email' LIMIT 1";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $row = mysqli_fetch_assoc($query_run);
        if ($row['verify_status'] == '1') {
            // Email is verified, now check password
            if (password_verify($password, $row['password'])) {
                // Password is correct, log the user in
                $_SESSION['auth'] = true;
                $_SESSION['auth_user'] = [
                    'user_fname' => $row['fname'],
                    'user_email' => $email,
                ];
                $_SESSION['alert'] = [
                    'type' => 'success',
                    'message' => "Logged in successfully!",
                ];
                header("Location: patient/index.php"); // Redirect to your homepage
                exit();
            } else {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'message' => "Invalid password.",
                ];
                header("Location: login.php");
                exit();
            }
        } else {
            $_SESSION['alert'] = [
                'type' => 'warning',
                'message' => "Your email address is not yet verified. Please check your inbox and click the verification link.",
            ];
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => "Invalid email address.",
        ];
        header("Location: login.php");
        exit();
    }
}

?>