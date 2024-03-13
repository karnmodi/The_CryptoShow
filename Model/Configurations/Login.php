<?php
session_start();
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['Email']) && isset($_POST['Password'])) {
        $Email = $_POST['Email'];
        $Password = $_POST['Password'];

        require_once('db.php');

        function loginUser($con, $Email, $Password) {
            $sql = "SELECT * FROM member WHERE Email = '$Email' AND Password = '$Password'";
            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Fetch Member ID from the database
                $row = mysqli_fetch_assoc($result);
                $MemberID = $row['MemberID'];
                $Name = $row['Name'];
                $_SESSION['user_name'] = $Name;
                return $MemberID;
            } else {
                return false;
            }
        }

        function insertLoginHistory($con, $MemberID) {
            // Insert login history
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
            $MemberID = loginUser($con, $Email, $Password);
            if ($MemberID) {
                if (insertLoginHistory($con, $MemberID)) {
                    $response['success'] = true;
                    $response['message'] = "Login Successful";
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
