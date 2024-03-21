<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header('Location: ../../../index.php');
    exit;
}

require_once("../../../Model/Configurations/db.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the member ID and updated details from the form
    $memberID = $_POST['member_id'];
    $newName = $_POST['Name'];
    $newPassword = $_POST['Password'];
    
    // Update query
    $updateQuery = "UPDATE member SET Name = '$newName', Password = '$newPassword' WHERE MemberID = $memberID";
    
    // Perform the update
    if (mysqli_query($con, $updateQuery)) {
        echo "Update Sucessfully";
    } else {
        echo "Error updating member details: " . mysqli_error($con);
    }
}
?>
