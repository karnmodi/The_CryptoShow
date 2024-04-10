var updatePasswordButton = document.getElementById("update-password-btn");
var passwordForm = document.getElementById("PasswordForm");

// Function to display the password change popup form
function openPasswordForm() {
    passwordForm.style.display = "block";
}

// Function to close the password change popup form
function closeForm() {
    passwordForm.style.display = "none";
}

// Event listener for the password change button click
updatePasswordButton.addEventListener("click", openPasswordForm);
