document.getElementById('btn_Login').addEventListener('click', function(event) {
    event.preventDefault(); 

    const email = document.getElementById('Username_Input').value;
    const password = document.getElementById('Login_Password_Input').value;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'Model/Configurations/Login.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                if (response.user_type === "admin") {
                    alert('Login Successful ' + response.user_type + "!!")
                    window.open("View/Home.php#dashboardContent", "_self");
                } 
                else if (response.user_type === "member"){
                    alert('Login Successful ' + response.user_type + "!!")
                    window.open("View/User.php", "_self");
                }
                else{
                    alert('User type Failed')
                }
            }else {
                alert(response.message);
            }
        } else {
            alert('Request failed. Please try again later.');
        }
    };

    xhr.send('Email=' + email + '&Password=' + password);
});
