<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    // Redirect if user is not logged in
    header('Location: ../index.php');
    exit;
}
// Database connection
require_once("../../../Model/Configurations/db.php");

if (isset($_POST['eventId'], $_POST['newStatus'])) {
    $eventId = mysqli_real_escape_string($con, $_POST['eventId']);
    $newStatus = mysqli_real_escape_string($con, $_POST['newStatus']);

    $updateStatusQuery = "UPDATE Events SET EventStatus = '$newStatus' WHERE EventID = $eventId";

    if (mysqli_query($con, $updateStatusQuery)) {
        echo '<script>window.location.reload();</script>';
    } else {
        echo "Error updating event status: " . mysqli_error($con);
    }
} else {
    echo "Error: Missing parameters";
}
?>
