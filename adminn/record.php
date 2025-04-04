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
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .content {
        transition: margin-left 0.3s ease;
        padding: 30px;
        background-color: #fff;
        box-shadow: 0 0.15rem 0.5rem rgba(0, 0, 0, 0.05);
        border-radius: 8px;
        margin: 20px;
    }

    .content h2 {
        color: #333;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
        margin-bottom: 25px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .content table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        overflow: hidden;
    }

    .content th,
    .content td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #dee2e6;
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
    }

    .content tbody tr:hover {
        background-color: #e9ecef;
    }

    .content .action-buttons {
        display: flex;
        justify-content: center;
    }

    .content .action-buttons a {
        padding: 8px 12px;
        text-decoration: none;
        border-radius: 4px;
        background-color: #28a745;
        color: white;
        font-size: 0.85rem;
        margin: 0 5px;
        transition: background-color 0.3s ease;
        border: 1px solid transparent;
    }

    .content .action-buttons a:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .menu-open .content {
        margin-left: 260px;
    }

    .dose-given-yes {
        background-color: #d4edda !important;
        /* Light green */
        color: #155724 !important;
        /* Dark green */
        text-align: center;
    }

    .dose-given-no {
        background-color: #f8d7da !important;
        /* Light red */
        color: #721c24 !important;
        /* Dark red */
        text-align: center;
    }

    /* Responsive adjustments */
    @media (max-width: 1400px) {

        .content th,
        .content td {
            padding: 10px;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 1200px) {
        .content {
            padding: 20px;
            margin: 15px;
        }

        .content h2 {
            font-size: 1.75rem;
            margin-bottom: 20px;
            padding-bottom: 8px;
        }

        .content th,
        .content td {
            padding: 8px;
            font-size: 0.75rem;
        }

        .content .action-buttons a {
            padding: 5px 8px;
            font-size: 0.7rem;
        }
    }

    /* Specific column widths for better readability */
    .content th:nth-child(1),
    /* First Name */
    .content td:nth-child(1) {
        width: 80px;
        /* Adjust as needed */
    }

    .content th:nth-child(2),
    /* Last Name */
    .content td:nth-child(2) {
        width: 80px;
        /* Adjust as needed */
    }

    .content th:nth-child(6),
    /* Bitten By */
    .content td:nth-child(6) {
        width: 100px;
        /* Adjust as needed */
    }

    .content th:nth-child(7),
    /* Date Exposure */
    .content td:nth-child(7),
    .content th:nth-child(8),
    /* Date Treatment */
    .content td:nth-child(8) {
        width: 90px;
        /* Adjust as needed */
    }

    .content th:nth-child(9),
    /* Vaccine */
    .content td:nth-child(9),
    .content th:nth-child(10),
    /* Brand Name */
    .content td:nth-child(10),
    .content th:nth-child(11),
    /* Route */
    .content td:nth-child(11) {
        width: 100px;
        /* Adjust as needed */
    }

    .content th[colspan="2"],
    .content td[colspan="2"] {
        text-align: center;
    }

    .content th:nth-child(12),
    /* D0 Date */
    .content td:nth-child(12),
    .content th:nth-child(13),
    /* D0 Given */
    .content td:nth-child(13),
    .content th:nth-child(14),
    /* D3 Date */
    .content td:nth-child(14),
    .content th:nth-child(15),
    /* D3 Given */
    .content td:nth-child(15),
    .content th:nth-child(16),
    /* D7 Date */
    .content td:nth-child(16),
    .content th:nth-child(17),
    /* D7 Given */
    .content td:nth-child(17),
    .content th:nth-child(18),
    /* D14 Date */
    .content td:nth-child(18),
    .content th:nth-child(19),
    /* D14 Given */
    .content td:nth-child(19),
    .content th:nth-child(20),
    /* D28 Date */
    .content td:nth-child(20),
    .content th:nth-child(21),
    /* D28 Given */
    .content td:nth-child(21) {
        width: 70px;
        /* Adjust as needed */
    }

    .content th:nth-child(22),
    /* Actions */
    .content td:nth-child(22) {
        width: 80px;
        /* Adjust as needed */
        text-align: center;
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
                        <th colspan="2">D0</th>
                        <th colspan="2">D3</th>
                        <th colspan="2">D7</th>
                        <th colspan="2">D14</th>
                        <th colspan="2">D28</th>
                        <th>Actions</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Date</th>
                        <th>Given</th>
                        <th>Date</th>
                        <th>Given</th>
                        <th>Date</th>
                        <th>Given</th>
                        <th>Date</th>
                        <th>Given</th>
                        <th>Date</th>
                        <th>Given</th>
                        <th></th>
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
                        <td
                            class="<?= htmlspecialchars($vaccination['D0_given']) ? 'dose-given-yes' : 'dose-given-no' ?>">
                            <?= htmlspecialchars($vaccination['D0_given']) ? 'Yes' : 'No' ?>
                        </td>
                        <td><?= htmlspecialchars($vaccination['D3_date']) ?></td>
                        <td
                            class="<?= htmlspecialchars($vaccination['D3_given']) ? 'dose-given-yes' : 'dose-given-no' ?>">
                            <?= htmlspecialchars($vaccination['D3_given']) ? 'Yes' : 'No' ?>
                        </td>
                        <td><?= htmlspecialchars($vaccination['D7_date']) ?></td>
                        <td
                            class="<?= htmlspecialchars($vaccination['D7_given']) ? 'dose-given-yes' : 'dose-given-no' ?>">
                            <?= htmlspecialchars($vaccination['D7_given']) ? 'Yes' : 'No' ?>
                        </td>
                        <td><?= htmlspecialchars($vaccination['D14_date']) ?></td>
                        <td
                            class="<?= htmlspecialchars($vaccination['D14_given']) ? 'dose-given-yes' : 'dose-given-no' ?>">
                            <?= htmlspecialchars($vaccination['D14_given']) ? 'Yes' : 'No' ?>
                        </td>
                        <td><?= htmlspecialchars($vaccination['D28_date']) ?></td>
                        <td
                            class="<?= htmlspecialchars($vaccination['D28_given']) ? 'dose-given-yes' : 'dose-given-no' ?>">
                            <?= htmlspecialchars($vaccination['D28_given']) ? 'Yes' : 'No' ?>
                        </td>
                        <td class="action-buttons">
                            <a href="update_record.php?id=<?= $vaccination['id'] ?>">Update</a>
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