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

        /* Semi-header style */
        .semi-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f1f1f1;
            padding: 10px 30px;
            margin-top: 75px;
            margin-bottom: 10px; /* Add space between the header and semi-header */
            width: calc(75vw + -400px); /* Increase width by 300px */
        }

        .section {
            display: flex;
            align-items: center;
        }

        .section i {
            margin-right: 10px;
        }

        .editable-section {
            border: none;
            background: none;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        /* Dropdown container */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Button for the dropdown */
        .dropdown-button {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 8px 15px;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .dropdown-button i {
            margin-left: 2000px;
        }

        /* Dropdown content */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        /* Links inside the dropdown */
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        /* Show dropdown when clicked */
        .dropdown.open .dropdown-content {
            display: block;
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

        /* Position the dropdown to be connected with 150px gap from the right */
        .header .dropdown {
            position: absolute;
            right: 150px; /* 150px gap from the right edge */
            top: 50%;
            transform: translateY(-50%);
        }

        /* Hamburger icon for menu */
        .menu-toggle {
            font-size: 30px;
            cursor: pointer;
            background: none;
            border: none;
            color: white;
            margin-right: 15px;
            z-index: 9999;
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
        
        <!-- Semi Header -->
        <div class="semi-header">
            <div class="section">
                <i class="fa-solid fa-user"></i>
                <button class="editable-section">Name</button>
            </div>
            <div class="section">
                <i class="fa-solid fa-file"></i>
                <button class="editable-section">File</button>
            </div>
            <div class="section">
                <i class="fa-solid fa-tags"></i>
                <button class="editable-section">Type</button>
            </div>
            <div class="section">
                <i class="fa-solid fa-cogs"></i>
                <button class="editable-section">Icon</button> <!-- Reverted to a replaceable icon -->
            </div>
        </div>
    </div>

    <div class="dropdown" id="dropdown">
        <button class="dropdown-button" onclick="toggleDropdown()">Filter <i class="fa-solid fa-chevron-down"></i></button>
        <div class="dropdown-content" id="dropdownContent">
            <a href="#" id="filterName">Name</a>
            <a href="#">File</a>
            <a href="#">Type</a>
        </div>
    </div>

    <script>
        function toggleMenu() {
            document.body.classList.toggle("menu-open");
        }

        function toggleDropdown() {
            const dropdown = document.getElementById("dropdown");
            dropdown.classList.toggle("open");
            const filterName = document.getElementById("filterName");

            if (dropdown.classList.contains("open")) {
                filterName.innerHTML = "Sort by :";
            } else {
                filterName.innerHTML = "Name";
            }
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
