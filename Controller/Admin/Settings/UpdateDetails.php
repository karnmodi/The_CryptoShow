<?php
require_once("../../../Model/Configurations/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['memberid']) && isset($_POST['name']) && isset($_POST['email'])) {
        $MemberID = $_POST['memberid'];
        $Name = $_POST['name'];
        $Email= $_POST['email'];
        $Password = $_POST['password'];


        $sql = "UPDATE member SET Name=?, Email=?, Password=? WHERE MemberID=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssss", $Name, $Email, $Password, $MemberID);

        if ($stmt->execute()) {
            header("location: ../../../View\Home.php#settingsContent");
        } else {
            $_SESSION['message'] = 'Profile Updation Unsuccessful';
            header("location: ../../../View\Home.php#settingsContent");
        }

        $stmt->close();
    } else {
        echo "<script>alert('One or more form fields are not set');</script>";
    }
} else {
    echo "<script>alert('Invalid request method');</script>";
    
}
?>
