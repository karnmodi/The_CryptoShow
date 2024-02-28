<?php
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['Email']) && isset($_POST['Password'])) {
        $Email = $_POST['Email'];
        $Password = $_POST['Password'];

        $con = new mysqli("localhost", "root", "", "The_Cryptoshow");

        if ($con) {
            $sql = "SELECT * FROM users WHERE Email = '$Email' AND Password = '$Password'";
            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
                $response['success'] = true;
                $response['message'] = "Login Successful";
            } else {
                $response['success'] = false;
                $response['message'] = "Invalid Email or Password";
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Database connection error";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Missing email or password";
    }
} else {
    $response['success'] = false;
    $response['message'] = "Invalid request method";
}

// Send the JSON response
echo json_encode($response);
?>
