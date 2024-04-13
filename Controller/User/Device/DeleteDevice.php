<?php
require_once("../../../Model/Configurations/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deviceId'])) {
    $deviceId = $_POST['deviceId'];

    $deleteDeviceAssociationsQuery = "DELETE FROM eventdevice WHERE DeviceID = ?";
    $stmtDeleteAssociations = $con->prepare($deleteDeviceAssociationsQuery);
    $stmtDeleteAssociations->bind_param("i", $deviceId);

    if ($stmtDeleteAssociations->execute()) {
        $deletedAssociations = $stmtDeleteAssociations->affected_rows;
        $stmtDeleteAssociations->close();

        $deleteDeviceQuery = "DELETE FROM Devices WHERE DeviceID = ?";
        $stmtDeleteDevice = $con->prepare($deleteDeviceQuery);
        $stmtDeleteDevice->bind_param("i", $deviceId);

        if ($stmtDeleteDevice->execute()) {
            $deletedDevice = $stmtDeleteDevice->affected_rows;
            $stmtDeleteDevice->close();

            if ($deletedDevice > 0 || $deletedAssociations > 0) {
                echo "Device and associated records deleted successfully.";
            } else {
                echo "No records deleted.";
            }
        } else {
            echo "Error deleting device: " . $stmtDeleteDevice->error;
        }
    } else {
        echo "Error deleting device associations: " . $stmtDeleteAssociations->error;
    }

    $con->close();
} else {
    echo "Device ID not provided or invalid request.";
}
?>
