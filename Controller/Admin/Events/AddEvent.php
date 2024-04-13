<?php
session_start();

if (!isset($_SESSION['user_name']) || !isset($_SESSION['member_id'])) {
  header('Location: ../index.php');
  exit;
}

require_once "../../../Model/Configurations/db.php";


$loggedInMemberID = $_SESSION['member_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventName = $_POST['eventName'];
    $eventLocation = $_POST['eventLocation'];
    $eventDate = $_POST['eventDate'];
    $memberID = (int) $_POST['organizerName'];
    $eventTime = $_POST['eventTime'];
    $eventDescription = $_POST['eventDescription'];
    $eventStatus = $_POST['eventStatus'];
    $deviceIDs = isset($_POST['deviceName']) ? $_POST['deviceName'] : array(); 

    $insertQuery = "INSERT INTO Events (EventName, EventLocation, EventDate, OrganizerID, EventTime, EventDescription, EventStatus) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $statement = mysqli_prepare($con, $insertQuery);

    if ($statement) {
        mysqli_stmt_bind_param($statement, "sssisss", $eventName, $eventLocation, $eventDate, $loggedInMemberID, $eventTime, $eventDescription, $eventStatus);

        if (mysqli_stmt_execute($statement)) {
            $eventId = mysqli_insert_id($con); 

            foreach ($deviceIDs as $deviceID) {
                $insertEventDeviceQuery = "INSERT INTO EventDevice (EventID, DeviceID) VALUES (?, ?)";
                $statementEventDevice = mysqli_prepare($con, $insertEventDeviceQuery);
                mysqli_stmt_bind_param($statementEventDevice, "ii", $eventId, $deviceID);
                mysqli_stmt_execute($statementEventDevice);
                mysqli_stmt_close($statementEventDevice);
            }

            $_SESSION['message'] = 'Event Added Successfully';
            header('Location: ../../../View/Home.php#eventsContent');
            ;
        } else {
            $_SESSION['message'] = '"Error: " . mysqli_stmt_error($statement);';
            header('Location: ../Home.php#eventsContent');
        }

        mysqli_stmt_close($statement);
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
} else {
    header('Location: ../Home.php#Dashboard');
    exit();
}


?>