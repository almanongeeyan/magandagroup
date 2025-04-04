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

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .btn-disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQmQa7GBRcz8lPvxhNF9glnAHWNDyPd1sXeRcLMEQbqYAmDv9ky9AzQoOVwoflJcEuOZimo6YHvsIA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<?php

session_start();
require '../tresspass/connection.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$booking_message = null;
$booking_type = null; // 'success' or 'danger'
$appointment_count = 0;
$is_booked = false;

// Check if user is logged in
if (isset($_SESSION['auth']) && $_SESSION['auth'] == true) {
    // User is logged in
    $fname = $_SESSION['auth_user']['fname'];
    $email = $_SESSION['auth_user']['email'];
    $user_id = $_SESSION['auth_user']['user_id'] ?? null; // Get user_id from session

    if ($user_id === null) {
        $booking_message = "Error: User ID not found in session. Please log in again.";
        $booking_type = 'danger';
    } else {
        // Fetch lname from the database
        $query_lname = "SELECT lname FROM patient WHERE email = ?";
        $stmt_lname = $conn->prepare($query_lname);
        if ($stmt_lname) {
            $stmt_lname->bind_param("s", $email);
            $stmt_lname->execute();
            $result_lname = $stmt_lname->get_result();

            if ($result_lname && $result_lname->num_rows == 1) {
                $row_lname = $result_lname->fetch_assoc();
                $lname = $row_lname['lname'];
            } else {
                $booking_message = "Error fetching last name or no user found.";
                $booking_type = 'danger';
            }
            $stmt_lname->close();
        } else {
            $booking_message = "Error preparing statement for last name: " . $conn->error;
            $booking_type = 'danger';
        }

        // Check if the user has already booked an appointment for today
        $check_query = "SELECT appointment_id FROM appointment WHERE user_id = ? AND appointment_date = CURDATE()";
        $check_stmt = $conn->prepare($check_query);
        if ($check_stmt) {
            $check_stmt->bind_param("i", $user_id);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            if ($check_result && $check_result->num_rows > 0) {
                $is_booked = true;
            }
            $check_stmt->close();
        } else {
            $booking_message = "Error checking for existing appointment: " . $conn->error;
            $booking_type = 'danger';
        }

        // Handle booking the appointment if not already booked
        if (isset($_POST['book']) && !$is_booked) {
            // Generate a unique appointment number
            $appointment_num = uniqid();
            $appointment_date = date("Y-m-d"); // Get today's date

            $insert_query = "INSERT INTO appointment (user_id, appointment_num, appointment_date) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);

            if ($insert_stmt) {
                $insert_stmt->bind_param("iss", $user_id, $appointment_num, $appointment_date);
                if ($insert_stmt->execute()) {
                    $booking_message = "Appointment booked successfully!";
                    $booking_type = 'success';
                    $is_booked = true; // Update the status after successful booking
                } else {
                    $booking_message = "Error booking appointment: " . $insert_stmt->error;
                    $booking_type = 'danger';
                }
                $insert_stmt->close();
            } else {
                $booking_message = "Error preparing booking statement: " . $conn->error;
                $booking_type = 'danger';
            }
        }

        // Count the number of appointments for the user for today and add one
        $query_count = "SELECT COUNT(appointment_id) AS appointment_count FROM appointment WHERE user_id = ? AND appointment_date = CURDATE()";
        $stmt_count = $conn->prepare($query_count);
        if ($stmt_count) {
            $stmt_count->bind_param("i", $user_id);
            $stmt_count->execute();
            $result_count = $stmt_count->get_result();
            if ($result_count && $result_count->num_rows == 1) {
                $row_count = $result_count->fetch_assoc();
                $appointment_count = $row_count['appointment_count'] + 1; // Increment the count
            } else {
                $appointment_count = 1; // Default to 1 if no appointments found for today
            }
            $stmt_count->close();
        } else {
            $booking_message = "Error preparing statement for appointment count: " . $conn->error;
            $booking_type = 'danger';
            $appointment_count = 0;
        }
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
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-review">
                        <a href="review.php" class="non-style-link-menu">
                            <div>
                                <i class="fas fa-star"></i>
                                <p class="menu-text">Review</p>
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
                        <?php if ($booking_message): ?>
                        <div class="alert alert-<?php echo htmlspecialchars($booking_type); ?>" role="alert">
                            <?php echo htmlspecialchars($booking_message); ?>
                        </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <div class="abc scroll">
                                <form method="POST">
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
                                                            <div class="h3-search"
                                                                style="font-size:18px;line-height:30px">
                                                                Clinician's name: &nbsp;&nbsp;<b>Dr. Jed Elrick
                                                                    Castilo</b><br>
                                                            </div>
                                                            <div class="h3-search" style="font-size:18px;">
                                                            </div><br>
                                                            <div class="h3-search" style="font-size:18px;">
                                                                Session Title: Rabies Injection<br>
                                                                Session Scheduled Date: <span
                                                                    id="session-date"></span><br>
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
                                                                Appointment Number
                                                            </div>
                                                            <center>
                                                                <div class=" dashboard-icons"
                                                                    style="margin-left: 0px;width:90%;font-size:70px;font-weight:800;text-align:center;color:var(--btnnictext);background-color: var(--btnice)">
                                                                    <?php echo htmlspecialchars($appointment_count); ?>
                                                                </div>
                                                            </center>
                                                        </div><br>
                                                        <br>
                                                        <br>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <button type="submit"
                                                        class="login-btn btn-primary btn btn-book <?php echo $is_booked ? 'btn-disabled' : ''; ?>"
                                                        name="book"
                                                        style="padding: 15px 30px; font-size: 18px; border-radius: 5px; cursor: pointer;"
                                                        <?php echo $is_booked ? 'disabled' : ''; ?>>
                                                        Book now
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
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

    (function() {
        if (!window.chatbase || window.chatbase("getState") !== "initialized") {
            window.chatbase = (...arguments) => {
                if (!window.chatbase.q) {
                    window.chatbase.q = []
                }
                window.chatbase.q.push(arguments)
            };
            window.chatbase = new Proxy(window.chatbase, {
                get(target, prop) {
                    if (prop === "q") {
                        return target.q
                    }
                    return (...args) => target(prop, ...args)
                }
            })
        }
        const onLoad = function() {
            const script = document.createElement("script");
            script.src = "https://www.chatbase.co/embed.min.js";
            script.id = "DpaevYyIB0fUF5fMsUmKN";
            script.domain = "www.chatbase.co";
            document.body.appendChild(script)
        };
        if (document.readyState === "complete") {
            onLoad()
        } else {
            window.addEventListener("load", onLoad)
        }
    })();
    </script>
</body>

</html>