document.querySelectorAll('.tile').forEach(tile => {
  tile.addEventListener('click', function () {
    // Retrieve event details from data attributes
    const eventId = this.getAttribute('data-event-id');
    const eventName = this.getAttribute('data-event-name');
    const eventDescription = this.getAttribute('data-event-description');
    const eventLocation = this.getAttribute('data-event-location');
    const eventDate = this.getAttribute('data-event-date');
    const eventTime = this.getAttribute('data-event-time');
    const eventDevices = this.querySelector('.ALLREGEDDEVICES b').textContent;
    const eventStatus = this.querySelector('.EventStatus').textContent.split(':')[1].trim();

    document.getElementById('EventName').innerHTML = `Event Name: ${eventName}`;
    document.getElementById('EventDescription').innerHTML = `<b>Event Description:</b> ${eventDescription}`;
    document.getElementById('EventLocation').innerHTML = `<b>Event Location:</b> ${eventLocation}`;
    document.getElementById('EventDate').innerHTML = `<b>Event Date:</b> ${eventDate}`;
    document.getElementById('EventTime').innerHTML = `<b>Event Time:</b> ${eventTime}`;
    document.getElementById('EventDevices').innerHTML = `<b>Registered Devices:</b> <br> ${eventDevices}`;
    document.getElementById('EventVisibility').innerHTML = `<b>Event Status:</b> ${eventStatus}`;

  });
});
