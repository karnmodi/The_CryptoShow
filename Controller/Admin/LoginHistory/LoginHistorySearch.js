function filterHistorySearch() {
    input = document.getElementById("LoginDatasearchstring");
    filter = input.value.trim().toLowerCase();
    memberTiles = document.getElementsByClassName("member-tile");
  
    for (i = 0; i < memberTiles.length; i++) {
      memberTile = memberTiles[i];
      memberName = memberTile.getElementsByTagName("h1")[0];
      lhData = memberTile.querySelector("#LHDATA table tbody");
      tableCells = lhData.getElementsByTagName("td");
  
      txtValue = memberName.textContent || memberName.innerText;
      if (txtValue.toLowerCase().indexOf(filter) > -1) {
        memberTile.style.display = "";
        continue; 
      }
  
      var found = false;
      for (j = 0; j < tableCells.length; j++) {
        txtValue = tableCells[j].textContent || tableCells[j].innerText;
        if (txtValue.toLowerCase().indexOf(filter) > -1) {
          found = true;
          break; 
        }
      }
  
      if (found) {
        memberTile.style.display = "";
      toggleTile(memberTile, memberTile.getAttribute("data-member-id"));

      } else {
        memberTile.style.display = "none";
      }
    }
  }
  