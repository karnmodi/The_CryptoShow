<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="view/CSS/AboutUs.css">
    <link rel="stylesheet" href="view/CSS/NavBar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>The CryptoShow</title>
</head>

<body>
    <nav>
        <div class="The-CryptoShow-LOGO">
            <a href="index.php">
                <img src="Assets/Website Images/Logo.png" alt="The-CryptoShow-LOGO">
            </a>
        </div>

        <div class="Buttons">
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

    <div class="AboutUscontainer">
        <span style="font-size: 200%; text-align: center;">We're changing the whole game.</span>
        <div class="links">
            <a class="Get_Started" role="button" href="#Section2">Get Started</a>

        </div>
    </div>

    <Section id="Section2" class="section">

        <div class="text2">
            <div class="LhsContent">

                <div class="Title">
                    <Span>Our Story</Span>
                    <p style="font-size: 25px;">Together we will make history</p>
                </div>
                <div class="Paragraph">
                    <p>In the bustling world of event management, a team of five developers united to create Cryptoshow,
                        a groundbreaking website. Karan, Farhad, Peter, Bijay, and Nouman poured their unique skills
                        into the project. Cryptoshow isn't just a platform; it's an experience where users can
                        seamlessly join events and showcase their devices.
                    </p>
                </div>

            </div>

            <div class="RhsContent">
                <div class="One">
                    <span>Our Story </span>
                    <p>"In the tapestry of technology, we weave a narrative of innovation."</p>
                </div>

                <div class="Two">
                    <span>Our Mission </span>
                    <p>"Empowering users to engage, connect, and flourish in the digital event landscape."</p>
                </div>

                <div class="Three">
                    <span>Our Vision </span>
                    <p>"A world where every event is an opportunity for transformative experiences."</p>
                </div>

            </div>
    </Section>

    <Section id="Section3" class="section">
        <div class="text3">
            <span>Our Mission</span>
            <p> The primary aim of the application is to meticulously design and systematically implement a
                comprehensive full-stack web application that is dedicated to the management and orchestration of an
                event. The particular scenario that this application is tailored for is a specialized exhibition
                showcasing Cryptographic Devices, where various stakeholders can interact, display, and engage with the
                latest advancements in cryptographic technology.
            </p>
        </div>
        <div class="picture">

        </div>
    </Section>

    <Section id="Section4" class="section">

        <div class="Picture2">
        </div>

        <div class="text4">
            <span>Our Vision</span>
            <p>“Our vision is to be at the forefront of technological innovation, creating a full-stack web application
                that not only manages events with unparalleled efficiency but also serves as a beacon for the
                cryptographic device industry. We aim to foster a platform where cutting-edge cryptographic technology
                is showcased and celebrated, driving forward the industry’s standards and inspiring a future where
                security and technology seamlessly converge.”</p>
        </div>
    </Section>

    <Section id="Section5" class="section">
        <div class="container2">
            <h1>Get to know about our team & <a href="https://github.com/karnmodi/The_CryptoShow"
                    target="_blank">The_CryptoShow</a></h1>
            <div class="member">
                <img src="/The_CryptoShow/Assets/Website Images/Developers/karnModi.png" alt="Member 1">
                <div class="details">
                    <h2>Karan Modi | <a href="https://karanmodi.com/" target="_blank">Portfolio</a></h2>
                    <ul>
                        <li>Team leader</li>
                        <li>Frontend Designer</li>
                        <li>Database Administrator (DBA)</li>
                        <li>Backend Handler</li>
                        <p>tel: 07867064191 &nbsp;|&nbsp; Email: P2761604@my365.dmu.ac.uk</p>
                    </ul>
                </div>
            </div>
            <div class="member">
                <img src="/The_CryptoShow/Assets/Website Images/Developers/Farhad.jpg" alt="Member 2">
                <div class="details">
                    <h2>Farhad Kishwar</h2>
                    <ul>
                        <li>Interface/Front End Designer</li>
                        <li>Software Architect</li>
                        <p>tel: 07931464307 &nbsp;|&nbsp; Email: P2755047@my365.dmu.ac.uk</p>
                    </ul>
                </div>
            </div>
            <div class="member">
                <img src="/The_CryptoShow/Assets/Website Images/Developers/Kittipat.jpg" alt="Member 2">
                <div class="details">
                    <h2>Kittipat Weng</h2>
                    <ul>
                        <li>Lead Developer</li>
                        <li>Interface/Front End Designer(assistant)</li>
                        <p>tel: 07307726432 &nbsp;|&nbsp; Email: P2754832@my365.dmu.ac.uk</p>
                    </ul>
                </div>
            </div>
            <div class="member">
                <img src="/The_CryptoShow/Assets/Website Images/Developers/Biijay.jpg" alt="Member 2">
                <div class="details">
                    <h2>Bijay Hang Limbu</h2>
                    <ul>
                        <li>Business analyst</li>
                        <p>tel: 0747542844 &nbsp;|&nbsp; Email: P2728246@my365.dmu.ac.uk</p>
                    </ul>
                </div>
            </div>
            <div class="member">
                <img src="member2.jpg" alt="Member 2">
                <div class="details">
                    <h2>Muhammad Nouman Ijaz</h2>
                    <ul>
                        <li>QA</li>
                        <p>tel: 07928526270 &nbsp;|&nbsp; Email: P2764688@my365.dmu.ac.uk</p>
                    </ul>
                </div>
            </div>
        </div>
    </Section>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-text">
                <h2>© 2024 The CryptoShow</h2>
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

    <script src="view/JS/Start.js"></script>
    <script src="view/JS/index.js"></script>
    <script src="view/JS/AboutUs.js"></script>
    <script src="view/JS/SignUp.js"></script>
    <script src="view/JS/Login.js"></script>
</body>

</html>