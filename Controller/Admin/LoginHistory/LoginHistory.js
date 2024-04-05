  function toggleTile(tile) {
    // Toggle 'expanded' class of the clicked tile
    tile.classList.toggle('expanded');
    
    // Check if tile is expanded
    var isExpanded = tile.classList.contains('expanded');

    // If tile is expanded, fetch and display login history data
    if (isExpanded) {
      var memberId = tile.getAttribute('data-member-id');
      fetchLoginHistory(memberId);
    }
  }

  function fetchLoginHistory(memberId) {
    // Implement login history fetching logic here
    // You can use AJAX or fetch API to send a request to the server and retrieve login history data
    // Then, populate the login history content within the expanded tile
  }
