<?php
session_start();
if (!isset($_SESSION['admin_auth']) || $_SESSION['admin_auth'] !== true) {
    header("Location: ../tresspass/notresspass.php"); // Redirect if not authenticated as admin
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Animal Bite Clinic</title>
    <link rel="stylesheet" href="adminn.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include '../includes/admin_sidebar.php'; ?>


    <div class="content-wrapper" id="contentWrapper">
        <header class="header" id="header">
            <button class="menu-toggle" onclick="toggleMenu()">&#9776;</button>
            <h1><i class="fa-solid fa-shield-dog"></i> Animal Bite Clinic - Admin</h1>
        </header>

        <div class="analytics-container">
            <h2 class="analytics-title">Analytics</h2>
            <div class="analytics-row">
                <form class="analytics-form">
                    <h3>Sex</h3>
                    <canvas id="pieChart1" width="200" height="200"></canvas>
                </form>

                <form class="analytics-form">
                    <h3>Bitten By :</h3>
                    <canvas id="pieChart2" width="200" height="200"></canvas>
                </form>
            </div>
            <!-- <div class="analytics-row">
                <form class="analytics-form">
                    <h3>Inventory Details</h3>
                    <canvas id="pieChart3" width="200" height="200"></canvas>
                </form>
            </div> -->
        </div>
    </div>

    <script src="js/admin_scripts.js"></script>
    <script>
    // Pie Chart 1 (Form 1)
    var ctx1 = document.getElementById('pieChart1').getContext('2d');
    var pieChart1 = new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                data: [51, 49],
                backgroundColor: ['#4A90E2', '#E91E63'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom', // Position the legend at the bottom
                }
            }
        }
    });

    // Pie Chart 2 (Form 2)
    var ctx2 = document.getElementById('pieChart2').getContext('2d');
    var pieChart2 = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Cat', 'Dog'],
            datasets: [{
                data: [35, 65],
                backgroundColor: ['#9E9E9E', '#795548'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom', // Position the legend at the bottom
                }
            }
        }
    });

    // // Pie Chart 3 (Form 3)
    // var ctx3 = document.getElementById('pieChart3').getContext('2d');
    // var pieChart3 = new Chart(ctx3, {
    //     type: 'pie',
    //     data: {
    //         labels: ['In Stock', 'No Stock'],
    //         datasets: [{
    //             data: [44, 56],
    //             backgroundColor: ['#4CAF50', 'RED'],
    //             borderWidth: 0
    //         }]
    //     },
    //     options: {
    //         responsive: true,
    //         plugins: {
    //             legend: {
    //                 display: true,
    //                 position: 'bottom', // Position the legend at the bottom
    //             }
    //         }
    //     }
    // });

    function toggleMenu() {
        document.body.classList.toggle("menu-open");
    }
    </script>
</body>

</html>