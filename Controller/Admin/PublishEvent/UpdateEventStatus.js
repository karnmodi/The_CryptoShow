function toggleEventStatus(eventId, eventName, currentStatus) {
    var confirmationMessage = "";
    var newStatus = "";

    if (currentStatus === 'Visible') {
        confirmationMessage = "Are you sure you want to hide the event '" + eventName + "'?";
        newStatus = "Hidden";
    } else {
        confirmationMessage = "Are you sure you want to publish the event '" + eventName + "'?";
        newStatus = "Visible";
    }

    if (confirm(confirmationMessage)) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    window.location.reload();

                }
            } else {
                console.error('Failed to update event status');
            }

        }
    };
    xhr.open("POST", "../Controller/Admin/PublishEvent/ChangeEventStatus.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("eventId=" + eventId + "&newStatus=" + newStatus);
}
