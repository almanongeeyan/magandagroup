<?php
session_start();
include 'connection.php';

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
 
    //Load Composer's autoloader
    require 'vendor/autoload.php';
 
    if (isset($_POST["register"]))
    {
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $age = $_POST["age"];
        $gender = $_POST["gender"];
        $cnumber = $_POST["cnumber"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        $verification_code = $_POST["verification_code"];


        //Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
 
        try {
            //Enable verbose debug output
            $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;
 
            //Send using SMTP
            $mail->isSMTP();
 
            //Set the SMTP server to send through
            $mail->Host = 'smtp.gmail.com';

            //Enable SMTP authentication
            $mail->SMTPAuth = true;

            //SMTP username
            $mail->Username = 'almanongeeyan@gmail.com'; // Your Gmail address

            //SMTP password (use the App Password here)
            $mail->Password = 'tanjndbjbiftykhb'; // Your generated App Password

            //Enable TLS encryption;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('almanongeeyan@gmail.com', 'your_website_name');
 
            //Add a recipient
            $mail->addAddress($email, $name);
 
            //Set email format to HTML
            $mail->isHTML(true);
 
            $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
 
            $mail->Subject = 'Email verification';
            $mail->Body    = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';
 
            $mail->send();
            // echo 'Message has been sent';
 
            $encrypted_password = password_hash($password, PASSWORD_DEFAULT);
 
            // connect with database
            $conn = mysqli_connect("localhost:8889", "root", "root", "abc");
 
            // insert in users table
            $sql = "INSERT INTO patient(fname, lname, age, gender, cnumber, password, email, verification_code, email_verified_at) 
        VALUES ('$fname', '$lname', '$age', '$gender', '$cnumber', '$encrypted_password', '$email', '$verification_code', NULL)";
mysqli_query($conn, $sql);
 
            header("Location: email-verification.php?email=" . $email);
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
?>