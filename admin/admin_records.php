<?php
// Add your PHP logic here if needed.
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Drawer Form Layout</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
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
            align-items: cent4A90E2er;
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

    .menu-open .sidebar {
      left: 0;
    }

    .menu-open .header {
      left: 250px;
    }

    .menu-open .content-container {
      margin-left: 250px;
    }

    /* Content Area Below Header */
    .content-container {
      margin-top: 60px; /* Ensures content starts below the fixed header */
      padding: 20px;
      transition: margin-left 0.3s ease-in-out;
    }

    /* Semi-header */
    .semi-header-wrapper {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #f1f1f1;
      padding: 10px 30px;
      margin-top: 60px;
      width: 875px; /* Adjusted to 75% width */
      box-sizing: border-box;
      height: 50px;
    }

    .semi-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex: 1; /* Take up all available space */
    }

    .semi-header .section {
      display: flex;
      align-items: center;
    }

    .editable-section {
      background: none;
      border: none;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      margin-left: 8px;
    }

    /* Dropdown */
    .dropdown-wrapper {
      position: absolute;
      top: 60px; /* Same as semi-header's top */
      left: 75%; /* Offset by 75% from left */
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .dropdown-button {
      background-color: white;
      border: 1px solid #ccc;
      padding: 8px 15px;
      font-size: 16px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 75px;
      margin-top: 85px;
      margin-left: 50px;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f1f1f1;
      min-width: 160px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      margin-top: 5px;
    }

    .dropdown-content a {
      color: black;
      padding: 10px 15px;
      display: block;
      text-decoration: none;
    }

    .dropdown-content a:hover {
      background-color: #ddd;
    }

    .dropdown.open .dropdown-content {
      display: block;
    }

    /* Drawer-style info blocks */
    .drawer-container {
      display: flex;
      flex-direction: column;
      gap: 15px;
      padding: 0 30px;
      margin-top: 20px;
    }

    .drawer {
      background-color: #ffffff;
      padding: 15px 20px;
      border-left: 6px solid #00B0B9;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      cursor: pointer;
      transition: transform 0.2s;
    }

    .drawer:hover {
      transform: scale(1.01);
    }

    /* Styling for Animedic and Icon */
    .header-content {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 1.5rem; /* Match the original size */
      font-family: 'Arial', sans-serif; /* Same font as original */
    }

    button {
            background-color: #D1EAF0;
            color: #333;
            border: 1px solid #A6D0D9;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        button:hover {
            background-color: #B9E2F4;
            box-shadow: 0px 6px 8px rgba(0, 0, 0, 0.2);
        }
        button:focus {
            outline: none;
            border: 1px solid #;
        }
        .logout-button {
            margin-left: 800px;
            width: 90px;
            height: 65px;
            background-color: #00B0B9;
        }

  </style>
</head>
<body>
  <!-- Sidebar -->
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

  <!-- Header -->
  <header class="header" id="header">
    <button class="menu-toggle" onclick="toggleMenu()">&#9776;</button>
    <div class="header-content">
      <i class="fa-solid fa-shield-dog"></i> <span>Animedic</span>
    </div>
    <button class="logout-button" onclick="logout()">Logout</button>
  </header>

  <!-- Main Content -->
  <div class="content-container">
    <!-- Semi-header Section -->
    <div class="semi-header-wrapper">
      <div class="semi-header">
        <div class="section">
          <i class="fa-solid fa-user">  Name</i>
        </div>
        <div class="section">
          <i class="fa-solid fa-file">  File</i>
        </div>
        <div class="section">
          <i class="fa-solid fa-tags">  Type</i>
        </div>
        <div class="section">
          <i class="fa-solid fa-trash-can">  Delete</i>
        </div>
      </div>
    </div>

    <!-- Dropdown Filter outside the semi-header with a 75px gap -->
    <div class="dropdown-wrapper">
      <button class="dropdown-button" onclick="toggleDropdown()">Filter <i class="fa-solid fa-chevron-down"></i></button>
      <div class="dropdown-content" id="dropdownContent">
        <a href="#" id="filterName">Name</a>
        <a href="#">Alphabetical</a>
        <a href="#">Numerical</a>
        <a href="#">Date and Time</a>
        <a href="#">Injection Type</a>
      </div>
    </div>

    <!-- Drawer Content Blocks -->
    <div class="drawer-container">
  <div class="drawer"><i class="fa-solid fa-circle-user"></i>  Jenna Ortega</div>
  <div class="drawer"><i class="fa-solid fa-circle-user"></i>  Babylonian Knights</div>
  <div class="drawer"><i class="fa-solid fa-circle-user"></i>  Barbaric Barbie</div>
  <div class="drawer"><i class="fa-solid fa-circle-user"></i>  Drumming Bird</div>
  <div class="drawer"><i class="fa-solid fa-circle-user"></i>  Shibuli Manika</div>
  <div class="drawer"><i class="fa-solid fa-circle-user"></i>  Howdoes Itfeel</div>
  <div class="drawer"><i class="fa-solid fa-circle-user"></i>  Together WithMyself</div>
</div>


  <!-- Scripts -->
  <script>
    function toggleMenu() {
      document.body.classList.toggle("menu-open");
    }

    function toggleDropdown() {
      const dropdown = document.getElementById("dropdown");
      dropdown.classList.toggle("open");

      const filterName = document.getElementById("filterName");
      filterName.innerHTML = dropdown.classList.contains("open") ? "Sort by:" : "Name";
    }

    // Navigation Events
    form1.addEventListener("click", () => window.location.href = "admin_index.php");
    form2.addEventListener("click", () => window.location.href = "admin_records.php");
    form3.addEventListener("click", () => window.location.href = "admin_appointments.php");
    form4.addEventListener("click", () => window.location.href = "admin_inventory.php");
  </script>
</body>
</html>