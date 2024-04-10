
function openNewMemberForm() {
  
    document.getElementById("MemberName").value = "";
    document.getElementById("MemberEmail").value = "";
    document.getElementById("MemberPassword").value = "";
    document.getElementById("MemberUserType").value = "member";

   
    document.getElementById("New-Member-Form").showModal();
}


function closeNewMemberForm() {
    document.getElementById("New-Member-Form").close();
}
