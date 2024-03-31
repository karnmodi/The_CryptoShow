<?php

require_once("../../../Model/Configurations/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventName = $_POST['eventName'];
    $eventLocation = $_POST['eventLocation'];
    $eventDate = $_POST['eventDate'];
    $memberID = (int)$_POST['organizerName'];
    $eventTime = $_POST['eventTime'];
    $eventDescription = $_POST['eventDescription'];
    $eventStatus = $_POST['eventStatus'];
    $deviceID = (int)$_POST['deviceName'];

    $insertQuery = "INSERT INTO Events (EventName, EventLocation, EventDate, OrganizerID, EventTime, EventDescription, EventStatus, DeviceID) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
    $statement = mysqli_prepare($con, $insertQuery);

    if ($statement) {
        mysqli_stmt_bind_param($statement, "sssissss", $eventName, $eventLocation, $eventDate, $memberID, $eventTime, $eventDescription,$eventStatus, $deviceID);
        
        if (mysqli_stmt_execute($statement)) {
            echo "Event Added Successfully";
        } else {
            echo "Error: " . mysqli_stmt_error($statement);
        }

        mysqli_stmt_close($statement);
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
} else {
    header('Location: ../Admin.php#Dashboard');
    exit();
}

?>
