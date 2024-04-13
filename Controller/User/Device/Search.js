function filterDeviceSearch() {
  var input = document.getElementById("SearchDevices").value.toUpperCase();
  
  var devicesSection = document.getElementById("devicesContent");
  
  var deviceTiles = devicesSection.getElementsByClassName("device-tile");
  
  for (var i = 0; i < deviceTiles.length; i++) {
    var deviceName = deviceTiles[i].getElementsByTagName("h1")[0];
    var eventData = deviceTiles[i].querySelector(".EDDTAC").textContent.toUpperCase();
    if (deviceName && eventData) {
      var name = deviceName.textContent || deviceName.innerText;
      if (name.toUpperCase().indexOf(input) > -1 || eventData.indexOf(input) > -1) {
        deviceTiles[i].style.display = "";
      } else {
        deviceTiles[i].style.display = "none";
      }
    }
  }
}
