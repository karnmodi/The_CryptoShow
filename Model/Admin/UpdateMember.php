<?php

require_once("../Configurations/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_member_id = $_POST['selected-member-Id'];
    $selected_member_name = $_POST['selected-member-Name'];
    $selected_member_email = $_POST['selected-member-Email'];
    $selected_member_password = $_POST['selected-member-Password'];
    $selected_member_user_type = $_POST['selected-member-UserType'];

    $sql = "UPDATE members SET 
            name = '$selected_member_name', 
            email = '$selected_member_email', 
            password = '$selected_member_password', 
            user_type = '$selected_member_user_type' 
            WHERE id = $selected_member_id";

    if (mysqli_query($con, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}
?>