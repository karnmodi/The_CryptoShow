function filterSearch() {
  var input, filter, table, tbody, tr, td, i, txtValue;
  input = document.getElementById("searchstring");
  filter = input.value.trim();
  table = document.getElementsByClassName("Members_Data")[0];
  tbody = table.getElementsByTagName("tbody")[0];
  tr = tbody.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td");
      var found = false;
      for (var j = 0; j < td.length; j++) {
          if (td[j]) {
              txtValue = td[j].textContent || td[j].innerText;
              if (filter.startsWith('#') && td[0].textContent.trim() === filter.substring(1)) {
                  tr[i].style.display = "";
                  found = true;
                  break;
              } else if (txtValue.toLowerCase().includes(filter.toLowerCase())) {
                  tr[i].style.display = "";
                  found = true;
                  break;
              } else {
                  tr[i].style.display = "none";
              }
          }
      }
      if (!found) {
          tr[i].style.display = "none";
      }
  }
}