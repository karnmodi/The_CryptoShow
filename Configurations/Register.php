<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $Name = $_POST['Name'];
        $Email = $_POST['Email'];
        $Password = $_POST['Password'];

        $con = new mysqli('localhost', 'root', '', 'the_Cryptoshow');
        if ($con) {
            //echo "Connection successful";
            $sql = "INSERT INTO users (Name, Email, Password) VALUES ('$Name', '$Email', '$Password')";

            $result = mysqli_query($con, $sql);
            if ($result) {
                echo "Data inserted successfully";
            } else {
                die(mysqli_error($con));
            }
        } else {
            die(mysqli_error($con));
        }


    
}
?>