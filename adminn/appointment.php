<?php
session_start();
if (!isset($_SESSION['admin_auth']) || $_SESSION['admin_auth'] !== true) {
    header("Location: ../tresspass/notresspass.php"); // Redirect to login page if not authenticated
    exit();
}

require '../tresspass/connection.php'; // Database connection details

// Fetch all appointments with patient details
$sql = "SELECT
            p.fname,
            p.lname,
            p.age,
            p.gender,
            p.cnumber,
            a.appointment_num,
            DATE_FORMAT(a.appointment_date, '%M %d, %Y') AS appointment_date_formatted
        FROM appointment a
        INNER JOIN patient p ON a.user_id = p.user_id
        ORDER BY a.appointment_date DESC";
$result = $conn->query($sql);
$appointments = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Appointments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="adminstyle.css">
</head>

<body>
    <?php include '../includes/admin_sidebar.php'; ?>
    <?php include '../includes/admin_header.php'; ?>
    <div class="content-wrapper appointments-page">
        <h1><i class="fa-solid fa-calendar-days"></i> Patient's Appointments</h1>

        <div class="appointments-table-container">
            <?php if (!empty($appointments)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Contact Number</th>
                        <th>Appointment Number</th>
                        <th>Appointment Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($appointment['fname'] . ' ' . $appointment['lname']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['age']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['gender']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['cnumber']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['appointment_num']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['appointment_date_formatted']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p class="no-appointments">No appointments found.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
<script>
function toggleMenu() {
    document.body.classList.toggle("menu-open");
}
</script>

</html>