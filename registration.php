<?
$page_title = "Registration Page";
include 'connection.php';
include 'process.php';
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

    .registration-container {
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 450px;
        /* Slightly wider for more fields */
        max-width: 90%;
        text-align: center;
        position: relative;
    }

    .registration-container h2 {
        margin-bottom: 20px;
        color: #333;
    }

    .registration-container label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        text-align: left;
    }

    .registration-container input[type="text"],
    .registration-container input[type="number"],
    .registration-container input[type="tel"],
    .registration-container input[type="password"],
    .registration-container input[type="email"],
    .registration-container select {
        width: calc(100% - 22px);
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 16px;
    }

    .registration-container select {
        appearance: none;
        background-image: url('data:image/svg+xml;charset=UTF-8,<svg fill="%23343a40" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/></svg>');
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 12px;
    }

    .registration-container .tiny-text {
        display: block;
        margin-top: -10px;
        margin-bottom: 10px;
        font-size: 0.8em;
        color: #777;
        text-align: left;
    }

    .registration-container .switch-label {
        display: block;
        margin-bottom: 10px;
        color: #555;
        text-align: left;
    }

    .registration-container .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .registration-container .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .registration-container .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .registration-container .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    .registration-container input:checked+.slider {
        background-color: #2196F3;
    }

    .registration-container input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    .registration-container input:checked+.slider:before {
        transform: translateX(26px);
    }

    .registration-container .btn-success {
        background-color: #28a745;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
        width: 100%;
        margin-top: 20px;
    }

    .registration-container .btn-success:hover {
        background-color: #218838;
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
        <a href="login.php"><i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>

    <div class="registration-container">
        <h2><i class="fa-solid fa-user-plus"></i> Register</h2>

        <?php

        if (isset($_SESSION['alert'])) {
            $alert_type = $_SESSION['alert']['type'];
            $alert_message = $_SESSION['alert']['message'];
            $alert_class = 'alert-' . $alert_type;

            echo '<div class="alert alert-dismissible fade show ' . $alert_class . '" role="alert">
                    ' . $alert_message . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
                  </div>';

            unset($_SESSION['alert']); // Clear the alert after displaying it
        }
        ?>

        <form id="registrationForm" action="process.php" method="POST">
            <label><i class="fa-solid fa-user"></i> First Name</label>
            <input type="text" placeholder="Enter your first name" name="fname" maxlength="20" autocomplete="off"
                required>

            <label><i class="fa-solid fa-user"></i> Last Name</label>
            <input type="text" placeholder="Enter your last name" name="lname" maxlength="20" autocomplete="off"
                required>

            <label><i class="fa-solid fa-calendar"></i> Age</label>
            <input type="number" placeholder="Enter your age" name="age" id="age" min="7" max="99" autocomplete="off"
                required>

            <label><i class="fa-solid fa-venus-mars"></i> Gender</label>
            <select name="gender" required>
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <label><i class="fa-solid fa-phone"></i> Contact Number</label>
            <input type="tel" placeholder="Enter your contact number" name="cnumber" minlength="11" autocomplete="off"
                maxlength="11" required>

            <label><i class="fa-solid fa-lock"></i> Password</label>
            <input type="password" placeholder="Enter your password" name="password" minlength="8" autocomplete="off"
                required>

            <label><i class="fa-solid fa-envelope"></i> Email</label>
            <input type="email" placeholder="Enter your email" name="email" id="email" maxlength="50" autocomplete="off"
                required>
            <span class="tiny-text">This will serve as your username</span>

            <label class="switch-label">Emergency Injection</label>
            <label class="switch">
                <input type="checkbox" id="emergencyCheckbox" onclick="toggleVerification()">
                <span class="slider"></span>
            </label>

            <button type="submit" name="register" class="btn btn-success">Submit</button>
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

    // You would need to define this function if it's crucial for your registration process
    function toggleVerification() {
        // Add your logic here to handle the emergency checkbox
        console.log("Emergency checkbox toggled");
    }
    </script>

</body>

</html>