<?php


require_once("../../../Model/Configurations/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventName = $_POST['event-Id'];
    $eventLocation = $_POST['event_location'];
    $eventDate = $_POST['event_date'];
    $eventOrganizer = $_POST['event_organizer'];

    $insertQuery = "INSERT INTO Events (EventName, EventLocation, EventDate) VALUES (?, ?, ?)";
    $statement = mysqli_prepare($con, $insertQuery);
    mysqli_stmt_bind_param($statement, "sss", $eventName, $eventLocation, $eventDate);
    
    if (mysqli_stmt_execute($statement)) {
        echo "Event Add Successfully";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    mysqli_stmt_close($statement);
    mysqli_close($con);
} else {
    header('Location: ../Admin/Events.php');
}
?>