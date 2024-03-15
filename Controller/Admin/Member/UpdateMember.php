<?php

require_once("../../../Model/Configurations/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all form fields are set
    if(isset($_POST['memberid']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['usertype'])) {
        $selected_member_id = $_POST['memberid'];
        $selected_member_name = $_POST['name'];
        $selected_member_email = $_POST['email'];
        $selected_member_password = $_POST['password'];
        $selected_member_user_type = $_POST['usertype'];

        // Prepare and bind the SQL statement
        $sql = "UPDATE member SET Name=?, Email=?, Password=?, UserType=? WHERE MemberID=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssi", $selected_member_name, $selected_member_email, $selected_member_password, $selected_member_user_type, $selected_member_id);

        // Execute the SQL query
        if ($stmt->execute()) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        echo "One or more form fields are not set";
    }
} else {
    echo "Invalid request method";
}

?>
