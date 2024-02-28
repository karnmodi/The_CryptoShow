document.addEventListener('DOMContentLoaded', (event) => {

    var loginButton = document.querySelector('.Login');
    if (loginButton) {
        loginButton.addEventListener('click', function() {
            openPopup('login');
        });
    }

    var registerButton = document.querySelector('.SignUp');
    if (registerButton) {
        registerButton.addEventListener('click', function() {
            openPopup('SignUp');
        });
    }
});

function openPopup(tab) {
    var popup = document.getElementById('popupContainer');
    var loginForm = document.getElementById('LoginForm');
    var registerForm = document.getElementById('SignUpForm');
    var changeDetails = document.getElementById('ChangeDetails');

    if (tab === 'login') {
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
    } 
    else if (tab === 'SignUp') {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
    }
    else if(tab === 'ChangeDetails'){
        changeDetails.style.display='block';
    }

    popup.style.display = 'block';
}

window.onclick = function(event) {
    var popup = document.getElementById('popupContainer');
    if (event.target == popup) {
        popup.style.display = "none";
    }
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; 
    return re.test(String(email).toLowerCase());
}

function validatePassword(password) {
    const minLength = 6;
    return password.length >= minLength;
}

function showError(inputId, errorId, message) {
    const input = document.getElementById(inputId);
    const error = document.getElementById(errorId);
    input.classList.add('error-input');
    error.textContent = message; 
    error.style.display = "block"; 
}

function clearError(inputId, errorId) {
    const input = document.getElementById(inputId);
    const error = document.getElementById(errorId);
    input.classList.remove('error-input'); 
    error.style.display = "none"; 
}

document.getElementById('#btn_SignUp').addEventListener('click', function(event) {
    event.preventDefault(); 

    const email = document.getElementById('Email').value;
    const password = document.getElementById('Password_Input').value;
    let isValid = true;

    if (!validateEmail(email)) {
        showError('Email_Input', 'Email_Error', 'Please enter a valid email address.');
        isValid = false;
    } else {
        clearError('Email_Input', 'Email_Error');
    }

    if (!validatePassword(password)) {
        showError('Password_Input', 'Password_Error', 'Password must be at least 6 characters long.');
        isValid = false;
    } else {
        clearError('Password_Input', 'Password_Error');
    }

    if (isValid) {
        console.log('Form is valid, submit form or perform AJAX.');
    }
});