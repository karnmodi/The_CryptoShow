  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.tile').forEach(function(element) {
      element.addEventListener('click', function() {
        const eventId = this.dataset.eventId;
        const eventName = this.dataset.eventName;
        const eventDescription = this.dataset.eventDescription;
        const eventLocation = this.dataset.eventLocation;
        const eventDate = this.dataset.eventDate;
        const eventTime = this.dataset.eventTime;
        const organizerId = this.dataset.organizerId; 
        const eventStatus = this.dataset.eventStatus;
        
        document.getElementById('eventId').value = eventId;
        document.getElementById('eventName').value = eventName;
        document.getElementById('eventDescription').value = eventDescription; 
        document.getElementById('eventLocation').value = eventLocation;
        document.getElementById('eventDate').value = eventDate;
        document.getElementById('eventTime').value = eventTime;
        document.getElementById('eventStatus').value = eventStatus;


        document.getElementById('updateEventbtn').style.display = 'inline';
        document.getElementById('deleteEventbtn').style.display = 'inline';
        document.getElementById('addEvent').style.display = 'none';
      });
    });
  });


