<?php

require_once("../../../Model/Configurations/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['memberid']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['usertype'])) {
        $selected_member_id = $_POST['memberid'];
        $selected_member_name = $_POST['name'];
        $selected_member_email = $_POST['email'];
        $selected_member_password = $_POST['password'];
        $selected_member_user_type = $_POST['usertype'];

        $sql = "UPDATE member SET Name=?, Email=?, Password=?, UserType=? WHERE MemberID=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssi", $selected_member_name, $selected_member_email, $selected_member_password, $selected_member_user_type, $selected_member_id);

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
