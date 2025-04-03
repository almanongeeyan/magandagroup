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
        $mail->setFrom('almanongeeyan@gmail.com', 'ANIMAL BITE CLINIC'); // Use your Gmail address as sender
        $mail->addAddress($email);                                        //Add a recipient

        //Content
        $mail->isHTML(true);                                           //Set email format to HTML
        $mail->Subject = 'Email Verification mo beh, i-verify mo na yan!';

        $email_template = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Welcome to ABC Malaria - Email Verification</title>
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h2 {
            color: #007bff;
        }
        h5 {
            color: #fff;
        }
        .verification-link {
            display: inline-block;
            padding: 10px 20px;
            background-color:rgb(170, 230, 184);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
        .greeting {
            margin-bottom: 15px;
        }
        .regards {
            margin-top: 20px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class='container'>
        <h2 class='greeting'>Welcome to ABC Malaria!</h2>
        <h5>Thank you for registering with us. To complete your registration, please verify your email address by clicking the link below:</h5>
        <p><a href='http://localhost/magandagroup/tresspass/verify-email.php?token=$verification_token' class='verification-link'>Verify Your Email Address</a></p>
        <p>This verification step helps us ensure the security of your account.</p>
        <h5 class='regards'>Sincerely,<br>The ABC Malaria Team</h5>
    </div>
</body>
</html>
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
                header("location: ../login.php");
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
                        header("location: ../login.php");
                    } else {
                        $_SESSION['alert'] = [
                            'type' => 'danger',
                            'message' => "Registration Failed, Try again",
                        ];
                        header("location: ../login.php");
                    }
                    exit(); // Stop further execution
                } else {
                    $_SESSION['alert'] = [
                        'type' => 'danger',
                        'message' => "Failed to send verification email.",
                    ];
                    header("location: ../login.php");
                    exit(); // Stop further execution
                }
            }
            mysqli_free_result($check_email_query_run); // Free the result set
        } else {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'message' => "Database error during email check: " . mysqli_error($conn),
            ];
            header("location: ../login.php");
            exit();
        }
    } else {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => "Database connection error.",
        ];
        header("location: ../login.php");
        exit();
    }
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['email']); // Use 'email' field for both
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($username) || empty($password)) {
        $_SESSION['alert'] = [
            'type' => 'danger',
            'message' => "Please enter both username and password.", // More general message
        ];
        header("Location: ../login.php");
        exit();
    }

    // Check for patient login first
    $patient_query = "SELECT user_id, fname, lname, password, verify_status FROM patient WHERE email = '$username' LIMIT 1";
    $patient_query_run = mysqli_query($conn, $patient_query);

    if (mysqli_num_rows($patient_query_run) > 0) {
        $row = mysqli_fetch_assoc($patient_query_run);
        if ($row['verify_status'] == '1') {
            // Email is verified, now check password
            if (password_verify($password, $row['password'])) {
                // Password is correct, log the patient in
                $_SESSION['auth'] = true;
                $_SESSION['auth_user'] = [
                    'user_id' => $row['user_id'],
                    'fname' => $row['fname'],
                    'email' => $username, // Store as email even if it was username
                ];
                $_SESSION['alert'] = [
                    'type' => 'success',
                    'message' => "Logged in successfully!",
                ];
                header("Location: ../patient/index.php"); // Redirect to patient dashboard
                exit();
            } else {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'message' => "Invalid password.",
                ];
                header("Location: ../login.php");
                exit();
            }
        } else {
            $_SESSION['alert'] = [
                'type' => 'warning',
                'message' => "Your email address is not yet verified. Please check your inbox and click the verification link.",
            ];
            header("Location: ../login.php");
            exit();
        }
    } else {
        // Patient not found, check for admin login
        $admin_query = "SELECT username, password FROM admin WHERE username = '$username' LIMIT 1";
        $admin_query_run = mysqli_query($conn, $admin_query);

        if (mysqli_num_rows($admin_query_run) > 0) {
            $row = mysqli_fetch_assoc($admin_query_run);
            // Password check for admin (INSECURE - FOR TESTING ONLY)
            if ($password === $row['password']) {
                // Password is correct, log the admin in
                $_SESSION['admin_auth'] = true; // Set admin authentication session
                $_SESSION['admin_user'] = [
                    'username' => $row['username'],
                ];
                $_SESSION['alert'] = [
                    'type' => 'success',
                    'message' => "Admin logged in successfully!",
                ];
                header("Location: ../adminn/index.php"); // Redirect to admin dashboard
                exit();
            } else {
                $_SESSION['alert'] = [
                    'type' => 'danger',
                    'message' => "Invalid admin password.",
                ];
                header("Location: ../login.php");
                exit();
            }
        } else {
            $_SESSION['alert'] = [
                'type' => 'danger',
                'message' => "Invalid username.",
            ];
            header("Location: ../login.php");
            exit();
        }
    }
}
?>