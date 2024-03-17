<?php


require_once("../../../Model/Configurations/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventName = $_POST['event_name'];
    $eventLocation = $_POST['event_location'];
    $eventDate = $_POST['event_date'];
    $eventOrganizer = $_POST['event_organizer'];
    $deviceID = 1; 
    $organizerID = 1; 
    $eventTime = date(""); 
    $eventDescription = ""; 

    $insertQuery = "INSERT INTO Events (EventName, EventLocation, EventDate, OrganizerID, EventTime, EventDescription, DeviceID) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $statement = mysqli_prepare($con, $insertQuery);

    if ($statement) {
        mysqli_stmt_bind_param($statement, "sssssss", $eventName, $eventLocation, $eventDate, $organizerID, $eventTime, $eventDescription, $deviceID);
        
        if (mysqli_stmt_execute($statement)) {
            echo "Event Added Successfully";
        } else {
            echo "Error" . mysqli_stmt_error($statement);
        }

        mysqli_stmt_close($statement);
    } else {
        echo "Error" . mysqli_error($con);
    }

    mysqli_close($con);
} else {
    header('Location: ../Admin/Events.php');
    exit();
}
?>
