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



?>

<body>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px">
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title">John Doe..</p>
                                    <p class="profile-subtitle">john.doe@example.com</p>
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
                                <i class="fas"></i>
                                <p class="menu-text">Home</p>
                            </div>
                        </a>
                    </td>
                </tr>

                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session">
                        <a href="appointment.php" class="non-style-link-menu">
                            <div>
                                <i class="fas"></i>
                                <p class="menu-text">Make an Appointment</p>
                            </div>
                        </a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="record.php" class="non-style-link-menu">
                            <div>
                                <i class="fas"></i>
                                <p class="menu-text">My Record</p>
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
                                        <h1>John Doe.</h1>
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
    </script>
</body>

</html>