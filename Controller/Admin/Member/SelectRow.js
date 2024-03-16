const memberRows = document.querySelectorAll('.Member-Rows');

  memberRows.forEach(row => {
    row.addEventListener('click', () => {
      const memberId = row.cells[0].textContent.trim();
      const memberName = row.cells[1].textContent.trim();
      const memberEmail = row.cells[2].textContent.trim();
      const memberPassword = row.cells[3].textContent.trim();
      const memberUserType = row.cells[4].textContent.trim();

      document.getElementById('selected-member-Id').value = `${memberId}`;
      document.getElementById('selected-member-Name').value = `${memberName}`;
      document.getElementById('selected-member-Email').value = `${memberEmail}`;
      document.getElementById('selected-member-Password').value = `${memberPassword}`;
      document.getElementById('selected-member-UserType').value = `${memberUserType}`;
    });
  });
