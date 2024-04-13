function toggleDeviceTile(tile, deviceId) {
  var allTiles = document.querySelectorAll('.device-tile.extended');
  allTiles.forEach(function(otherTile) {
    if (otherTile !== tile) {
      otherTile.classList.remove('expanded');
      var otherEventData = otherTile.querySelector('.event-data');
      otherEventData.style.display = 'none';
    }
  });

  var editDeviceForm = document.getElementById('EditDeviceForm' + deviceId);
  if (editDeviceForm.style.display === 'block') {
    return;
  }

  tile.classList.toggle('expanded');
  var eventData = document.getElementById('EDDATA_' + deviceId);
  if (eventData.style.display === 'block') {
    eventData.style.display = 'none';
  } else {
    eventData.style.display = 'block';
  }
}



function fetchAllEvents(deviceId) {
  fetch(`../Controller/User/Device/FetchEvents.php?deviceId=${deviceId}`)
    .then(response => response.json())
    .then(data => {
      displayEvents(data, deviceId); 
    })
    .catch(error => console.error('Error fetching events:', error));
}


function displayEvents(events, deviceId) {
  const eventsContainer = document.getElementById('EDDATA_' + deviceId);
  const updateIconHTML = document.getElementById('iconUpdateDevice_' + deviceId).outerHTML;

  eventsContainer.innerHTML = '<span>All the Existing Events in the System for Review</span>';

  const table = document.createElement('table');
  table.innerHTML = `
      <thead>
        <tr>
          <th>Event Name</th>
          <th>Event Date</th>
          <th>Event Time</th>
          <th>Event Location</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    `;
  const tbody = table.querySelector('tbody');

  events.forEach((event, index) => {
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>${event.EventName}</td>
        <td>${event.EventDate}</td>
        <td>${event.EventTime}</td>
        <td>${event.EventLocation}</td>
      `;
    tbody.appendChild(row);
  });

  eventsContainer.appendChild(table);
  eventsContainer.insertAdjacentHTML('beforeend', updateIconHTML);

  const updateIcon = document.getElementById('iconUpdateDevice_' + deviceId);
  if(updateIcon.style.display === 'none'){
    updateIcon.style.display = 'block';
  }
}

function toggleEditDeviceForm(deviceId) {
  var editDeviceForm = document.getElementById('EditDeviceForm' + deviceId);
  var CloseformIcon = document.getElementById('CloseForm_ICON_' + deviceId);
  var EditformIcon = document.getElementById('EDITForm_ICON_' + deviceId);
  
  editDeviceForm.style.display = (editDeviceForm.style.display === 'none' || editDeviceForm.style.display === '') ? 'block' : 'none';
  
  if (CloseformIcon.style.display === 'none') {
    CloseformIcon.style.display = 'block';
  }
  
  EditformIcon.style.display = 'none';
}

function closeEditDeviceForm(deviceId) {
  var editDeviceForm = document.getElementById('EditDeviceForm' + deviceId);
  var CloseformIcon = document.getElementById('CloseForm_ICON_' + deviceId);
  var EditformIcon = document.getElementById('EDITForm_ICON_' + deviceId);
  
  editDeviceForm.style.display = 'none';
  
  if (CloseformIcon.style.display === 'block') {
    CloseformIcon.style.display = 'none';
  }
  
  EditformIcon.style.display = 'block';
}

function reloadPage() {
  location.reload();
}

function deleteDevice(deviceId) {
  console.log("Device ID:", deviceId); 
  if (confirm("Are you sure you want to delete this device?")) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "../Controller/User/Device/DeleteDevice.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
          if (xhr.readyState === XMLHttpRequest.DONE) {
              if (xhr.status === 200) {
                  window.location.reload(); 
              } else {
                  alert("Error deleting device. Please try again later.");
              }
          }
      };
      xhr.send("deviceId=" + deviceId);
  }
}

function toggleNewDeviceForm() {
  var formContainer = document.getElementById("NewDeviceForm");
  formContainer.style.display = (formContainer.style.display === "none") ? "block" : "none";
}

function closeNewDeviceForm() {
  document.getElementById("NewDeviceForm").style.display = "none";
}

function closeNewDeviceForm() {
  document.getElementById("NewDeviceForm").style.display = "none";
}




