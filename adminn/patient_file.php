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
    <link rel="stylesheet" href="adminstylee.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <?php include '../includes/admin_sidebar.php'; ?>
    <?php include '../includes/admin_header.php'; ?>
    <div class="content-wrapper">
        <div class="patient-file-container">
            <a href="appointment.php" class="back-button"
                style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 20px;">Back</a>

            <div class="patient-info">
                <h2>Patient Info</h2>
                <p><strong>First Name:</strong> <?php echo htmlspecialchars($patient['fname']); ?></p>
                <p><strong>Last Name:</strong> <?php echo htmlspecialchars($patient['lname']); ?></p>
                <p><strong>Age:</strong> <?php echo htmlspecialchars($patient['age']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($patient['gender']); ?></p>
                <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($patient['cnumber']); ?></p>
                <form action="save_vaccination_data.php" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">
                    <p><strong>Date of Exposure:</strong> <input type="date" name="date_exposure"></p>
                    <p><strong>Date Treatment Started:</strong> <input type="date" name="date_treatment"></p>
                    <p>
                        <strong>Bitten By:</strong>
                        <select name="bitten_by">
                            <option value="">Select Animal</option>
                            <option value="Dog">Dog</option>
                            <option value="Cat">Cat</option>
                            <option value="Rat">Rat</option>
                        </select>
                    </p>
                    <p><strong>Vaccine:</strong>
                        <select name="vaccine">
                            <option value="">Select Vaccine</option>
                            <option value="PCEC">PCEC</option>
                            <option value="PVRV">PVRV</option>
                        </select>
                    </p>
                    <p><strong>Brand Name:</strong> <input type="text" name="brand_name"></p>
                    <p><strong>Route:</strong>
                        <select name="route">
                            <option value="">Select Route</option>
                            <option value="Intradermal">Intradermal Regiment</option>
                            <option value="Intramuscular">Intramuscular Regimen</option>
                        </select>
                    </p>
            </div>
            <div class="vaccination-schedule">
                <h2>Vaccination Schedule</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Date Schedule</th>
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
            </div>
            <button type="submit">Save Data</button>
            </form>
        </div>
    </div>
</body>
<script>
function toggleMenu() {
    document.body.classList.toggle("menu-open");
}
</script>

</html>