<?php
require_once("../../../Model/Configurations/db.php");


$deviceId = isset($_GET['deviceId']) ? (int)$_GET['deviceId'] : 0;

// Prepare the SQL statement
$stmt = $mysqli->prepare("
    SELECT d.DeviceID, d.DeviceName, e.EventName, e.EventDate, e.EventTime
    FROM Devices d
    LEFT JOIN EventDevice ed ON d.DeviceID = ed.DeviceID
    LEFT JOIN Events e ON ed.EventID = e.EventID
    WHERE d.DeviceID = ?
    ORDER BY e.EventDate, e.EventTime ASC
");

$stmt->bind_param("i", $deviceId);

$stmt->execute();

$stmt->bind_result($DeviceID, $DeviceName, $EventName, $EventDate, $EventTime);

$results = [];
while ($stmt->fetch()) {
    $results[] = ['DeviceID' => $DeviceID, 'DeviceName' => $DeviceName, 'EventName' => $EventName, 'EventDate' => $EventDate, 'EventTime' => $EventTime];
}

$stmt->close();
$mysqli->close();

// Check if there are results
if (count($results) > 0) {
    // Output the results as JSON
    echo json_encode($results);
} else {
    // Output a JSON error message
    echo json_encode(['error' => 'No events found for this device.']);
}
?>
