<?
$page_title = "Login Page";
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if (isset($page_title)) {
            echo "$page_title";
        }
        ?>
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="css/stylee.css">
    <style>
    body {
        font-family: sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
    }

    .back-button {
        position: absolute;
        top: 20px;
        left: 20px;
    }

    .back-button a {
        text-decoration: none;
        color: #333;
        padding: 8px 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
        transition: background-color 0.3s ease;
    }

    .back-button a:hover {
        background-color: #eee;
    }

    .login-container {
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 400px;
        /* Fixed width */
        max-width: 90%;
        /* Ensure responsiveness on smaller screens */
        text-align: center;
        position: relative;
        /* For positioning the alert */
    }

    .login-container h2 {
        margin-bottom: 20px;
        color: #333;
    }

    .login-container label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        text-align: left;
    }

    .login-container input[type="email"],
    .login-container input[type="password"] {
        width: calc(100% - 22px);
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 16px;
    }

    .login-container .btn-success {
        background-color: #28a745;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
        width: 100%;
    }

    .login-container .btn-success:hover {
        background-color: #218838;
    }

    .login-container .register-link {
        margin-top: 20px;
        font-size: 14px;
        color: #777;
    }

    .login-container .register-link a {
        color: #007bff;
        text-decoration: none;
    }

    .login-container .register-link a:hover {
        text-decoration: underline;
    }

    .alert {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        text-align: left;
    }

    .alert.alert-success {
        background-color: #d4edda;
        color: #155724;
        border-color: #c3e6cb;
    }

    .alert.alert-warning {
        background-color: #fff3cd;
        color: #85640c;
        border-color: #ffeeba;
    }

    .alert-dismissible {
        position: relative;
        padding-right: 30px;
    }

    .alert-dismissible .close {
        position: absolute;
        top: 5px;
        right: 5px;
        color: inherit;
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        font-size: 1.2em;
        opacity: 0.5;
    }

    .alert-dismissible .close:hover {
        opacity: 0.8;
    }
    </style>
</head>

<body>

    <div class="back-button">
        <a href="index.php"><i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>

    <div class="login-container">
        <h2><i class="fa-solid fa-sign-in-alt"></i> Login</h2>

        <?php
        session_start(); // Ensure session_start() is at the very beginning of your page

        if (isset($_SESSION['alert'])) {
            $alert_type = $_SESSION['alert']['type'];
            $alert_message = $_SESSION['alert']['message'];
            $alert_class = 'alert-' . $alert_type;

            echo '<div class="alert alert-dismissible fade show ' . $alert_class . '" role="alert">
                    ' . $alert_message . '
                  </div>';

            unset($_SESSION['alert']); // Clear the alert after displaying it
        }
        ?>

        <form id="loginForm" action="process.php" method="POST">
            <label><i class="fa-solid fa-user"></i> Username</label>
            <input type="email" placeholder="Enter your email" name="email" maxlength="50" required>

            <label><i class="fa-solid fa-lock"></i> Password</label>
            <input type="password" placeholder="Enter your password" name="password" minlength="8" required>

            <button type="submit" class="btn btn-success" name="login">Login</button>

            <div class="register-link">
                <p>Don't have an account? <a href="registration.php">Sign up here</a></p>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const closeButtons = document.querySelectorAll('.alert .close');
        closeButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const alertDiv = this.parentNode;
                alertDiv.classList.add('fade');
                setTimeout(function() {
                    alertDiv.style.display = 'none';
                }, 300); // Adjust timeout for fade effect
            });
        });
    });
    </script>

</body>

</html>