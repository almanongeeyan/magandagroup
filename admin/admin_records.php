<?php
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
            display: flex;
            transition: margin-left 0.3s ease-in-out;
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
            background-color: #caf0f8;
        }
        .sidebar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: block;
            margin: 20px auto;
        }
        .sidebar .editable-name {
            color: black;
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
            color: black;
            padding: 15px;
            text-decoration: none;
        }
        .sidebar a i {
            margin-right: 10px;
        }
        .sidebar a:hover {
            background: #575757;
        }
        .content-container {
            display: flex;
            flex-grow: 1;
            margin-left: 0;
            padding: 20px;
            margin-top: 75px;
            justify-content: space-between;
            transition: margin-left 0.3s ease-in-out;
        }
        .menu-open .sidebar {
            left: 0;
        }
        .menu-open .header {
            left: 250px;
        }
        .menu-open .content-container {
            margin-left: 250px;
        }
        .logout-button {
            margin-left: 800px;
            width: 90px;
            height: 65px;
            background-color: #00B0B9;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="sidebar" id="sidebar">
        <img src="spidey.jpg.jpg" alt="Profile Picture">
        <input type="text" class="editable-name" value="Janny BOI" id="editableName">
        <div class="nav-links">
            <a href="#" id="form1"><i class="fa-solid fa-gauge-simple-high"></i>Dashboard</a>
            <a href="#" id="form2"><i class="fa-solid fa-clipboard-list"></i>Records</a>
            <a href="#" id="form3"><i class="fa-solid fa-calendar-days"></i>Appointments</a>
            <a href="#" id="form4"><i class="fa-solid fa-warehouse"></i>Inventory</a>
        </div>
    </div>

    <div class="content-container">
        <header class="header" id="header">
            <button class="menu-toggle" onclick="toggleMenu()">&#9776;</button>
            <h1><i class="fa-solid fa-shield-dog"></i> Animedic</h1>
            <button class="logout-button" onclick="logout()">Logout</button>
        </header>
    </div>

    <script>
        function toggleMenu() {
            document.body.classList.toggle("menu-open");
        }

        form1.addEventListener("click", () => {
            window.location.href = "admin_index2.php";
        });
        form2.addEventListener("click", () => {
            window.location.href = "admin_records.php";
        });

        const form3 = document.getElementById("form3");
        const form4 = document.getElementById("form4");
    </script>
</body>
</html>
