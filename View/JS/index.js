document.addEventListener('DOMContentLoaded', (event) => {

    var LoginTab = document.querySelector('.Login');
    if (LoginTab) {
        LoginTab.addEventListener('click', function() {
            openPopup('login');
        });
    }

    var SignUpTab = document.querySelector('.SignUp');
    if (SignUpTab) {
        SignUpTab.addEventListener('click', function() {
            clearFormInputs();
            openPopup('SignUp');
        });
    }

    var LoginBtn = document.querySelector('.BTN_Login')
    if (LoginBtn) {
        LoginBtn.addEventListener('click', function () { 
            clearFormInputs();
        })
    };
    
    var SignUpBtn = document.querySelector('.BTN_SignUp')
    if (SignUpBtn) {
        SignUpBtn.addEventListener('click', function () { 
            clearFormInputs();
        })
    };

});

function openPopup(tab) {
    var popup = document.getElementById('popupContainer');
    var loginForm = document.getElementById('LoginForm');
    var registerForm = document.getElementById('SignUpForm');
    var changeDetails = document.getElementById('ChangeDetails');

    if (tab === 'login') {
        clearFormInputs();
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
    } 
    else if (tab === 'SignUp') {
        clearFormInputs();
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
    }
    else if(tab === 'ChangeDetails'){
        changeDetails.style.display='block';
    }

    popup.style.display = 'block';
}

function clearFormInputs() {
    document.getElementById('Username_Input').value = '';
    document.getElementById('Login_Password_Input').value = '';
    document.getElementById('Name').value = '';
    document.getElementById('Email_Input').value = '';
    document.getElementById('SignUp_Password_Input').value = '';
}

window.onclick = function(event) {
    var popup = document.getElementById('popupContainer');
    if (event.target == popup) {
        popup.style.display = "none";
    }
}