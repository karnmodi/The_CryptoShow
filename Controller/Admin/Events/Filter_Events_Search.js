function filterEvents() {
  var input, filter, tiles, tile, i, txtValue;
  input = document.getElementById("searchstringForEvents");
  filter = input.value.trim();
  tiles = document.getElementsByClassName("tile-container")[0].getElementsByClassName("tile");

  for (i = 0; i < tiles.length; i++) {
    tile = tiles[i];
    txtValue = tile.textContent || tile.innerText;
    
    if (filter.startsWith('#') && tile.getAttribute("data-event-id").trim() === filter.substring(1)) {
      tile.style.display = "";
    } else if (txtValue.toLowerCase().includes(filter.toLowerCase())) {
      tile.style.display = "";
    } else {
      tile.style.display = "none";
    }
  }
}
