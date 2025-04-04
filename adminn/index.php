<?php
session_start();
if (!isset($_SESSION['admin_auth']) || $_SESSION['admin_auth'] !== true) {
    header("Location: ../tresspass/notresspass.php"); // Redirect if not authenticated as admin
    exit();
}

require '../tresspass/connection.php';

// Fetch total number of records
$sql_total_records = "SELECT COUNT(*) as total FROM vaccination_data";
$result_total_records = $conn->query($sql_total_records);
$total_records = $result_total_records->fetch_assoc()['total'] ?? 0;

// Fetch count of unique patients
$sql_unique_patients = "SELECT COUNT(DISTINCT user_id) as unique_count FROM vaccination_data";
$result_unique_patients = $conn->query($sql_unique_patients);
$unique_patients = $result_unique_patients->fetch_assoc()['unique_count'] ?? 0;

// Fetch count of dog bites
$sql_dog_bites = "SELECT COUNT(*) as dog_count FROM vaccination_data WHERE bitten_by = 'Dog'";
$result_dog_bites = $conn->query($sql_dog_bites);
$dog_bites = $result_dog_bites->fetch_assoc()['dog_count'] ?? 0;

// Fetch count of cat bites
$sql_cat_bites = "SELECT COUNT(*) as cat_count FROM vaccination_data WHERE bitten_by = 'Cat'";
$result_cat_bites = $conn->query($sql_cat_bites);
$cat_bites = $result_cat_bites->fetch_assoc()['cat_count'] ?? 0;

// Fetch count of rat bites
$sql_rat_bites = "SELECT COUNT(*) as rat_count FROM vaccination_data WHERE bitten_by = 'Rat'";
$result_rat_bites = $conn->query($sql_rat_bites);
$rat_bites = $result_rat_bites->fetch_assoc()['rat_count'] ?? 0;

// Fetch data for "Bitten By" chart
$sql_bitten_by = "SELECT bitten_by, COUNT(*) as count FROM vaccination_data GROUP BY bitten_by";
$result_bitten_by = $conn->query($sql_bitten_by);
$bitten_by_data = [];
if ($result_bitten_by && $result_bitten_by->num_rows > 0) {
    while ($row = $result_bitten_by->fetch_assoc()) {
        $bitten_by_data[$row['bitten_by']] = $row['count'];
    }
}

// Fetch data for "Vaccine Used" chart
$sql_vaccine = "SELECT vaccine, COUNT(*) as count FROM vaccination_data GROUP BY vaccine";
$result_vaccine = $conn->query($sql_vaccine);
$vaccine_data = [];
if ($result_vaccine && $result_vaccine->num_rows > 0) {
    while ($row = $result_vaccine->fetch_assoc()) {
        $vaccine_data[$row['vaccine']] = $row['count'];
    }
}

// Fetch data for "Route of Administration" chart
$sql_route = "SELECT route, COUNT(*) as count FROM vaccination_data GROUP BY route";
$result_route = $conn->query($sql_route);
$route_data = [];
if ($result_route && $result_route->num_rows > 0) {
    while ($row = $result_route->fetch_assoc()) {
        $route_data[$row['route']] = $row['count'];
    }
}

// Fetch data for "Brand Name Used" chart
$sql_brand_name = "SELECT brand_name, COUNT(*) as count FROM vaccination_data GROUP BY brand_name";
$result_brand_name = $conn->query($sql_brand_name);
$brand_name_data = [];
if ($result_brand_name && $result_brand_name->num_rows > 0) {
    while ($row = $result_brand_name->fetch_assoc()) {
        $brand_name_data[$row['brand_name']] = $row['count'];
    }
}

// Fetch data for "Sex" chart
$sql_sex = "SELECT p.gender, COUNT(*) as count
            FROM vaccination_data v
            INNER JOIN patient p ON v.user_id = p.user_id
            GROUP BY p.gender";
$result_sex = $conn->query($sql_sex);
$sex_data = [];
if ($result_sex && $result_sex->num_rows > 0) {
    while ($row = $result_sex->fetch_assoc()) {
        $sex_data[$row['gender']] = $row['count'];
    }
}

// Fetch data for the bitten by animal and gender table
$sql_bitten_by_gender = "SELECT p.gender, v.bitten_by, COUNT(*) as count
                            FROM vaccination_data v
                            INNER JOIN patient p ON v.user_id = p.user_id
                            WHERE v.bitten_by IN ('Dog', 'Cat', 'Rat')
                            GROUP BY p.gender, v.bitten_by
                            ORDER BY p.gender, v.bitten_by";
$result_bitten_by_gender = $conn->query($sql_bitten_by_gender);
$bitten_by_gender_data = [];
if ($result_bitten_by_gender && $result_bitten_by_gender->num_rows > 0) {
    while ($row = $result_bitten_by_gender->fetch_assoc()) {
        $bitten_by_gender_data[$row['gender']][$row['bitten_by']] = $row['count'];
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Animal Bite Clinic</title>
    <link rel="stylesheet" href="adminn.css">
    <link rel="stylesheet" href="record.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    .dashboard-stats {
        display: flex;
        justify-content: space-around;
        align-items: center;
        padding: 20px;
        background-color: #f9f9f9;
        border-bottom: 1px solid #eee;
        margin-bottom: 20px;
    }

    .stat-card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 15px 20px;
        text-align: center;
        flex-basis: 20%;
    }

    .stat-card h3 {
        margin-top: 0;
        color: #333;
        font-size: 1.5em;
    }

    .stat-card p {
        color: #777;
        font-size: 1em;
        margin-bottom: 0;
    }

    .analytics-container {
        padding: 20px;
    }

    .analytics-title {
        margin-bottom: 20px;
        color: #333;
        border-bottom: 2px solid #ccc;
        padding-bottom: 10px;
    }

    .analytics-row {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .analytics-form {
        flex: 1;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .analytics-form h3 {
        color: #555;
        margin-top: 0;
        margin-bottom: 10px;
    }

    .gender-bites-table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
    }

    .gender-bites-table th,
    .gender-bites-table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }

    .gender-bites-table th {
        background-color: #e0f2f7;
        /* Light blue header */
        color: #333;
        font-weight: bold;
    }

    .gender-bites-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    @media (max-width: 768px) {
        .analytics-row {
            flex-direction: column;
        }

        .analytics-form {
            width: 100%;
        }
    }
    </style>
</head>

<body>
    <?php include '../includes/admin_sidebar.php'; ?>

    <div class="content-wrapper" id="contentWrapper">
        <header class="header" id="header">
            <button class="menu-toggle" onclick="toggleMenu()">&#9776;</button>
            <h1><i class="fa-solid fa-shield-dog"></i> Animal Bite Clinic - Admin</h1>
        </header>

        <div class="dashboard-stats">
            <div class="stat-card">
                <h3><?= htmlspecialchars(number_format($total_records)) ?></h3>
                <p>Total Records</p>
            </div>
            <div class="stat-card">
                <h3><?= htmlspecialchars(number_format($unique_patients)) ?></h3>
                <p>Unique Patients</p>
            </div>
            <div class="stat-card">
                <h3><?= htmlspecialchars(number_format($dog_bites)) ?></h3>
                <p>Dog Bites</p>
            </div>
            <div class="stat-card">
                <h3><?= htmlspecialchars(number_format($cat_bites)) ?></h3>
                <p>Cat Bites</p>
            </div>
            <div class="stat-card">
                <h3><?= htmlspecialchars(number_format($rat_bites)) ?></h3>
                <p>Rat Bites</p>
            </div>
        </div>

        <div class="analytics-container">
            <h2 class="analytics-title">Detailed Statistics</h2>
            <div class="analytics-table">
                <h3>Bites by Gender and Animal</h3>
                <table class="gender-bites-table">
                    <thead>
                        <tr>
                            <th>Gender</th>
                            <th>Dog</th>
                            <th>Cat</th>
                            <th>Rat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($bitten_by_gender_data)): ?>
                        <?php foreach ($bitten_by_gender_data as $gender => $bites): ?>
                        <tr>
                            <td><?= htmlspecialchars($gender) ?></td>
                            <td><?= isset($bites['Dog']) ? htmlspecialchars($bites['Dog']) : 0 ?></td>
                            <td><?= isset($bites['Cat']) ? htmlspecialchars($bites['Cat']) : 0 ?></td>
                            <td><?= isset($bites['Rat']) ? htmlspecialchars($bites['Rat']) : 0 ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="4">No data available for bites by gender and animal.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <h2 class="analytics-title">Analytics Charts</h2>
            <div class="analytics-row">
                <form class="analytics-form">
                    <h3>Bitten By :</h3>
                    <canvas id="pieChart1" width="300" height="300"></canvas>
                </form>

                <form class="analytics-form">
                    <h3>Sex</h3>
                    <canvas id="pieChart2" width="300" height="300"></canvas>
                </form>
            </div>
            <div class="analytics-row">
                <form class="analytics-form">
                    <h3>Vaccine Used :</h3>
                    <canvas id="pieChart3" width="300" height="300"></canvas>
                </form>

                <form class="analytics-form">
                    <h3>Route of Administration :</h3>
                    <canvas id="pieChart4" width="300" height="300"></canvas>
                </form>
            </div>
            <div class="analytics-row">
                <form class="analytics-form">
                    <h3>Brand Name Used :</h3>
                    <canvas id="pieChart5" width="300" height="300"></canvas>
                </form>
            </div>
        </div>
    </div>

    <script src="js/admin_scripts.js"></script>
    <script>
    function toggleMenu() {
        document.body.classList.toggle("menu-open");
    }

    // Function to create a pie chart with better colors
    function createPieChart(canvasId, data, title) {
        var ctx = document.getElementById(canvasId).getContext('2d');
        var labels = Object.keys(data);
        var counts = Object.values(data);
        var backgroundColors = [
            '#264653', '#2a9d8f', '#e9c46a', '#f4a261', '#e76f51', // Earthy tones
            '#0077b6', '#00b4d8', '#90e0ef', '#48cae4', '#f72585', // Modern blues and pink
            '#1e3a8a', '#3b82f6', '#60a5fa', '#a78bfa', '#d8b4fe' // Shades of indigo
        ];
        const colorPalette = backgroundColors.slice(0, labels.length);

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: counts,
                    backgroundColor: colorPalette,
                    borderWidth: 1,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 12
                            },
                            color: '#333'
                        }
                    },
                    title: {
                        display: true,
                        text: title,
                        font: {
                            size: 16
                        },
                        color: '#333',
                        padding: {
                            bottom: 10
                        }
                    }
                }
            }
        });
    }

    // Create Pie Chart 1 (Bitten By)
    var bittenByData = <?php echo json_encode($bitten_by_data); ?>;
    createPieChart('pieChart1', bittenByData, 'Patient Bites by Animal');

    // Create Pie Chart 2 (Sex)
    var sexData = <?php echo json_encode($sex_data); ?>;
    createPieChart('pieChart2', sexData, 'Patient Gender Distribution');

    // Create Pie Chart 3 (Vaccine Used)
    var vaccineData = <?php echo json_encode($vaccine_data); ?>;
    createPieChart('pieChart3', vaccineData, 'Vaccine Used');

    // Create Pie Chart 4 (Route of Administration)
    var routeData = <?php echo json_encode($route_data); ?>;
    createPieChart('pieChart4', routeData, 'Route of Administration');

    // Create Pie Chart 5 (Brand Name Used)
    var brandNameData = <?php echo json_encode($brand_name_data); ?>;
    createPieChart('pieChart5', brandNameData, 'Brand Name Used');
    </script>
</body>

</html>