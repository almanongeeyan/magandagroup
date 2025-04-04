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
    <link rel="stylesheet" href="adminn.css">
    <style>
    .content {
        transition: margin-left 0.3s ease;
        padding: 30px;
        background-color: #f4f6f9;
        /* Light grey background */
        min-height: 100vh;
    }

    .content h2 {
        margin-bottom: 30px;
        color: #343a40;
        /* Dark grey heading */
        border-bottom: 3px solid #007bff;
        /* Blue accent */
        padding-bottom: 15px;
        text-align: left;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .content table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        /* Softer shadow */
        border-radius: 8px;
        overflow: hidden;
        /* Ensures rounded corners for the table */
        min-width: 1500px;
        /* Adjust as needed to prevent horizontal scroll for smaller datasets */
    }

    .content th,
    .content td {
        border: 1px solid #dee2e6;
        /* Light grey border */
        padding: 12px 15px;
        text-align: left;
        white-space: nowrap;
        font-size: 0.9rem;
    }

    .content th {
        background-color: #007bff;
        color: white;
        font-weight: 500;
        text-transform: uppercase;
    }

    .content tbody tr:nth-child(even) {
        background-color: #f8f9fa;
        /* Very light grey for even rows */
    }

    .content tbody tr:hover {
        background-color: #e9ecef;
        /* Slightly darker hover effect */
    }

    .content .action-buttons {
        display: flex;
        justify-content: center;
    }

    .content .action-buttons a {
        padding: 8px 12px;
        text-decoration: none;
        border-radius: 5px;
        background-color: #28a745;
        /* Green update button */
        color: white;
        font-size: 0.85rem;
        margin: 0 5px;
        transition: background-color 0.3s ease;
    }

    .content .action-buttons a:hover {
        background-color: #218838;
    }

    .menu-open .content {
        margin-left: 260px;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .content {
            padding: 20px;
        }

        .content h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .content th,
        .content td {
            padding: 10px;
            font-size: 0.8rem;
        }

        .content .action-buttons a {
            padding: 6px 10px;
            font-size: 0.75rem;
        }
    }
    </style>
</head>

<body>
    <?php include '../includes/admin_sidebar.php'; ?>
    <?php include '../includes/admin_header.php'; ?>

    <div class="content">
        <h2>Patient Vaccination Data</h2>
        <div class="table-responsive">
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
                        <td><?= htmlspecialchars($vaccination['fname']) ?></td>
                        <td><?= htmlspecialchars($vaccination['lname']) ?></td>
                        <td><?= htmlspecialchars($vaccination['age']) ?></td>
                        <td><?= htmlspecialchars($vaccination['gender']) ?></td>
                        <td><?= htmlspecialchars($vaccination['cnumber']) ?></td>
                        <td><?= htmlspecialchars($vaccination['bitten_by']) ?></td>
                        <td><?= htmlspecialchars($vaccination['date_exposure']) ?></td>
                        <td><?= htmlspecialchars($vaccination['date_treatment']) ?></td>
                        <td><?= htmlspecialchars($vaccination['vaccine']) ?></td>
                        <td><?= htmlspecialchars($vaccination['brand_name']) ?></td>
                        <td><?= htmlspecialchars($vaccination['route']) ?></td>
                        <td><?= htmlspecialchars($vaccination['D0_date']) ?></td>
                        <td><?= htmlspecialchars($vaccination['D0_site']) ?></td>
                        <td><?= htmlspecialchars($vaccination['D0_given']) ?></td>
                        <td><?= htmlspecialchars($vaccination['D3_date']) ?></td>
                        <td><?= htmlspecialchars($vaccination['D3_site']) ?></td>
                        <td><?= htmlspecialchars($vaccination['D3_given']) ?></td>
                        <td><?= htmlspecialchars($vaccination['D7_date']) ?></td>
                        <td><?= htmlspecialchars($vaccination['D7_site']) ?></td>
                        <td><?= htmlspecialchars($vaccination['D7_given']) ?></td>
                        <td><?= htmlspecialchars($vaccination['D14_date']) ?></td>
                        <td><?= htmlspecialchars($vaccination['D14_site']) ?></td>
                        <td><?= htmlspecialchars($vaccination['D14_given']) ?></td>
                        <td><?= htmlspecialchars($vaccination['D28_date']) ?></td>
                        <td><?= htmlspecialchars($vaccination['D28_site']) ?></td>
                        <td><?= htmlspecialchars($vaccination['D28_given']) ?></td>
                        <td class="action-buttons">
                            <a href="update_vaccination.php?id=<?= $vaccination['id'] ?>">Update</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


    <script>
    function toggleMenu() {
        document.body.classList.toggle("menu-open");
    }
    </script>
</body>

</html>