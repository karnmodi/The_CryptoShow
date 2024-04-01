<?php
session_start();
require_once "../../../Model/Configurations/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';

    if ($action == 'update' || $action == 'add') {
        $eventName = mysqli_real_escape_string($con, $_POST['eventName']);
        $eventDescription = mysqli_real_escape_string($con, $_POST['eventDescription']);
        $eventLocation = mysqli_real_escape_string($con, $_POST['eventLocation']);
        $organizerID = mysqli_real_escape_string($con, $_POST['organizerName']);
        $deviceID = mysqli_real_escape_string($con, $_POST['deviceName']);
        $eventTime = mysqli_real_escape_string($con, $_POST['eventTime']);
        $eventDate = mysqli_real_escape_string($con, $_POST['eventDate']);
        $eventStatus = mysqli_real_escape_string($con, $_POST['eventStatus']);

        if (empty($deviceID) || $deviceID == 'none') { 
            $_SESSION['message'] = 'Please select a device.';
            header('Location: ../../../View/Home.php?section=events');
            exit;
        }

        if ($action == 'update') {
            $eventId = mysqli_real_escape_string($con, $_POST['event_id']);
            $updateQuery = "UPDATE Events SET EventName = '$eventName', EventDescription = '$eventDescription', EventLocation = '$eventLocation', OrganizerID = '$organizerID', DeviceID = '$deviceID', EventTime = '$eventTime', EventDate = '$eventDate', EventStatus = '$eventStatus' WHERE EventID = '$eventId'";
            // Execute the update query
            if (mysqli_query($con, $updateQuery)) {
                $_SESSION['message'] = 'Event updated successfully!';
            } else {
                $_SESSION['message'] = 'Error updating event: ' . mysqli_error($con);
            }
        }
    } elseif ($action == 'delete') {
        $eventId = mysqli_real_escape_string($con, $_POST['event_id']);
        $deleteQuery = "DELETE FROM Events WHERE EventID = '$eventId'";
        if (mysqli_query($con, $deleteQuery)) {
            $_SESSION['message'] = 'Event deleted successfully!';
        } else {
            $_SESSION['message'] = 'Error deleting event: ' . mysqli_error($con);
        }
    } else {
        $_SESSION['message'] = 'Invalid action requested.';
    }

    header('Location: ../../../View/Home.php');
    exit;
}
?>
