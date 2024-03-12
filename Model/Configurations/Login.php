<?php
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['Email']) && isset($_POST['Password'])) {
        $Email = $_POST['Email'];
        $Password = $_POST['Password'];

        require_once('db.php');

        if ($con) {
            $sql = "SELECT * FROM member WHERE Email = '$Email' AND Password = '$Password'";
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

echo json_encode($response);
?>
