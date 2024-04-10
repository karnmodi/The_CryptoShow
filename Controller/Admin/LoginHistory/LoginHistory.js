function toggleTile(tile, memberId) {
  tile.classList.toggle('expanded');
  var loginData = document.getElementById('LHDATA' + memberId); 
  if (loginData.style.display === 'block') {
    loginData.style.display = 'none';
  } else {
    loginData.style.display = 'block';
  }
}