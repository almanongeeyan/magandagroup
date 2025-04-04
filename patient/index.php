<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="patient.css">
    <title>Dashboard</title>
    <link rel="" hreh="patient.css">
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



// Check if user is logged in
if (isset($_SESSION['auth']) && $_SESSION['auth'] == true) {
    // User is logged in
    $fname = $_SESSION['auth_user']['fname'];
    $email = $_SESSION['auth_user']['email'];

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
                                <td style="padding:0px;margin:0px; text-align: left;">
                                    <p class="profile-title" style="text-align: left;">
                                        <?php echo htmlspecialchars($fname . ' ' . $lname); ?></p>
                                    <p class="profile-subtitle" style="text-align: left;">
                                        <?php echo htmlspecialchars($email); ?></p>
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
                    <td class="menu-btn menu-icon-home menu-active menu-icon-home-active">
                        <a href="index.php" class="non-style-link-menu non-style-link-menu-active">
                            <div>
                                <i class="fas fa-home"></i>
                                <p class="menu-text">Home</p>
                            </div>
                        </a>
                    </td>
                </tr>

                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session">
                        <a href="appointment.php" class="non-style-link-menu">
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
        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;">
                <tr>
                    <td colspan="1" class="nav-bar">
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;margin-left:20px;">Home</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <table class="filter-container patient-header" style="border: none;width:95%" border="0">
                                <tr>
                                    <td>
                                        <h3>Welcome!</h3>
                                        <h1><?php echo htmlspecialchars($fname . ' ' . $lname); ?>.</h1>
                                        <p>Welcome to our dedicated Animal Bite Clinic, conveniently located in
                                            Caloocan, Metro Manila. Our primary focus is providing expert and immediate
                                            care for all types of animal bites. We understand the serious risks
                                            associated with such incidents, particularly the threat of rabies. Our
                                            experienced medical professionals offer thorough wound assessment,
                                            meticulous cleaning, and administer the necessary preventative treatments,
                                            including rabies vaccinations. Your health and safety are our utmost
                                            priority. If you have experienced an animal bite, please visit our clinic
                                            directly for immediate attention and the essential care, including any
                                            required rabies injections.</p>
                                    </td>
                                </tr>
                            </table>
                        </center>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <script>
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