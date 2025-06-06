<?php
session_start();
if (!isset($_SESSION['admin_auth']) || $_SESSION['admin_auth'] !== true) {
    header("Location: ../tresspass/notresspass.php");
    exit();
}

require '../tresspass/connection.php';

$sql = "SELECT
    p.user_id,
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
    <link rel="stylesheet" href="adminn.css">
    <style>
    .appointments-page h1 {
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #ccc;
    }

    .appointments-table-container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        overflow-x: auto;
    }

    .appointments-table-container table {
        width: 100%;
        border-collapse: collapse;
    }

    .appointments-table-container th,
    .appointments-table-container td {
        padding: 12px 15px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    .appointments-table-container th {
        background-color: #3498db;
        /* Blue header */
        color: white;
        font-weight: bold;
    }

    .appointments-table-container tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .appointments-table-container tbody tr:hover {
        background-color: #eee;
    }

    .appointments-table-container .file-button,
    .appointments-table-container .delete-button {
        background-color: #4CAF50;
        /* Green for File */
        color: white;
        border: none;
        padding: 8px 12px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 5px;
        transition: background-color 0.3s ease;
    }

    .appointments-table-container .delete-button {
        background-color: #f44336;
        /* Red for Delete */
    }

    .appointments-table-container .file-button:hover {
        background-color: #45a049;
    }

    .appointments-table-container .delete-button:hover {
        background-color: #d32f2f;
    }

    .appointments-table-container .no-appointments {
        color: #777;
        font-style: italic;
    }

    .message-container {
        margin-bottom: 20px;
        padding: 15px;
        border-radius: 5px;
    }

    .success-message {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .danger-message {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    </style>
</head>

<body>
    <?php include '../includes/admin_sidebar.php'; ?>
    <?php include '../includes/admin_header.php'; ?>
    <div class="content-wrapper appointments-page">
        <h1><i class="fa-solid fa-calendar-days"></i> Patient's Appointments</h1>

        <?php if (isset($_SESSION['delete_message'])): ?>
        <div
            class="message-container <?php echo $_SESSION['message_type'] === 'success' ? 'success-message' : 'danger-message'; ?>">
            <?php echo $_SESSION['delete_message']; ?>
        </div>
        <?php unset($_SESSION['delete_message']); // Clear the message after displaying ?>
        <?php unset($_SESSION['message_type']); // Clear the message type ?>
        <?php endif; ?>

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
                        <th>Actions</th>
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
                        <td>
                            <a href="patient_file.php?user_id=<?php echo htmlspecialchars($appointment['user_id']); ?>"
                                class="file-button"><i class="fa-solid fa-file"></i> File</a>
                            <form style="display: inline;" action="delete_appointment.php" method="post"
                                onsubmit="return confirm('Are you sure you want to delete the appointment for <?php echo htmlspecialchars($appointment['fname'] . ' ' . $appointment['lname']); ?>?');">
                                <input type="hidden" name="user_id"
                                    value="<?php echo htmlspecialchars($appointment['user_id']); ?>">
                                <button type="submit" class="delete-button"><i class="fa-solid fa-trash"></i>
                                    Delete</button>
                            </form>
                        </td>
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