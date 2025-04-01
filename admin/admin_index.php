<?php
    // You can add PHP logic here in the future if needed
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website with Hamburger Menu</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
            width: 100vw;
        }
        .header {
            background-color: #00B0B9;
            color: white;
            padding: 20px 30px;
            display: flex;
            align-items: center;
            position: fixed;
            width: 100vw;
            transition: left 0.3s ease-in-out;
            top: 0;
            left: 0;
            z-index: 1000;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            font-family: 'Helvetica Neue', sans-serif;
        }
        .menu-toggle {
            font-size: 24px;
            cursor: pointer;
            background: none;
            border: none;
            color: white;
            margin-right: 15px;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #333;
            color: white;
            position: fixed;
            top: 0;
            left: -250px;
            transition: left 0.3s ease-in-out;
            padding-top: 60px;
            z-index: 999;
            text-align: center;
        }
        .sidebar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: block;
            margin: 20px auto;
        }
        .sidebar .editable-name {
            color: white;
            font-size: 18px;
            margin-top: 10px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            background: none;
            text-align: center;
            width: 100%;
            outline: none;
        }
        .sidebar .nav-links {
            margin-top: 20px;
            border-top: 1px solid #575757;
            padding-top: 10px;
        }
        .sidebar a {
            display: flex;
            align-items: center;
            color: white;
            padding: 15px;
            text-decoration: none;
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .sidebar a:hover {
            background: #575757;
        }
        .content-wrapper {
            transition: left 0.3s ease-in-out;
            position: relative;
            padding: 20px;
            left: 0;
            margin-top: 75px;
        }
        .menu-open .sidebar {
            left: 0;
        }
        .menu-open .header,
        .menu-open .content-wrapper {
            left: 250px;
        }
        .analytics-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 20px;
            margin-top: 100px;
        }
        .analytics-row {
            display: flex;
            justify-content: center;
            gap: 50px;
        }
        .analytics-form {
            width: 250px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="sidebar" id="sidebar">
        <img src="spidey.jpg.jpg" alt="Profile Picture">
        <input type="text" class="editable-name" value="Janny BOI" id="editableName">
        <div class="nav-links">
            <a href="#"><i class="fa-solid fa-gauge-simple-high"></i>Dashboard</a>
            <a href="#"><i class="fa-solid fa-clipboard-list"></i>Records</a>
            <a href="#"><i class="fa-solid fa-calendar-days"></i>Appointments</a>
            <a href="#"><i class="fa-solid fa-warehouse"></i>Inventory</a>
        </div>
    </div>

    <div class="content-wrapper" id="contentWrapper">
        <header class="header" id="header">
            <button class="menu-toggle" onclick="toggleMenu()">&#9776;</button>
            <h1><i class="fa-solid fa-shield-dog"></i>  Animal Bite Clinic</h1>
        </header>
        
        <!-- Analytics Forms in V Shape -->
        <div class="analytics-container">
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
            <div class="analytics-row">
                <form class="analytics-form">
                    <h3>Inventory Details</h3>
                    <canvas id="pieChart3" width="200" height="200"></canvas>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        position: 'bottom',  // Position the legend at the bottom
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
                        position: 'bottom',  // Position the legend at the bottom
                    }
                }
            }
        });

        // Pie Chart 3 (Form 3)
        var ctx3 = document.getElementById('pieChart3').getContext('2d');
        var pieChart3 = new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: ['In Stock', 'No Stock'],
                datasets: [{
                    data: [44, 56],
                    backgroundColor: ['#4CAF50', 'RED'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',  // Position the legend at the bottom
                    }
                }
            }
        });
    </script>
    
    <script>
        function toggleMenu() {
            document.body.classList.toggle("menu-open");
        }
    </script>
</body>
</html>
