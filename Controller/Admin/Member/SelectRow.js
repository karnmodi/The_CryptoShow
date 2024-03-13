const memberRows = document.querySelectorAll('.member-row');

  memberRows.forEach(row => {
    row.addEventListener('click', () => {
      const memberID = row.getAttribute('data-memberid');
      const memberDetails = `MemberID: ${memberID}\nName: ${row.cells[1].textContent}\nEmail: ${row.cells[2].textContent}\nUser Type: ${row.cells[4].textContent}`;
      document.getElementById('selected-member-details').textContent = memberDetails;
      // Show the popup
      document.getElementById('popup').style.display = 'block';
    });
  });

  function closePopup() {
    document.getElementById('popup').style.display = 'none';
  }