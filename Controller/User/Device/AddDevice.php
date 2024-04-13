<?php
session_start();

if (!isset($_SESSION['user_name']) || !isset($_SESSION['member_id'])) {
  header('Location: ../index.php');
  exit;
}

require_once("../../../Model/Configurations/db.php");

$loggedInMemberID = $_SESSION['member_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['newDeviceName']) && isset($_POST['newDeviceDescription'])) {
        $newDeviceName = $_POST['newDeviceName'];
        $newDeviceDescription = $_POST['newDeviceDescription'];
        $newDeviceEvents = isset($_POST['newDeviceEvents']) ? $_POST['newDeviceEvents'] : array();

        $insertDeviceQuery = "INSERT INTO Devices (DeviceName, Description, MemberID) VALUES (?, ?, ?)";
        $stmt = $con->prepare($insertDeviceQuery);
        $stmt->bind_param("ssi", $newDeviceName, $newDeviceDescription, $loggedInMemberID);
        $stmt->execute();

        $newDeviceId = $stmt->insert_id;

        if (!empty($newDeviceEvents)) {
            foreach ($newDeviceEvents as $eventId) {
                $insertDeviceEventQuery = "INSERT INTO eventDevice (DeviceID, EventID) VALUES (?, ?)";
                $stmt = $con->prepare($insertDeviceEventQuery);
                $stmt->bind_param("ii", $newDeviceId, $eventId);
                $stmt->execute();
            }
        }

        if (isset($_SERVER['HTTP_REFERER'])) {
            header("Location: ../../../View/User.php#devicesContent");
        } else {
            echo "Error: Unable to redirect to previous page.";
        }
        exit();
    } else {
        echo "Error: Required form fields are missing.";
    }
}
?>
