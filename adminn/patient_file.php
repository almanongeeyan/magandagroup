<?php
session_start();
if (!isset($_SESSION['admin_auth']) || $_SESSION['admin_auth'] !== true) {
    header("Location: ../tresspass/notresspass.php");
    exit();
}

require '../tresspass/connection.php';

if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Fetch patient information
    $sqlPatient = "SELECT fname, lname, age, gender, cnumber FROM patient WHERE user_id = ?";
    $stmtPatient = $conn->prepare($sqlPatient);
    $stmtPatient->bind_param("i", $userId);
    $stmtPatient->execute();
    $resultPatient = $stmtPatient->get_result();
    $patient = $resultPatient->fetch_assoc();
    $stmtPatient->close();

    if (!$patient) {
        echo "Patient not found.";
        exit();
    }
} else {
    echo "User ID not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient File</title>
    <link rel="stylesheet" href="appointment.css">
    <link rel="stylesheet" href="adminstyle.css">
    <link rel="stylesheet" href="patient_file.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    .content-wrapper {
        transition: margin-left 0.3s ease-in-out;
        position: relative;
        padding: 30px;
        left: 0;
        margin-top: 85px;
        padding-left: 20px;
        padding-right: 20px;
        z-index: 999;
    }

    .menu-open .content-wrapper {
        margin-left: 260px;
        /* Adjust based on your sidebar width */
    }

    .section-title {
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #007bff;
        color: #333;
        font-size: 1.5em;
        font-weight: bold;
        text-align: left;
    }

    .patient-info {
        text-align: left;
    }

    .patient-info p {
        margin-bottom: 8px;
        line-height: 1.6;
        color: #555;
    }

    .patient-info strong {
        font-weight: bold;
        color: #333;
        margin-right: 5px;
    }

    .vaccination-schedule {
        text-align: left;
    }

    .vaccination-schedule form>div {
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .vaccination-schedule form label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #555;
        text-align: left;
    }

    .vaccination-schedule form input[type="date"],
    .vaccination-schedule form input[type="text"],
    .vaccination-schedule form select {
        width: calc(100% - 12px);
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 0.9em;
        text-align: left;
    }

    /* Styles for all tables */
    .vaccination-schedule table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        background-color: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        /* Slightly stronger shadow */
        border-radius: 8px;
        /* More rounded corners */
        overflow: hidden;
        text-align: left;
        border: 1px solid #e0e0e0;
        /* Light gray border */
    }

    .vaccination-schedule table th {
        background-color: #007bff;
        /* Blue header */
        color: white;
        font-weight: bold;
        text-transform: uppercase;
        padding: 12px 15px;
        border-bottom: 2px solid #0056b3;
        /* Darker blue border */
        font-size: 0.95em;
    }

    .vaccination-schedule table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        font-size: 0.9em;
        color: #555;
    }

    .vaccination-schedule table tbody tr:last-child td {
        border-bottom: none;
        /* Remove border from the last row */
    }

    .vaccination-schedule table tbody tr:hover {
        background-color: #f9f9f9;
        /* Subtle hover effect */
    }

    .vaccination-schedule table tbody input[type="date"],
    .vaccination-schedule table tbody input[type="text"] {
        width: calc(100% - 16px);
        /* Adjust for padding */
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 0.9em;
        text-align: left;
    }

    .save-button-container {
        text-align: left;
        margin-top: 30px;
    }

    .save-button-container button {
        padding: 10px 20px;
        background-color: #007bff;
        /* Use a more formal primary color */
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1em;
        transition: background-color 0.3s ease;
    }

    .save-button-container button:hover {
        background-color: #0056b3;
    }
    </style>
</head>

<body>
    <?php include '../includes/admin_sidebar.php'; ?>
    <?php include '../includes/admin_header.php'; ?>
    <div class="content-wrapper">
        <div class="patient-file-container">
            <a href="appointment.php" class="back-button">Back</a>

            <div class="patient-info">
                <h2 class="section-title">Patient Information</h2>
                <p><strong>First Name:</strong> <?php echo htmlspecialchars($patient['fname']); ?></p>
                <p><strong>Last Name:</strong> <?php echo htmlspecialchars($patient['lname']); ?></p>
                <p><strong>Age:</strong> <?php echo htmlspecialchars($patient['age']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($patient['gender']); ?></p>
                <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($patient['cnumber']); ?></p>
            </div>

            <div class="vaccination-schedule">
                <h2 class="section-title">Vaccination Details</h2>
                <form action="save_vaccination_data.php" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">
                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 25px;">
                        <div>
                            <label for="date_exposure">Date of Exposure:</label>
                            <input type="date" id="date_exposure" name="date_exposure">
                        </div>
                        <div>
                            <label for="date_treatment">Date Treatment Started:</label>
                            <input type="date" id="date_treatment" name="date_treatment">
                        </div>
                        <div>
                            <label for="bitten_by">Bitten By:</label>
                            <select id="bitten_by" name="bitten_by">
                                <option value="">Select Animal</option>
                                <option value="Dog">Dog</option>
                                <option value="Cat">Cat</option>
                                <option value="Rat">Rat</option>
                            </select>
                        </div>
                        <div>
                            <label for="vaccine">Vaccine:</label>
                            <select id="vaccine" name="vaccine">
                                <option value="">Select Vaccine</option>
                                <option value="PCEC">PCEC</option>
                                <option value="PVRV">PVRV</option>
                            </select>
                        </div>
                        <div>
                            <label for="brand_name">Brand Name:</label>
                            <input type="text" id="brand_name" name="brand_name">
                        </div>
                        <div>
                            <label for="route">Route:</label>
                            <select id="route" name="route">
                                <option value="">Select Route</option>
                                <option value="Intradermal">Intradermal Regiment</option>
                                <option value="Intramuscular">Intramuscular Regimen</option>
                            </select>
                        </div>
                    </div>

                    <h3 class="section-title">Vaccination Schedule</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Schedule</th>
                                <th>Date Given</th>
                                <th>Site Given</th>
                                <th>Given By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>D0</td>
                                <td><input type="date" name="D0_date"></td>
                                <td><input type="text" name="D0_site"></td>
                                <td><input type="text" name="D0_given"></td>
                            </tr>
                            <tr>
                                <td>D3</td>
                                <td><input type="date" name="D3_date"></td>
                                <td><input type="text" name="D3_site"></td>
                                <td><input type="text" name="D3_given"></td>
                            </tr>
                            <tr>
                                <td>D7</td>
                                <td><input type="date" name="D7_date"></td>
                                <td><input type="text" name="D7_site"></td>
                                <td><input type="text" name="D7_given"></td>
                            </tr>
                            <tr>
                                <td>D14</td>
                                <td><input type="date" name="D14_date"></td>
                                <td><input type="text" name="D14_site"></td>
                                <td><input type="text" name="D14_given"></td>
                            </tr>
                            <tr>
                                <td>D28</td>
                                <td><input type="date" name="D28_date"></td>
                                <td><input type="text" name="D28_site"></td>
                                <td><input type="text" name="D28_given"></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="save-button-container">
                        <button type="submit">Save Vaccination Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format

        const dateInputs = document.querySelectorAll('input[type="date"]');

        dateInputs.forEach(input => {
            input.setAttribute('min', today); // Set the minimum date to today
        });
    });

    function toggleMenu() {
        document.body.classList.toggle("menu-open");
    }
    </script>
</body>

</html>