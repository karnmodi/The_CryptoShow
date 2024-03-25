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
    $event_id = $_POST['eventid'];
    $event_name = $_POST['eventname'];
    $event_location = $_POST['eventlocation'];
    $event_date = $_POST['eventdate'];
    $event_time = $_POST['eventtime'];
    $event_description = $_POST['eventdescription'];
    $event_organizer = $_POST['eventorganizer'];
    $event_image = $_POST['eventimage'];
    
    // Update event details in the database using prepared statements
    $updateQuery = "UPDATE events SET 
                    EventName = ?, 
                    EventLocation = ?, 
                    EventDate = ?, 
                    EventTime = ?,
                    EventDescription = ?,
                    EventOrganizer = ?,
                    EventImage = ?
                    WHERE EventID = ?";
    
    // Prepare the statement
    $stmt = mysqli_prepare($con, $updateQuery);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssssssii", $event_name, $event_location, $event_date, $event_time, $event_description, $event_organizer, $event_image, $event_id);
    
    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "Update Successfully";
    } else {
        echo "Error updating member details: " . mysqli_error($con);
    }
    
    // Close the statement
    mysqli_stmt_close($stmt);
}
?>
