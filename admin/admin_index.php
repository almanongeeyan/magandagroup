@ -0,0 +1,293 @@
<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website with Hamburger Menu</title>
    <style>
<<<<<<< HEAD
    html,
    body {
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

    .analytics-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-left: 100px;
        margin-top: 50px;
    }

    .analytics-row {
        display: flex;
        justify-content: center;
        gap: 50px;
        margin-right: 25px;
    }

    .analytics-form {
        width: 250px;
        padding: 20px;
        background: #D1EAF0;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    .summary-container {
        width: 250px;
        padding: 15px;
        background: #D1EAF0;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
        height: 300px;
        position: sticky;
        top: 100px;
        margin-top: 150px;
        margin-right: 100px;
    }

    .summary-form h3 {
        margin-bottom: 10px;
        color: #333;
    }

    .summary-form p {
        margin: 5px 0;
        font-size: 14px;
        color: #555;
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
=======
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
        .analytics-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-left: 100px;
            margin-top: 50px;
        }
        .analytics-row {
            display: flex;
            justify-content: center;
            gap: 50px;
            margin-right: 25px;
        }
        .analytics-form {
            width: 250px;
            padding: 20px;
            background: #D1EAF0;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .summary-container {
            width: 250px;
            padding: 15px;
            background: #D1EAF0;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            height: 300px;
            position: sticky;
            top: 100px;
            margin-top: 150px;
            margin-right: 100px;
        }
        .summary-form h3 {
            margin-bottom: 10px;
            color: #333;
        }
        .summary-form p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
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
>>>>>>> ab2aef813e540ce372b4ca16bdf23d4086826b0a
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
        <div class="analytics-container">
            <header class="header" id="header">
                <button class="menu-toggle" onclick="toggleMenu()">&#9776;</button>
                <h1><i class="fa-solid fa-shield-dog"></i> Animedic</h1>
                <button class="logout-button" onclick="logout()">Logout</button>
            </header>

            <h1><i class="fa-solid fa-chart-line"></i> Analytics</h1>

            <div class="analytics-row">
                <form class="analytics-form">
<<<<<<< HEAD
                    <h3><button type="button"
                            onclick="updateSummary('Male - 51%, Female - 49%', 'NO DATA ON BITE TYPES', 'NO DATA ON STOCKS')">Sex</button>
                    </h3>
=======
                    <h3><button type="button" onclick="updateSummary('Male - 51%, Female - 49%', 'NO DATA ON BITE TYPES', 'NO DATA ON STOCKS')">Sex</button></h3>
>>>>>>> ab2aef813e540ce372b4ca16bdf23d4086826b0a
                    <canvas id="pieChart1" width="200" height="200"></canvas>
                </form>

                <form class="analytics-form">
<<<<<<< HEAD
                    <h3><button type="button"
                            onclick="updateSummary('NO DATA ON SEX', 'Dog - 65%, Cat - 35%', 'NO DATA ON STOCK')">Bitten
                            Type</h3>
=======
                    <h3><button type="button" onclick="updateSummary('NO DATA ON SEX', 'Dog - 65%, Cat - 35%', 'NO DATA ON STOCK')">Bitten Type</h3>
>>>>>>> ab2aef813e540ce372b4ca16bdf23d4086826b0a
                    <canvas id="pieChart2" width="200" height="200"></canvas>
                </form>
            </div>
            <div class="analytics-row">
                <form class="analytics-form">
<<<<<<< HEAD
                    <h3><button type="button"
                            onclick="updateSummary('NO DATA ON SEX', 'NO DATA ON BITE TYPES', 'In Stock - 44%, No Stock - 56%')">Injection
                            Details</button></h3>
=======
                    <h3><button type="button" onclick="updateSummary('NO DATA ON SEX', 'NO DATA ON BITE TYPES', 'In Stock - 44%, No Stock - 56%')">Injection Details</button></h3>
>>>>>>> ab2aef813e540ce372b4ca16bdf23d4086826b0a
                    <canvas id="pieChart3" width="200" height="200"></canvas>
                </form>
            </div>
        </div>

        <div class="summary-container" id="summaryForm">
            <h3>Summary</h3>
            <p><strong>Sex:</strong>No Details Yet</p>
            <p><strong>Bitten By:</strong> No Details Yet</p>
            <p><strong>Injection:</strong> No Details Yet</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
<<<<<<< HEAD
    function createChart(canvasId, labels, data, colors) {
        new Chart(document.getElementById(canvasId).getContext('2d'), {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: colors,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                    }
                }
            }
        });
    }

    createChart('pieChart1', ['Male', 'Female'], [51, 49], ['#4A90E2', '#E91E63']);
    createChart('pieChart2', ['Cat', 'Dog'], [35, 65], ['#9E9E9E', '#795548']);
    createChart('pieChart3', ['In Stock', 'No Stock'], [44, 56], ['#4CAF50', 'red']);

    function toggleMenu() {
        document.body.classList.toggle("menu-open");
    }

    const form1 = document.getElementById("form1");
    const form2 = document.getElementById("form2");
    const form3 = document.getElementById("form3");
    const form4 = document.getElementById("form4");

    pieChart1.addEventListener("click", () => {
        updateSummary('Male - 51%, Female - 49%', 'NO DATA ON BITE TYPES', 'NO DATA ON STOCK');
    });

    pieChart2.addEventListener("click", () => {
        updateSummary('NO DATA ON SEX', 'Dog - 65%, Cat - 35%', 'NO DATA ON STOCK');
    });

    pieChart3.addEventListener("click", () => {
        updateSummary('NO DATA ON SEX', 'NO DATA ON BITE TYPES', 'In Stock - 44%, No Stock - 56%');
    });

    function updateSummary(sex, bittenBy, inventory) {
        const summaryForm = document.getElementById("summaryForm");
        summaryForm.innerHTML = `
=======
        function createChart(canvasId, labels, data, colors) {
            new Chart(document.getElementById(canvasId).getContext('2d'), {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: colors,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                        }
                    }
                }
            });
        }

        createChart('pieChart1', ['Male', 'Female'], [51, 49], ['#4A90E2', '#E91E63']);
        createChart('pieChart2', ['Cat', 'Dog'], [35, 65], ['#9E9E9E', '#795548']);
        createChart('pieChart3', ['In Stock', 'No Stock'], [44, 56], ['#4CAF50', 'red']);

        function toggleMenu() {
            document.body.classList.toggle("menu-open");
        }

        const form1 = document.getElementById("form1");
        const form2 = document.getElementById("form2");
        const form3 = document.getElementById("form3");
        const form4 = document.getElementById("form4");

        pieChart1.addEventListener("click", () => {
            updateSummary('Male - 51%, Female - 49%', 'NO DATA ON BITE TYPES', 'NO DATA ON STOCK');
        });

        pieChart2.addEventListener("click", () => {
            updateSummary('NO DATA ON SEX', 'Dog - 65%, Cat - 35%', 'NO DATA ON STOCK');
        });

        pieChart3.addEventListener("click", () => {
            updateSummary('NO DATA ON SEX', 'NO DATA ON BITE TYPES', 'In Stock - 44%, No Stock - 56%');
        });

        function updateSummary(sex, bittenBy, inventory) {
            const summaryForm = document.getElementById("summaryForm");
            summaryForm.innerHTML = `
>>>>>>> ab2aef813e540ce372b4ca16bdf23d4086826b0a
                <h3>Summary</h3>
                <p><strong>Sex:</strong> ${sex}</p>
                <p><strong>Bitten By:</strong> ${bittenBy}</p>
                <p><strong>Inventory:</strong> ${inventory}</p>
            `;
<<<<<<< HEAD
    }
=======
        }
>>>>>>> ab2aef813e540ce372b4ca16bdf23d4086826b0a
    </script>
</body>

</html>