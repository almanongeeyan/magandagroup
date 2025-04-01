<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="patient.css">
    <title>Dashboard</title>
    <style>
    .dashbord-tables {
        animation: transitionIn-Y-over 0.5s;
    }

    .filter-container {
        animation: transitionIn-Y-bottom 0.5s;
    }

    .sub-table,
    .anime {
        animation: transitionIn-Y-bottom 0.5s;
    }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQmQa7GBRcz8lPvxhNF9glnAHWNDyPd1sXeRcLMEQbqYAmDv9ky9AzQoOVwoflJcEuOZimo6YHvsIA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<?php

session_start();
require '../connection.php'; 


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



// Check if user is logged in
if (isset($_SESSION['auth']) && $_SESSION['auth'] == true) {
    // User is logged in
    $fname = $_SESSION['auth_user']['user_fname'];
    $email = $_SESSION['auth_user']['user_email'];

    // Fetch lname from the database
    $query = "SELECT lname FROM patient WHERE email = ?";
    $stmt = $conn->prepare($query); 
    if ($stmt) {
        $stmt->bind_param("s", $email); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $lname = $row['lname'];
        } else {
            echo "<p>Error fetching last name or no user found.</p>";
        }
        $stmt->close();
    } else {
        echo "<p>Error preparing statement for last name: " . $conn->error . "</p>";
    }
} else {
    header("Location: ../tresspass/notresspass.php");
    exit(0);
}
?>

<body>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:1px; text-align: left;">
                                    <img src="../images/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo htmlspecialchars($fname . ' ' . $lname); ?></p>
                                    <p class="profile-subtitle"><?php echo htmlspecialchars($email); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php"><input type="button" value="Log out"
                                            class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-home">
                        <a href="index.php" class="non-style-link-menu">
                            <div>
                                <i class="fas fa-home"></i>
                                <p class="menu-text">Home</p>
                            </div>
                        </a>
                    </td>
                </tr>

                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                        <a href="appointment.php" class="non-style-link-menu non-style-link-menu-active">
                            <div>
                                <i class="far fa-calendar-check"></i>
                                <p class="menu-text">Make an Appointment</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="record.php" class="non-style-link-menu">
                            <div>
                                <i class="fas fa-file-medical-alt"></i>
                                <p class="menu-text">My Record</p>
                            </div>
                        </a>
                    </td>
                </tr>
            </table>
        </div>

        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <td colspan="1" class="nav-bar">
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;margin-left:20px;">Appointment</p>
                </td>
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;">
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <table width="100%" class="sub-table scrolldown" border="0"
                                    style="padding: 50px;border:none">
                                    <tbody>
                                        <tr>
                                            <td style="width: 50%;" rowspan="2">
                                                <div class="dashboard-items search-items">
                                                    <div style="width:100%">
                                                        <div class="h1-search" style="font-size:25px;">
                                                            Session Details
                                                        </div><br><br>
                                                        <div class="h3-search" style="font-size:18px;line-height:30px">
                                                            Clinician's name: &nbsp;&nbsp;<b>Dr. Jed Elrick
                                                                Castilo</b><br>
                                                        </div>
                                                        <div class="h3-search" style="font-size:18px;">
                                                        </div><br>
                                                        <div class="h3-search" style="font-size:18px;">
                                                            Session Title: Rabies Injection<br>
                                                            Session Scheduled Date: <span id="session-date"></span><br>
                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width: 25%;">
                                                <div class="dashboard-items search-items">
                                                    <div style="width:100%;padding-top: 15px;padding-bottom: 15px;">
                                                        <div class="h1-search"
                                                            style="font-size:20px;line-height: 35px;margin-left:8px;text-align:center;">
                                                            Your Appointment Number
                                                        </div>
                                                        <center>
                                                            <div class=" dashboard-icons"
                                                                style="margin-left: 0px;width:90%;font-size:70px;font-weight:800;text-align:center;color:var(--btnnictext);background-color: var(--btnice)">
                                                                1</div>
                                                        </center>
                                                    </div><br>
                                                    <br>
                                                    <br>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: center;">
                                                <button type="submit" class="login-btn btn-primary btn btn-book"
                                                    name="book"
                                                    style="padding: 15px 30px; font-size: 18px; border-radius: 5px; cursor: pointer;">
                                                    Book now
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </center>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sessionDateElement = document.getElementById('session-date');
        const now = new Date();
        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        sessionDateElement.textContent = now.toLocaleDateString(undefined, options);
    });

    // Basic script to toggle active class on menu items (you can enhance this)
    document.addEventListener('DOMContentLoaded', function() {
        const menuButtons = document.querySelectorAll('.menu-btn');
        menuButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all menu buttons
                menuButtons.forEach(btn => {
                    btn.classList.remove('menu-active');
                    btn.classList.remove(btn.classList[1] +
                        '-active'); // Remove icon active class
                });
                // Add active class to the clicked button
                this.classList.add('menu-active');
                this.classList.add(this.classList[1] + '-active'); // Add icon active class
            });
        });
    });
    </script>
</body>

</html>