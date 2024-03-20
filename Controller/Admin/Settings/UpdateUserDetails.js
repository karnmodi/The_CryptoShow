document.addEventListener("DOMContentLoaded", function () {
    const changeUserDetailsButton = document.getElementById("change-user-details");
    const updateUserDetailsDialog = document.getElementById("Update-User-Details");
    const cancelUpdateButton = document.getElementById("cancel-update");
  
    // Show update user details dialog when the change button is clicked
    changeUserDetailsButton.addEventListener("click", function () {
      updateUserDetailsDialog.showModal();
    });
  
    // Hide the update user details dialog when the cancel button is clicked
    cancelUpdateButton.addEventListener("click", function () {
      updateUserDetailsDialog.close();
    });
  
    // Optionally, you can add validation and submission of the form here
  });
  