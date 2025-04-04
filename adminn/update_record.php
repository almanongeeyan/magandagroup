<?php
session_start();
if (!isset($_SESSION['admin_auth']) || $_SESSION['admin_auth'] !== true) {
    header("Location: ../tresspass/notresspass.php");
    exit();
}

require '../tresspass/connection.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $vaccination_id = $_GET['id'];

    $sql = "SELECT v.*, p.fname, p.lname, p.age, p.gender, p.cnumber
            FROM vaccination_data v
            INNER JOIN patient p ON v.user_id = p.user_id
            WHERE v.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vaccination_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $vaccination = $result->fetch_assoc();
    } else {
        header("Location: record.php");
        exit();
    }
    $stmt->close();
} else {
    header("Location: record.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Update Vaccination</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="adminn.css">
    <link rel="stylesheet" href="record.css">
</head>

<body>
    <?php include '../includes/admin_sidebar.php'; ?>
    <?php include '../includes/admin_header.php'; ?>

    <div class="content">
        <h2>Update Patient Vaccination Data</h2>
        <div class="form-container">
            <div>
                <h3>Patient Information</h3>
                <div class="form-group">
                    <label for="fname">First Name:</label>
                    <input type="text" id="fname" name="fname" value="<?= htmlspecialchars($vaccination['fname']) ?>"
                        readonly>
                </div>
                <div class="form-group">
                    <label for="lname">Last Name:</label>
                    <input type="text" id="lname" name="lname" value="<?= htmlspecialchars($vaccination['lname']) ?>"
                        readonly>
                </div>
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="text" id="age" name="age" value="<?= htmlspecialchars($vaccination['age']) ?>"
                        readonly>
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <input type="text" id="gender" name="gender" value="<?= htmlspecialchars($vaccination['gender']) ?>"
                        readonly>
                </div>
                <div class="form-group">
                    <label for="cnumber">Contact Number:</label>
                    <input type="text" id="cnumber" name="cnumber"
                        value="<?= htmlspecialchars($vaccination['cnumber']) ?>" readonly>
                </div>

                <h3>Vaccination Details</h3>
                <div class="form-group">
                    <label for="bitten_by">Bitten By:</label>
                    <input type="text" id="bitten_by" name="bitten_by"
                        value="<?= htmlspecialchars($vaccination['bitten_by']) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="date_exposure">Date of Exposure:</label>
                    <input type="date" id="date_exposure" name="date_exposure"
                        value="<?= htmlspecialchars($vaccination['date_exposure']) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="date_treatment">Date of Treatment:</label>
                    <input type="date" id="date_treatment" name="date_treatment"
                        value="<?= htmlspecialchars($vaccination['date_treatment']) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="vaccine">Vaccine:</label>
                    <input type="text" id="vaccine" name="vaccine"
                        value="<?= htmlspecialchars($vaccination['vaccine']) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="brand_name">Brand Name:</label>
                    <input type="text" id="brand_name" name="brand_name"
                        value="<?= htmlspecialchars($vaccination['brand_name']) ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="route">Route:</label>
                    <input type="text" id="route" name="route" value="<?= htmlspecialchars($vaccination['route']) ?>"
                        readonly>
                </div>
            </div>

            <div class="vaccination-schedule">
                <h3>Vaccination Schedule</h3>
                <form action="update_function.php" method="post">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($vaccination['id']) ?>">
                    <div class="form-group">
                        <label for="D0_date">D0 Date:</label>
                        <input type="date" id="D0_date" name="D0_date"
                            value="<?= htmlspecialchars($vaccination['D0_date']) ?>" min="<?= date('Y-m-d') ?>"
                            <?php if (!empty($vaccination['D0_date']) && $vaccination['D0_date'] !== '0000-00-00') echo 'disabled'; ?>>
                        <input type="hidden" name="D0_date_hidden"
                            value="<?= htmlspecialchars($vaccination['D0_date']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="D0_site">D0 Site:</label>
                        <input type="text" id="D0_site" name="D0_site"
                            value="<?= htmlspecialchars($vaccination['D0_site']) ?>"
                            <?php if (!empty($vaccination['D0_site'])) echo 'disabled'; ?>>
                        <input type="hidden" name="D0_site_hidden"
                            value="<?= htmlspecialchars($vaccination['D0_site']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="D0_given">D0 Given:</label>
                        <input type="text" id="D0_given" name="D0_given"
                            value="<?= htmlspecialchars($vaccination['D0_given']) ?>"
                            <?php if (!empty($vaccination['D0_given'])) echo 'readonly'; ?>>
                        <input type="hidden" name="D0_given_hidden"
                            value="<?= htmlspecialchars($vaccination['D0_given']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="D3_date">D3 Date:</label>
                        <input type="date" id="D3_date" name="D3_date"
                            value="<?= htmlspecialchars($vaccination['D3_date']) ?>" min="<?= date('Y-m-d') ?>"
                            <?php if (!empty($vaccination['D3_date']) && $vaccination['D3_date'] !== '0000-00-00') echo 'disabled'; ?>>
                        <input type="hidden" name="D3_date_hidden"
                            value="<?= htmlspecialchars($vaccination['D3_date']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="D3_site">D3 Site:</label>
                        <input type="text" id="D3_site" name="D3_site"
                            value="<?= htmlspecialchars($vaccination['D3_site']) ?>"
                            <?php if (!empty($vaccination['D3_site'])) echo 'disabled'; ?>>
                        <input type="hidden" name="D3_site_hidden"
                            value="<?= htmlspecialchars($vaccination['D3_site']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="D3_given">D3 Given:</label>
                        <input type="text" id="D3_given" name="D3_given"
                            value="<?= htmlspecialchars($vaccination['D3_given']) ?>"
                            <?php if (!empty($vaccination['D3_given'])) echo 'readonly'; ?>>
                        <input type="hidden" name="D3_given_hidden"
                            value="<?= htmlspecialchars($vaccination['D3_given']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="D7_date">D7 Date:</label>
                        <input type="date" id="D7_date" name="D7_date"
                            value="<?= htmlspecialchars($vaccination['D7_date']) ?>" min="<?= date('Y-m-d') ?>"
                            <?php if (!empty($vaccination['D7_date']) && $vaccination['D7_date'] !== '0000-00-00') echo 'disabled'; ?>>
                        <input type="hidden" name="D7_date_hidden"
                            value="<?= htmlspecialchars($vaccination['D7_date']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="D7_site">D7 Site:</label>
                        <input type="text" id="D7_site" name="D7_site"
                            value="<?= htmlspecialchars($vaccination['D7_site']) ?>"
                            <?php if (!empty($vaccination['D7_site'])) echo 'disabled'; ?>>
                        <input type="hidden" name="D7_site_hidden"
                            value="<?= htmlspecialchars($vaccination['D7_site']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="D7_given">D7 Given:</label>
                        <input type="text" id="D7_given" name="D7_given"
                            value="<?= htmlspecialchars($vaccination['D7_given']) ?>"
                            <?php if (!empty($vaccination['D7_given'])) echo 'readonly'; ?>>
                        <input type="hidden" name="D7_given_hidden"
                            value="<?= htmlspecialchars($vaccination['D7_given']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="D14_date">D14 Date:</label>
                        <input type="date" id="D14_date" name="D14_date"
                            value="<?= htmlspecialchars($vaccination['D14_date']) ?>" min="<?= date('Y-m-d') ?>"
                            <?php if (!empty($vaccination['D14_date']) && $vaccination['D14_date'] !== '0000-00-00') echo 'disabled'; ?>>
                        <input type="hidden" name="D14_date_hidden"
                            value="<?= htmlspecialchars($vaccination['D14_date']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="D14_site">D14 Site:</label>
                        <input type="text" id="D14_site" name="D14_site"
                            value="<?= htmlspecialchars($vaccination['D14_site']) ?>"
                            <?php if (!empty($vaccination['D14_site'])) echo 'disabled'; ?>>
                        <input type="hidden" name="D14_site_hidden"
                            value="<?= htmlspecialchars($vaccination['D14_site']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="D14_given">D14 Given:</label>
                        <input type="text" id="D14_given" name="D14_given"
                            value="<?= htmlspecialchars($vaccination['D14_given']) ?>"
                            <?php if (!empty($vaccination['D14_given'])) echo 'readonly'; ?>>
                        <input type="hidden" name="D14_given_hidden"
                            value="<?= htmlspecialchars($vaccination['D14_given']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="D28_date">D28 Date:</label>
                        <input type="date" id="D28_date" name="D28_date"
                            value="<?= htmlspecialchars($vaccination['D28_date']) ?>" min="<?= date('Y-m-d') ?>"
                            <?php if (!empty($vaccination['D28_date']) && $vaccination['D28_date'] !== '0000-00-00') echo 'disabled'; ?>>
                        <input type="hidden" name="D28_date_hidden"
                            value="<?= htmlspecialchars($vaccination['D28_date']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="D28_site">D28 Site:</label>
                        <input type="text" id="D28_site" name="D28_site"
                            value="<?= htmlspecialchars($vaccination['D28_site']) ?>"
                            <?php if (!empty($vaccination['D28_site'])) echo 'disabled'; ?>>
                        <input type="hidden" name="D28_site_hidden"
                            value="<?= htmlspecialchars($vaccination['D28_site']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="D28_given">D28 Given:</label>
                        <input type="text" id="D28_given" name="D28_given"
                            value="<?= htmlspecialchars($vaccination['D28_given']) ?>"
                            <?php if (!empty($vaccination['D28_given'])) echo 'readonly'; ?>>
                        <input type="hidden" name="D28_given_hidden"
                            value="<?= htmlspecialchars($vaccination['D28_given']) ?>">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Update Record</button>
                        <a href="record.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function toggleMenu() {
        document.body.classList.toggle("menu-open");
    }
    </script>
</body>

</html>