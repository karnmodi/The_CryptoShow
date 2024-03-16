<?php


require_once("../../../Model/Configurations/db.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $eventName = $_POST['event-Id'];
    $eventLocation = $_POST['event_location'];
    $eventDate = $_POST['event_date'];
    $eventOrganizer = $_POST['event_organizer'];

    // Prepare and execute SQL query to insert data into Events table
    $insertQuery = "INSERT INTO Events (EventName, EventLocation, EventDate) VALUES (?, ?, ?)";
    $statement = mysqli_prepare($con, $insertQuery);
    mysqli_stmt_bind_param($statement, "sss", $eventName, $eventLocation, $eventDate);
    
    if (mysqli_stmt_execute($statement)) {
        echo "Event Add Successfully";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    // Close statement and database connection
    mysqli_stmt_close($statement);
    mysqli_close($con);
} else {
    // If the form is not submitted via POST method, redirect to the events page
    header('Location: ../Admin/Events.php');
}
?>