<?php
require_once("../../../Model/Configurations/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['member']) && isset($_POST['password'])) {
        $member_id = $_POST['member'];
        $Password = $_POST['password'];
  

        $sql = "UPDATE member SET Password=? WHERE MemberID=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $Password, $member_id);

        if ($stmt->execute()) {
            echo "<script>alert('Record updated successfully');</script>";
        } else {
            echo "<script>alert('Error updating record: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('One or more form fields are not set');</script>";
    }
} else {
    echo "<script>alert('Invalid request method');</script>";
}
?>
