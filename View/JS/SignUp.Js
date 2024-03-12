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

document.getElementById('btn_Register').addEventListener('click', function(event) {
    event.preventDefault();

    // Get form input values
    const name = document.getElementById('Name').value;
    const email = document.getElementById('Email_Input').value;
    const password = document.getElementById('SignUp_Password_Input').value;

    const formData = new FormData();
    formData.append('Name', name);
    formData.append('Email', email);
    formData.append('Password', password);

    fetch('Model/Configurations/Register.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) 
    .then(data => {
        if (data.success) {
            alert(data.message); 
            window.open("View/Home.php", "_self");
        } else {
            alert(data.message); 
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again later.'); 
    });
});
