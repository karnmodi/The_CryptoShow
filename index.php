<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | The CryptoShow</title>
    <link rel="stylesheet" href="View/CSS/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="Logo-Fevicon" type="image/png" href="Assets/Website Images/Logo.png"/>
</head>

<body>

    <nav>
        <div class="The-CryptoShow-LOGO">
            <a href="index.php">
                <img src="Assets/Website Images/Logo.png" alt="The-CryptoShow-LOGO">
            </a>
        </div>

        <div class="Buttons">
            <button class="Home"><a href="View/Home.php">Home</a></button>
            <button class="AboutUs"><a href="View/AboutUs.php">About Us</a></button>
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
                        <input id="Username_Input" type="text" name="Email" placeholder="Your Username or Email" required>
                    </div>
                    
                    <div class="input-container">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="Login_Password_Input" name="Password"
                            placeholder="Your Password" required>
                    </div>

                    <div class="Re_Pass">
                        <div class="RememberMe">
                            <input type="checkbox" id="RememberMe" name="RememberMe">
                            <label for="RememberMe">Remember Me</label>
                        </div>
                        <a href="" id="ForgotPassword">Forgot your Password?</a>
                    </div>

                    <input type="submit" class="btn" id="btn_Login" value="Login"  class="BTN_Login"/>

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
                        <input type="checkbox" id="TCApply" name="TCApply" >
                        <label for="TCApply">
                            I agree to CryptoShow's Terms of Service and Privacy Policy.</label>
                    </div>

                    <input type="submit" class="btn" id="btn_Register" value="Register" class="BTN_SignUp"/>


                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <span class="fade-in">WELCOME TO CRYPTO SHOW</span>
        <div class="video">
        <!--You can change this video-->
            <iframe width="1000" height="500" src="https://www.youtube.com/embed/8Z4JjA4f4Fw">
            </iframe>
        </div>
    </div>

    <Section id="Section2" class="section" >

        <div class="text2">
            <div class="LhsContent">

                <div class="Title">
                    <Span>The definition of a Cryptographic Device</Span>
                </div>
                <div class="Paragraph">
                    <p>Imagine a mystical artifact, humming with unseen energies, capable of weaving intricate 
                        webs of security in the digital realm. This enigmatic contraption, known as a cryptographic device, 
                        dances between worlds, generating cryptic codes, authenticating messages, and forging digital signatures with an otherworldly grace. 
                        Within its labyrinthine depths reside cryptographic modules, the arcane engines powering its feats, 
                        seamlessly integrated with other arcane components. Whether a solitary guardian of secrets or a vital cog in a grand cryptographic machine, 
                        this device stands as a sentinel of security in the ever-shifting landscape of cyberspace.
                    </p>
                </div>

            </div>
        </div>
    </Section>

    <div class="container3">
        <div class="event">
            <img src="event1.jpg" alt="Event 1">
            <div class="event-content">
                <h2>Event 1</h2>
                <p><strong>Date:</strong> March 25, 2024</p>
                <p><strong>Time:</strong> 7:00 PM</p>
                <div class="event-details">
                    <p><strong>Details:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquam velit in metus hendrerit, nec lobortis elit fringilla. Nullam commodo ipsum vel arcu sodales gravida. Sed vitae fermentum turpis.</p>
                </div>
            </div>
        </div>

    <div class="event">
        <img src="event2.jpg" alt="Event 2">
        <div class="event-content">
            <h2>Event 2</h2>
            <p><strong>Date:</strong> April 10, 2024</p>
            <p><strong>Time:</strong> 6:30 PM</p>
            <div class="event-details">
                <p><strong>Details:</strong> Ut ac lorem id elit blandit rutrum. Nam vitae nisl sed risus vestibulum finibus sed at velit. Suspendisse tincidunt lorem non lacus fringilla, in suscipit mi consequat. In lobortis tincidunt justo.</p>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-text">
                <h2 style="font-family:verdana;">© 2024 The CryptoShow</h2>
            </div>
            <div class="social-icons">
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-skype"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-flickr"></i></a>
            </div>
        </div>
    </footer>

    <script src="View/JS/index.js"></script>
    <script src="View/JS/SignUp.js"></script>
    <script src="View/JS/Login.js"></script>
     
</body>

</html>