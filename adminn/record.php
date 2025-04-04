<?php
session_start();
if (!isset($_SESSION['admin_auth']) || $_SESSION['admin_auth'] !== true) {
    header("Location: ../tresspass/notresspass.php");
    exit();
}

require '../tresspass/connection.php';

// Vaccination Data
$sqlVaccination = "SELECT v.*, p.fname, p.lname, p.age, p.gender, p.cnumber FROM vaccination_data v INNER JOIN patient p ON v.user_id = p.user_id";
$resultVaccination = $conn->query($sqlVaccination);
$vaccinations = [];
if ($resultVaccination && $resultVaccination->num_rows > 0) {
    while ($row = $resultVaccination->fetch_assoc()) {
        $vaccinations[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Vaccinations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="adminstyle.css">
    <style>
    .content {
        transition: margin-left 0.3s ease;
        padding: 30px;
        background-color: #f4f4f4;
        min-height: 100vh;
    }

    .content h2 {
        margin-bottom: 25px;
        color: #333;
        border-bottom: 2px solid #007bff;
        padding-bottom: 15px;
        text-align: left;
    }

    .content table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow-x: auto;
    }

    .content th,
    .content td {
        border: 1px solid #ddd;
        padding: 15px;
        text-align: left;
        white-space: nowrap;
    }

    .content th {
        background-color: #007bff;
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.9em;
    }

    .content tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .content .action-buttons {
        display: flex;
        justify-content: center;
    }

    .content .action-buttons a {
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 5px;
        background-color: #28a745;
        color: white;
        font-size: 0.9em;
        margin: 0 5px;
        transition: background-color 0.3s ease;
    }

    .content .action-buttons a:hover {
        background-color: #218838;
    }

    .menu-open .content {
        margin-left: 260px;
    }
    </style>
</head>

<body>
    <?php include '../includes/admin_sidebar.php'; ?>
    <?php include '../includes/admin_header.php'; ?>

    <div class="content">
        <h2>Patient's Data</h2>
        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Contact Number</th>
                    <th>Bitten By</th>
                    <th>Date Exposure</th>
                    <th>Date Treatment</th>
                    <th>Vaccine</th>
                    <th>Brand Name</th>
                    <th>Route</th>
                    <th>D0 Date</th>
                    <th>D0 Site</th>
                    <th>D0 Given</th>
                    <th>D3 Date</th>
                    <th>D3 Site</th>
                    <th>D3 Given</th>
                    <th>D7 Date</th>
                    <th>D7 Site</th>
                    <th>D7 Given</th>
                    <th>D14 Date</th>
                    <th>D14 Site</th>
                    <th>D14 Given</th>
                    <th>D28 Date</th>
                    <th>D28 Site</th>
                    <th>D28 Given</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vaccinations as $vaccination) : ?>
                <tr>
                    <td><?= $vaccination['fname'] ?></td>
                    <td><?= $vaccination['lname'] ?></td>
                    <td><?= $vaccination['age'] ?></td>
                    <td><?= $vaccination['gender'] ?></td>
                    <td><?= $vaccination['cnumber'] ?></td>
                    <td><?= $vaccination['bitten_by'] ?></td>
                    <td><?= $vaccination['date_exposure'] ?></td>
                    <td><?= $vaccination['date_treatment'] ?></td>
                    <td><?= $vaccination['vaccine'] ?></td>
                    <td><?= $vaccination['brand_name'] ?></td>
                    <td><?= $vaccination['route'] ?></td>
                    <td><?= $vaccination['D0_date'] ?></td>
                    <td><?= $vaccination['D0_site'] ?></td>
                    <td><?= $vaccination['D0_given'] ?></td>
                    <td><?= $vaccination['D3_date'] ?></td>
                    <td><?= $vaccination['D3_site'] ?></td>
                    <td><?= $vaccination['D3_given'] ?></td>
                    <td><?= $vaccination['D7_date'] ?></td>
                    <td><?= $vaccination['D7_site'] ?></td>
                    <td><?= $vaccination['D7_given'] ?></td>
                    <td><?= $vaccination['D14_date'] ?></td>
                    <td><?= $vaccination['D14_site'] ?></td>
                    <td><?= $vaccination['D14_given'] ?></td>
                    <td><?= $vaccination['D28_date'] ?></td>
                    <td><?= $vaccination['D28_site'] ?></td>
                    <td><?= $vaccination['D28_given'] ?></td>
                    <td class="action-buttons">
                        <a href="update_vaccination.php?id=<?= $vaccination['id'] ?>">Update</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
    function toggleMenu() {
        document.body.classList.toggle("menu-open");
    }
    </script>
</body>

</html>