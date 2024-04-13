<?php
require_once ("../../../Model/Configurations/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['deviceId']) && isset($_POST['deviceName']) && isset($_POST['deviceDescriptionEdit'])) {
        $deviceId = $_POST['deviceId'];
        $deviceName = $_POST['deviceName'];
        $deviceDescription = $_POST['deviceDescriptionEdit'];

        $updateDeviceQuery = "UPDATE Devices SET DeviceName = ?, Description = ? WHERE DeviceID = ?";
        $stmt_update = $con->prepare($updateDeviceQuery);
        $stmt_update->bind_param("ssi", $deviceName, $deviceDescription, $deviceId);
        $stmt_update->execute();

        if ($stmt_update->error) {
            echo "Error updating device details: " . $stmt_update->error;
        } else {
            if ($_POST['Event_Registered_at'] == "") {
                $deleteDeviceEventsQuery = "DELETE FROM eventDevice WHERE DeviceID = ?";
                $stmt_delete = $con->prepare($deleteDeviceEventsQuery);
                $stmt_delete->bind_param("i", $deviceId);
                $stmt_delete->execute();
                
            } else {
                if (isset($_POST['Event_Registered_at'])) {
                    $selectedEvents = $_POST['Event_Registered_at'];

                    $deleteDeviceEventsQuery = "DELETE FROM eventDevice WHERE DeviceID = ?";
                    $stmt_delete_events = $con->prepare($deleteDeviceEventsQuery);
                    $stmt_delete_events->bind_param("i", $deviceId);
                    $stmt_delete_events->execute();

                    // Insert new device events
                    foreach ($selectedEvents as $eventId) {
                        $insertDeviceEventQuery = "INSERT INTO eventDevice (DeviceID, EventID) VALUES (?, ?)";
                        $stmt_insert = $con->prepare($insertDeviceEventQuery);
                        $stmt_insert->bind_param("ii", $deviceId, $eventId);
                        $stmt_insert->execute();

                        if ($stmt_insert->error) {
                            echo "Error inserting event registration: " . $stmt_insert->error;
                        }
                    }
                }
            }


            if (isset($_SERVER['HTTP_REFERER'])) {
                header("Location: ../../../View/User.php#devicesContent");
                exit();
            } else {
                echo "Error: Unable to redirect to the previous page.";
            }
        }
    } else {
        echo "Error: Required form fields are missing.";
    }
}

?>