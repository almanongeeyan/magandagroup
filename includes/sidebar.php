<?php
require 'connection.php';

if (!isset($_SESSION)) {
session_start();
}

if (!isset($_SESSION['email'])) {
header("Location: login.php");
exit();
}

$email = $_SESSION['email'];


$sqlQuery = "SELECT * FROM `patient` WHERE email = ?";
$stmt = $conn->prepare($sqlQuery);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<div class="sidebar" id="mySidebar">
    <div class="side-header">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"></a>
        <br>
        <h3 class="sidebartext">UCC JOB BOARD SYSTEM</h3>


        <h5 style="margin-top:8px; text-align: left;">
            <?php
 if ($user) {
echo htmlspecialchars($user['email']);
 }
?>
        </h5>

    </div>

    <hr style="border:1px solid; background-color:black; border-color:#3B3131;">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">x</a>
    <a href="./index.php"><i class="fa fa-home"></i> Dashboard</a>
    <a href="./inquiry.php" onclick="showJob()"><i class="fa fa-users"></i> Job Inquiry</a>
    <a href="./student-profile.php"><i class="fa fa-th-large"></i> Profile</a>
    <br><br><br><br>
    <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a>
</div>

<div id="main">
    <button class="openbtn" onclick="openNav()"><i class="fa fa-bars"></i></button>
</div>

<script>
function openNav() {
    document.getElementById("mySidebar").style.width = "250px"; // Set the sidebar width to 250px
    document.getElementById("main").style.marginLeft = "250px"; // Adjust the main content area
}


function closeNav() {
    document.getElementById("mySidebar").style.width = "0"; // Set the sidebar width to 0 to hide it
    document.getElementById("main").style.marginLeft = "0"; // Reset the main content area margin
}
</script>