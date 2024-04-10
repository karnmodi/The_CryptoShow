<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    require_once("../../../Model/Configurations/db.php");

   
    $MemberName = $_POST['name'];
    $MemberEmail = $_POST['email'];
    $MemberPassword= $_POST['password'];
    $MemberUserType = $_POST['usertype'];

    $sql = "INSERT INTO member (Name, Email, Password, UserType) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssss", $MemberName, $MemberEmail, $MemberPassword, $MemberUserType);

   
    if ($stmt->execute()) {
       
        echo "<script>alert('Member registered successfully');</script>";
    } else {
       
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $con->close();
} else {

    echo "<script>alert('Invalid request');</script>";
}
?>
