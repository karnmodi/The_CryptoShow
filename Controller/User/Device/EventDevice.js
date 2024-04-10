function toggleDeviceTile(tile, deviceId) {
  if (event.target.type === 'checkbox') {
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

function fetchAllRegEvents(deviceId) {
  fetch(`../Controller/User/Device/FetchRegEvents.php?deviceId=${deviceId}`)
    .then(response => response.json())
    .then(data => {
      displayEvents(data, deviceId); 
    })
    .catch(error => console.error('Error fetching events:', error));
}

function displayEvents(events, deviceId) {
  const eventsContainer = document.getElementById('EDDATA_' + deviceId);
  const updateIconHTML = document.getElementById('iconUpdateDevice_' + deviceId).outerHTML;

  eventsContainer.innerHTML = '';

  const table = document.createElement('table');
  table.innerHTML = `
      <thead>
        <tr>
          <th>Select</th>
          <th>Event Name</th>
          <th>Event Date</th>
          <th>Event Time</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    `;
  const tbody = table.querySelector('tbody');

  events.forEach((event, index) => {
    const row = document.createElement('tr');
    row.innerHTML = `
        <td><input type="checkbox" name="eventSelect" value="${event.EventID}"></td>
        <td>${event.EventName}</td>
        <td>${event.EventDate}</td>
        <td>${event.EventTime}</td>
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
