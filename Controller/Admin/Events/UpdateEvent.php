<?php
session_start();

if (!isset($_SESSION['user_name']) || !isset($_SESSION['member_id'])) {
    header('Location: ../index.php');
    exit;
}

require_once "../../../Model/Configurations/db.php";


$loggedInMemberID = $_SESSION['member_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';

    if ($action == 'update') {
        $eventName = mysqli_real_escape_string($con, $_POST['eventName']);
        $eventDescription = mysqli_real_escape_string($con, $_POST['eventDescription']);
        $eventLocation = mysqli_real_escape_string($con, $_POST['eventLocation']);
        $deviceID = isset($_POST['deviceName']) ? $_POST['deviceName'] : array();
        $eventTime = mysqli_real_escape_string($con, $_POST['eventTime']);
        $eventDate = mysqli_real_escape_string($con, $_POST['eventDate']);
        $eventStatus = mysqli_real_escape_string($con, $_POST['eventStatus']);
        $eventId = mysqli_real_escape_string($con, $_POST['event_id']);



        $updateQuery = "UPDATE Events SET EventName = '$eventName', EventDescription = '$eventDescription', EventLocation = '$eventLocation', OrganizerID = '$loggedInMemberID', EventTime = '$eventTime', EventDate = '$eventDate', EventStatus = '$eventStatus' WHERE EventID = '$eventId'";
        if (mysqli_query($con, $updateQuery)) {
            $deleteEventDeviceQuery = "DELETE FROM EventDevice WHERE EventID = '$eventId'";
            mysqli_query($con, $deleteEventDeviceQuery);

            foreach ($deviceID as $id) {
                $insertEventDeviceQuery = "INSERT INTO EventDevice (EventID, DeviceID) VALUES ('$eventId', '$id')";
                mysqli_query($con, $insertEventDeviceQuery);
            }

            $_SESSION['message'] = 'Event updated successfully!';
        } else {
            $_SESSION['message'] = 'Error updating event: ' . mysqli_error($con);
        }
    } elseif ($action == 'delete') {
        $eventId = mysqli_real_escape_string($con, $_POST['event_id']);

        $deleteEventDeviceQuery = "DELETE FROM EventDevice WHERE EventID = '$eventId'";
        mysqli_query($con, $deleteEventDeviceQuery);

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