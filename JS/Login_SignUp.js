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

function toggleSubmitButton() {
    const emailError = document.getElementById('Email_Error').style.display;
    const passwordError = document.getElementById('Password_Error').style.display;
    const submitButton = document.getElementById('btn_SignUp');
    
    if (emailError === 'block' || passwordError === 'block') {
        submitButton.disabled = true;
    } else {
        submitButton.disabled = false;
    }
}


document.getElementById('Email_Input').addEventListener('keyup', function(event) {
    const email = event.target.value;
    if (email.trim() !== '') {
        if (!validateEmail(email)) {
            showError('Email_Input', 'Email_Error', 'Please enter a valid email address.');
        } else {
            clearError('Email_Input', 'Email_Error');
        }
    } else {
        clearError('Email_Input', 'Email_Error');
    }

    toggleSubmitButton();
});

document.getElementById('SignUp_Password_Input').addEventListener('keyup', function(event) {
    const password = event.target.value;
    if (password.trim() !== '') {
        if (!validatePassword(password)) {
            showError('SignUp_Password_Input', 'Password_Error', 'Password must be at least 6 characters long.');
        } else {
            clearError('SignUp_Password_Input', 'Password_Error');
        }
    } else {
        clearError('SignUp_Password_Input', 'Password_Error');
    }

    toggleSubmitButton();
});

document.getElementById('btn_Login').addEventListener('click', function(event) {
    event.preventDefault(); 

    const email = document.getElementById('Username_Input').value;
    const password = document.getElementById('Login_Password_Input').value;

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'Configurations/Login.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert(response.message);
                window.open("Home.php", "_self");
            } else {
                alert(response.message);
            }
        } else {
            alert('Request failed. Please try again later.');
        }
    };

    xhr.send('Email=' + email + '&Password=' + password);
});
