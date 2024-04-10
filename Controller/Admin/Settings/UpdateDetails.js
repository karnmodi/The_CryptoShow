var updateDetailsButton = document.getElementById("update-details-btn");
var detailsForm = document.getElementById("DetailsForm");

function openDetailsForm(){
detailsForm.style.display = "block";
}

function CloseDetailsForm(){
   detailsForm.style.display = "none";
}

updateDetailsButton.addEventListener("click", openDetailsForm);
