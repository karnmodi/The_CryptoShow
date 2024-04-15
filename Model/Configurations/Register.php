<?php
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['Name']) && isset($_POST['Email']) && isset($_POST['Password'])) {
        $Name = $_POST['Name'];
        $Email = $_POST['Email'];
        $Password = $_POST['Password'];

        require_once('db.php');

        if ($con) {
            $checkEmailQuery = "SELECT COUNT(*) AS count FROM member WHERE Email = '$Email'";
            $checkEmailResult = mysqli_query($con, $checkEmailQuery);
            $emailCount = mysqli_fetch_assoc($checkEmailResult)['count'];

            if ($emailCount > 0) {
                $response['success'] = false;
                $response['message'] = "Email already exists. Please enter another one or try to login.";
            } else {
                $sql = "INSERT INTO member (Name, Email, Password, UserType) VALUES ('$Name', '$Email', '$Password', CASE
                WHEN LOWER(RIGHT(Email, LENGTH(Email) - INSTR(Email, '@'))) = 'cryptoshow.com' THEN 'admin'
                ELSE 'member'
                END)";
                $result = mysqli_query($con, $sql);
                if ($result) {
                    $response['success'] = true;
                    $response['message'] = "Registered Successfully!! Now Login with your Credentials.";
                } else {
                    $response['success'] = false;
                    $response['message'] = "Error: " . mysqli_error($con);
                }
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Connection error: " . mysqli_connect_error();
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Missing name, email, or password";
    }
} else {
    $response['success'] = false;
    $response['message'] = "Invalid request method";
}

echo json_encode($response);
?>
