<?php
require_once("../../../Model/Configurations/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['memberid']) && isset($_POST['name']) && isset($_POST['email'])) {
        $member_id = $_POST['memberid'];
        $name = $_POST['name'];
        $email = $_POST['email'];

        $sql = "UPDATE member SET Name=?, Email=? WHERE MemberID=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $member_id);

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
