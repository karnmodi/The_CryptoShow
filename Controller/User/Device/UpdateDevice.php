<?php
require_once ("../../../Model/Configurations/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['deviceId']) && isset($_POST['deviceName']) && isset($_POST['deviceDescriptionEdit'])) {
        $deviceId = $_POST['deviceId'];
        $deviceName = $_POST['deviceName'];
        $deviceDescription = $_POST['deviceDescriptionEdit'];

        $updateDeviceQuery = "UPDATE Devices SET DeviceName = ?, Description = ? WHERE DeviceID = ?";
        $stmt = $con->prepare($updateDeviceQuery);
        $stmt->bind_param("ssi", $deviceName, $deviceDescription, $deviceId);
        $stmt->execute();

        if ($stmt->error) {
            echo "Error updating device details: " . $stmt->error;
        } else {
            if (isset($_POST['Event_Registered_at'])) {
                $selectedEvents = $_POST['Event_Registered_at'];

                $deleteDeviceEventsQuery = "DELETE FROM eventDevice WHERE DeviceID = ?";
                $stmt = $con->prepare($deleteDeviceEventsQuery);
                $stmt->bind_param("i", $deviceId);
                $stmt->execute();

                foreach ($selectedEvents as $eventId) {
                    $insertDeviceEventQuery = "INSERT INTO eventDevice (DeviceID, EventID) VALUES (?, ?)";
                    $stmt = $con->prepare($insertDeviceEventQuery);
                    $stmt->bind_param("ii", $deviceId, $eventId);
                    $stmt->execute();

                    if ($stmt->error) {
                        echo "Error inserting event registration: " . $stmt->error;
                    }
                }
            }

            if (isset($_SERVER['HTTP_REFERER'])) {
                header("Location: ../../../View/User.php#devicesContent");
                exit();
            } else {
                echo "Error: Unable to redirect to previous page.";
            }
        }
    } else {
        echo "Error: Required form fields are missing.";
    }
}
?>