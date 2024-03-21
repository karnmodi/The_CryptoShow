<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header('Location: ../index.php');
    exit;
}

require_once("../../../Model/Configurations/db.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $eventID = $_POST['event_id'];
    $Name = $_POST['event_name'];
    $Location = $_POST['event_location'];
    $Date = $_POST['event_date'];
    $Time = $_POST['event_time'];
    $Description = $_POST['event_description'];
    $Image = $_POST['event_image'];
    
    // Update event details in the database using prepared statements
    $updateQuery = "UPDATE events SET 
                    EventName = $Name, 
                    EventLocation = $Location, 
                    EventDate = $Date, 
                    EventTime = $Time,
                    EventDescription = $Description,
                    EventImage = $Image
                    WHERE EventID = $eventID";
    
    // Prepare the statement
    $statement = mysqli_prepare($con, $updateQuery);
    
    // Bind parameters
    mysqli_stmt_bind_param($statement, "ssssssi", $newName, $newLocation, $newDate, $newTime, $newDescription, $newImage, $eventID);
    
    // Execute the statement
    if (mysqli_stmt_execute($statement)) {
        echo "Update Successfully";
    } else {
        echo "Error updating event details: " . mysqli_error($con);
    }
    
    // Close the statement
    mysqli_stmt_close($statement);
}
?>
