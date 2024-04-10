<?php
session_start();
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Email']) && isset($_POST['Password'])) {
        $Email = $_POST['Email'];
        $Password = $_POST['Password'];

        require_once('db.php');

        function loginUser($con, $Email, $Password)
        {
            $sql = "SELECT * FROM member WHERE Email = '$Email' AND Password = '$Password'";
            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $MemberID = $row['MemberID'];
                $Name = $row['Name'];
                $UserType = $row['UserType'];

                $_SESSION['user_name'] = $Name;
                $_SESSION['user_type'] = $UserType;
                $_SESSION['member_id'] = $MemberID; 

                return $UserType;
            } else {
                return false;
            }
        }

        function insertLoginHistory($con, $MemberID)
        {
            date_default_timezone_set('Europe/London');

            $currentDateTime = date('Y-m-d H:i:s');
            $insertQuery = "INSERT INTO loginhistory (MemberID, LoginDT) VALUES ('$MemberID', '$currentDateTime')";
            $insertResult = mysqli_query($con, $insertQuery);

            if ($insertResult) {
                return true;
            } else {
                return false;
            }
        }

        if ($con) {
            $UserType = loginUser($con, $Email, $Password);
            if ($UserType) {
                if (insertLoginHistory($con, $_SESSION['member_id'])) {
                    $response['success'] = true;
                    $response['message'] = "Login Successful $UserType!!" ;
                    $response['user_type'] = $UserType; 
                } else {
                    $response['success'] = false;
                    $response['message'] = "Failed to insert login history";
                }
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

