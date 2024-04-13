<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | The CryptoShow</title>
    <link rel="stylesheet" href="View/CSS/NavBar.css">
    <link rel="stylesheet" href="View/CSS/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="Logo-Fevicon" type="image/png" href="Assets/Website Images/Logo.png" />
</head>

<body>

    <nav>
        <div class="The-CryptoShow-LOGO">
            <a href="index.php">
                <img src="Assets/Website Images/Logo.png" alt="The-CryptoShow-LOGO">
            </a>
        </div>

        <div class="Buttons">
            <button class="AboutUs"><a href="AboutUs.php">About Us</a></button>
            <button class="Login" onclick="openPopup('login')">Login</button>
            <button class="SignUp" role="button" onclick="openPopup('SignUp')">Sign Up</button>

        </div>
    </nav>

    <div id="popupContainer" class="popup">
        <div class="popup-content">

            <div id="LoginForm">
                <form action="Model/Configurations/Login.php" method="post">
                    <div class="Tab_Header">
                        <button class="tab" id="SignupTab" onclick="openPopup('SignUp')">SignUp</button>
                        <button class="tab active" id="LoginTab" onclick="openPopup('login')">Login</button>
                    </div>

                    <div class="input-container">
                        <i class="fa-solid fa-user"></i>
                        <input id="Username_Input" type="text" name="Email" placeholder="Your Username or Email"
                            required>
                    </div>

                    <div class="input-container">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="Login_Password_Input" name="Password" placeholder="Your Password"
                            required>
                    </div>

                    <div class="Re_Pass">
                        <div class="RememberMe">
                            <input type="checkbox" id="RememberMe" name="RememberMe">
                            <label for="RememberMe">Remember Me</label>
                        </div>
                        <a href="" id="ForgotPassword">Forgot your Password?</a>
                    </div>

                    <input type="submit" class="btn" id="btn_Login" value="Login" class="BTN_Login" />

                    <span>Don't have account?<button onclick="openPopup('SignUp')"
                            style=" border:none; background-color: white; cursor: pointer;"> SignUp Now</button></span>

                </form>
            </div>

            <div id="SignUpForm">
                <form action="Model/Configurations/Register.php" method="post">
                    <div class="Tab_Header">
                        <button class="tab active" id="SignupTab" onclick="openPopup('SignUp')">SignUp</button>
                        <button class="tab" id="LoginTab" onclick="openPopup('login')">Login</button>
                    </div>

                    <div class="input-container">
                        <i class="fa-solid fa-user"></i>
                        <input id="Name" type="text" name="Name" placeholder="First & Last Name" required>
                    </div>
                    <div class="input-container">
                        <i class="fa-regular fa-envelope"></i>
                        <input id="Email_Input" type="text" name="Email" placeholder="Email" required>
                        <span class="error-message" id="Email_Error" style="display:none; color: red;">Please enter a
                            valid
                            email address.</span>
                    </div>
                    <div class="input-container">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="SignUp_Password_Input" name="Password" placeholder="Your Password"
                            required>
                        <span class="error-message" id="Password_Error" style="display:none; color: red;">Please enter a
                            valid password.</span>

                    </div>

                    <div class="TCApply">
                        <input type="checkbox" id="TCApply" name="TCApply">
                        <label for="TCApply">
                            I agree to CryptoShow's Terms of Service and Privacy Policy.</label>
                    </div>

                    <input type="submit" class="btn" id="btn_Register" value="Register" class="BTN_SignUp" />


                </form>
            </div>
        </div>
    </div>

    <section id="upcoming-events" class="index-cards-container">
        <h2>Upcoming Events</h2>
        <!-- Cards for upcoming events will be added here -->
    </section>

    <section id="past-events" class="index-cards-container">
        <h2>Past Events</h2>
        <!-- Cards for past events will be added here -->
    </section>

    <section id="basic-overview" class="index-cards-container">
        <h2>Basic Overview</h2>
        <!-- Content for basic overview will be added here -->
    </section>

    <script src="View/JS/index.js"></script>
    <script src="View/JS/SignUp.js"></script>
    <script src="View/JS/Login.js"></script>

</body>

</html>