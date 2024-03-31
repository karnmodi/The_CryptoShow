document.addEventListener('DOMContentLoaded', function() {
    var updateButton = document.getElementById('updateEventbtn');
    var deleteButton = document.getElementById('deleteEventbtn');
    var eventForm = document.getElementById('eventForm');
    var actionInput = document.getElementById('formAction');

    if(updateButton) {
        updateButton.addEventListener('click', function(e) {
            e.preventDefault();
            actionInput.value = 'update'; 
            eventForm.action = '../Controller/Admin/Events/UpdateEvent.php'; 
            eventForm.submit(); 
        });
    }

    if(deleteButton) {
        deleteButton.addEventListener('click', function(e) {
            e.preventDefault();
            if(confirm('Are you sure you want to delete this event?')) { 
                actionInput.value = 'delete'; 
                eventForm.action = '../Controller/Admin/Events/UpdateEvent.php';
                eventForm.submit();
            }
        });
    }
});
