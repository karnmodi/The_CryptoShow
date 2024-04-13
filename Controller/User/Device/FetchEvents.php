<?php
require_once("../../../Model/Configurations/db.php");

header('Content-Type: application/json');

$fetchAllEventsQuery = "SELECT EventID, EventName, EventDate, EventTime, EventLocation FROM Events";
$result = $con->query($fetchAllEventsQuery);

$events = [];

while ($row = $result->fetch_assoc()) {
  $events[] = $row;
}

echo json_encode($events);
?>