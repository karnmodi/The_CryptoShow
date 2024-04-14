<?php

require_once ("../Model/Configurations/db.php");

if (isset($_GET['eventID'])) {
    $eventID = $_GET['eventID'];

    $eventQuery = "
    SELECT e.EventID, e.OrganizerID, GROUP_CONCAT(d.DeviceName) AS DeviceNames, e.EventName, e.EventDate, e.EventTime, e.EventDescription, e.EventLocation, e.EventStatus
    FROM events e
    LEFT JOIN EventDevice ed ON e.EventID = ed.EventID
    LEFT JOIN Devices d ON ed.DeviceID = d.DeviceID
    WHERE e.EventID = ?
    GROUP BY e.EventID
    ";

    $stmt = $con->prepare($eventQuery);
    $stmt->bind_param("i", $eventID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $eventData = $result->fetch_assoc();

        // Check if DeviceNames is empty
        if ($eventData['DeviceNames'] === null) {
            $eventData['DeviceNames'] = "No devices have been registered yet.";
        } else {
            // Convert DeviceNames to string
            $eventData['DeviceNames'] = (string) $eventData['DeviceNames'];
        }

        echo json_encode($eventData);
    } else {
        echo json_encode(array("error" => "Event not found"));
    }

    exit;
}

?>

?>