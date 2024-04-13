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
       
        $_SESSION['message'] = 'Member Added Successfully.';
        header('Location: ../../../View/Home.php#membersContnet');
    } else {
       
        $_SESSION['message']  = "Error:"  . "$stmt->error";
    }

    $stmt->close();
    $con->close();
} else {

    $_SESSION['message']  = "Invalid Request";
}
?>
