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

    /* General table styles */
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .data-table th,
    .data-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .data-table th {
        background-color: #f2f2f2;
    }

    .data-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .data-table tr:hover {
        background-color: #f0f0f0;
    }

    /* Print-specific styles */
    @media print {
        body * {
            visibility: hidden;
        }

        .print-area,
        .print-area * {
            visibility: visible;
        }

        .print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            font-size: 10px;
        }

        /* Print-specific table styles */
        .print-table {
            width: 100%;
            border-collapse: collapse;
        }

        .print-table th,
        .print-table td {
            border: 1px solid black;
            padding: 3px;
            text-align: left;
        }

        .print-user-info {
            background-color: #f0f0f0;
            padding: 5px;
            border-radius: 3px;
            margin-bottom: 5px;
        }
    }

    /* Style for User Information */
    .user-info {
        background-color: #e6f7ff;
        /* Light blue background */
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        /* Soft shadow */
    }

    .user-info p {
        margin: 5px 0;
        /* Spacing between paragraphs */
        font-size: 16px;
    }

    .user-info strong {
        font-weight: bold;
        color: #333;
        /* Darker color for labels */
    }

    /* Style for Download PDF Button */
    .download-pdf-btn {
        background-color: #4CAF50;
        /* Green background */
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        /* Smooth transition */
    }

    .download-pdf-btn:hover {
        background-color: #45a049;
        /* Darker green on hover */
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

// Check if user is logged in
if (isset($_SESSION['auth']) && $_SESSION['auth'] == true) {
    // User is logged in
    $fname = $_SESSION['auth_user']['fname'];
    $email = $_SESSION['auth_user']['email'];

    // Fetch user details from the database
    $query = "SELECT lname, user_id, age, gender, cnumber FROM patient WHERE email = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $lname = $row['lname'];
            $user_id = $row['user_id'];
            $age = $row['age'];
            $gender = $row['gender'];
            $cnumber = $row['cnumber'];
        } else {
            echo "<p>Error fetching user details or no user found.</p>";
        }
        $stmt->close();
    } else {
        echo "<p>Error preparing statement for user details: " . $conn->error . "</p>";
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
                    <td class="menu-btn menu-icon-appoinment menu-active menu-icon-appoinment-active">
                        <a href="record.php" class="non-style-link-menu non-style-link-menu-active">
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
                    <p style="font-size: 23px;padding-left:12px;font-weight: 600;margin-left:20px;">My Record</p>
                </td>
            </table>

            <div class="print-area">
                <div class="user-info">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($fname . ' ' . $lname); ?></p>
                    <p><strong>Age:</strong> <?php echo htmlspecialchars($age); ?></p>
                    <p><strong>Gender:</strong> <?php echo htmlspecialchars($gender); ?></p>
                    <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($cnumber); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                </div>

                <?php
                $vaccine_query = "SELECT date_exposure, date_treatment, bitten_by, vaccine, brand_name, route, D0_date, D0_site, D0_given, D3_date, D3_site, D3_given, D7_date, D7_site, D7_given, D14_date, D14_site, D14_given, D28_date, D28_site, D28_given FROM vaccination_data WHERE user_id = ?";
                $vaccine_stmt = $conn->prepare($vaccine_query);
                if ($vaccine_stmt) {
                    $vaccine_stmt->bind_param("i", $user_id);
                    $vaccine_stmt->execute();
                    $vaccine_result = $vaccine_stmt->get_result();

                    if ($vaccine_result && $vaccine_result->num_rows > 0) {
                        $vaccine_data = $vaccine_result->fetch_all(MYSQLI_ASSOC);

                        // Display general information at the top
                        echo "<h4>General Information</h4>";
                        echo "<table class='data-table'>";
                        echo "<thead><tr><th>Date Exposure</th><th>Date Treatment</th><th>Bitten By</th><th>Vaccine</th><th>Brand Name</th><th>Route</th></tr></thead>";
                        echo "<tbody>";
                        foreach ($vaccine_data as $row) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['date_exposure']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['date_treatment']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['bitten_by']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['vaccine']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['brand_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['route']) . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody></table>";

                        // Group data by day
                        $grouped_data = array(
                            'D0' => array(),
                            'D3' => array(),
                            'D7' => array(),
                            'D14' => array(),
                            'D28' => array()
                        );

                        foreach ($vaccine_data as $row) {
                            $grouped_data['D0'][] = array(
                                'date' => $row['D0_date'],
                                'site' => $row['D0_site'],
                                'given' => $row['D0_given']
                            );
                            $grouped_data['D3'][] = array(
                                'date' => $row['D3_date'],
                                'site' => $row['D3_site'],
                                'given' => $row['D3_given']
                            );
                            $grouped_data['D7'][] = array(
                                'date' => $row['D7_date'],
                                'site' => $row['D7_site'],
                                'given' => $row['D7_given']
                            );
                            $grouped_data['D14'][] = array(
                                'date' => $row['D14_date'],
                                'site' => $row['D14_site'],
                                'given' => $row['D14_given']
                            );
                            $grouped_data['D28'][] = array(
                                'date' => $row['D28_date'],
                                'site' => $row['D28_site'],
                                'given' => $row['D28_given']
                            );
                        }

                        // Display grouped data in tables
                        foreach ($grouped_data as $day => $data) {
                            if (!empty($data)) {
                                echo "<h4>" . htmlspecialchars($day) . "</h4>";
                                echo "<table class='data-table'>";
                                echo "<thead><tr><th>Date</th><th>Site</th><th>Given</th></tr></thead>";
                                echo "<tbody>";
                                foreach ($data as $item) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($item['date']) . "</td>";
                                    echo "<td>" . htmlspecialchars($item['site']) . "</td>";
                                    echo "<td>" . htmlspecialchars($item['given']) . "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody></table>";
                            }
                        }
                    } else {
                        echo "<p>No vaccination records found.</p>";
                    }
                    $vaccine_stmt->close();
                } else {
                    echo "<p>Error preparing statement: " . $conn->error . "</p>";
                }
                ?>
            </div>
            <br>
            <button onclick="window.print()" class="download-pdf-btn">Download PDF</button>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const menuButtons = document.querySelectorAll('.menu-btn');
                menuButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        menuButtons.forEach(btn => {
                            btn.classList.remove('menu-active');
                            btn.classList.remove(btn.classList[1] + '-active');
                        });
                        this.classList.add('menu-active');
                        this.classList.add(this.classList[1] + '-active');
                    });
                });
            });
            </script>
        </div>
    </div>
</body>

</html>