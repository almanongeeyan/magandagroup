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
            background-color: #007BA7;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            position: fixed;
            width: 100vw;
            transition: left 0.3s ease-in-out;
            top: 0;
            left: 0;
            z-index: 1000;
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
            transition: left 0.3s ease-in-out;
            position: relative;
        }
        .menu-open .analytics-container {
            left: 250px;
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
        <div class="analytics-container">
            <div class="analytics-row">
                <form class="analytics-form">
                    <h3>Analytics 1</h3>
                </form>
                <form class="analytics-form">
                    <h3>Analytics 2</h3>
                </form>
            </div>
            <div class="analytics-row">
                <form class="analytics-form">
                    <h3>Analytics 3</h3>
                </form>
            </div>
        </div>
    </div>
    <script>
        function toggleMenu() {
            document.body.classList.toggle("menu-open");
        }
    </script>
</body>
</html>
