<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/AboutUs.css">
    <link rel="stylesheet" href="CSS/NavBar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>The CryptoShow</title>
</head>

<body>
    <nav>
        <div class="The-CryptoShow-LOGO">
            <a href="../index.php">
                <img src="../Assets/Website Images/Logo.png" alt="The-CryptoShow-LOGO"> 
            </a>
        </div>

        <div class="Buttons">
            <button class="Login" onclick="openPopup('login')">Login</button>
            <button class="SignUp" role="button" onclick="openPopup('SignUp')">Sign Up</button>

        </div>
    </nav>

    <!-- LOGIN/SignUp POPUP -->
    <div id="popupContainer" class="popup">
        <div class="popup-content">

            <div id="LoginForm">

                <div class="Tab_Header">
                    <button class="tab" id="SignupTab" onclick="openPopup('SignUp')">SignUp</button>
                    <button class="tab active" id="LoginTab" onclick="openPopup('login')">Login</button>
                </div>

                <div class="input-container">
                    <i class="fa-solid fa-user"></i>
                    <input id="Username_Input" type="text" placeholder="Your Username or Email">
                </div>
                <div class="input-container">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="Password_Input" placeholder="Your Password">
                </div>

                <div class="Re_Pass">
                    <div class="RememberMe">
                        <input type="checkbox" id="RememberMe" name="RememberMe">
                        <label for="RememberMe">Remember Me</label>
                    </div>
                    <a href="" id="ForgotPassword">Forgot your Password?</a>
                </div>
                <button class="btn_Login">Log In</button>
                <span>Don't have account?<button onclick="openPopup('SignUp')" style=" border:none; background-color: white; cursor: pointer;"> SignUp Now</button></span>

                
            </div>
            <div id="SignUpForm">
                <div class="Tab_Header">
                    <button class="tab active" id="SignupTab" onclick="openPopup('SignUp')">SignUp</button>
                    <button class="tab" id="LoginTab" onclick="openPopup('login')">Login</button>
                </div>

                <div class="input-container">
                    <i class="fa-solid fa-user"></i>
                    <input id="Name_Input" type="text" placeholder="First & Last Name" required>
                </div>
                <div class="input-container">
                    <i class="fa-regular fa-envelope"></i>
                    <input id="Email_Input" type="text" placeholder="Email" required>
                    <span class="error-message" id="Email_Error" style="display:none; color: red;">Please enter a valid
                        email address.</span>
                </div>
                <div class="input-container">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="Password_Input" placeholder="Your Password" required>
                    <span class="error-message" id="Password_Error" style="display:none; color: red;">Password must be
                        at least 6 characters long.</span>
                </div>

                <div class="TCApply">
                    <input type="checkbox" id="TCApply" name="TCApply">
                    <label for="TCApply">
                        I agree to CryptoShow's Terms of Service and Privacy Policy.</label>
                </div>

                <button class="btn_SignUp">Sign Up</button>

            </div>
        </div>
    </div>

    <div class="container">
        <span class="fade-in">We're changing the whole game.</span>
        <div class="links">
            <button class="Get_Started" role="button">Get Started</button>
        </div>
    </div>

    <Section id="Section2" class="section" >

        <div class="text2">
            <div class="LhsContent">

                <div class="Title">
                    <Span>Our Story</Span>
                    <p style="font-size: 25px;">Together we will make history</p>
                </div>
                <div class="Paragraph">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque, inventore ducimus placeat facere
                        eveniet deleniti temporibus deserunt officia nesciunt dolor voluptates iusto iure? Repellendus
                        voluptate perspiciatis ratione tempore sed nisi, ullam tenetur expedita sit nihil hic ipsa quis
                        quibusdam ipsum itaque obcaecati recusandae unde! Voluptas explicabo ab dicta? Ea, accusantium.
                    </p>
                </div>

            </div>

            <div class="RhsContent">
                <div class="One">
                    <span>Our Story </span>
                    <p> Lorem ipsum </p>
                </div>

                <div class="Two">
                    <span>Our Mission </span>
                    <p> Lorem ipsum </p>
                </div>

                <div class="Three">
                    <span>Our Vision </span>
                    <p> Lorem ipsum </p>
                </div>
            </div>
    </Section>

    <Section id="Section3" class="section" >
        <div class="text3">
            <span>Our Mission</span>
            <p> The primary aim of the application is to meticulously design and systematically implement a comprehensive full-stack web application that is dedicated to the management and orchestration of an event. The particular scenario that this application is tailored for is a specialized exhibition showcasing Cryptographic Devices, where various stakeholders can interact, display, and engage with the latest advancements in cryptographic technology.
            </p>
        </div>
        <div class="picture">
            <img src="/The_CryptoShow/Assets/Website Images/Mission pic.png" alt="Mission picture" width="500" height="500">
        </div>
    </Section>

    <Section id="Section4" class="section" >

        <div class="Picture2">
            <img src="/The_CryptoShow/Assets/Website Images/VisionPic.png" alt="Vision picture">
        </div>

        <div class="text4" >
            <span>Our Vision</span>
            <p>“Our vision is to be at the forefront of technological innovation, creating a full-stack web application that not only manages events with unparalleled efficiency but also serves as a beacon for the cryptographic device industry. We aim to foster a platform where cutting-edge cryptographic technology is showcased and celebrated, driving forward the industry’s standards and inspiring a future where security and technology seamlessly converge.”</p>
        </div>
    </Section>

    <Section id="Section5" class="section" >
        <div class="container2">
            <h1>Get to know our team</h1>
            <div class="member">
                <img src="/The_CryptoShow/Assets/Website Images/karnModi.png" alt="Member 1">
                <div class="details">
                    <h2>Karan Modi</h2>
                    <ul>
                        <li>Team leader</li>
                        <li>Database Administrator (DBA)</li>
                        <p>tel: 07867064191</p>
                    </ul>
                    <!-- Additional details for member 1 -->
                </div>
            </div>
            <div class="member">
                <img src="/The_CryptoShow/Assets/Website Images/Farhad.jpg" alt="Member 2">
                <div class="details">
                    <h2>Farhad Kishwar</h2>
                    <ul>
                        <li>Interface/Front End Designer</li>
                        <li>Software Architect</li>
                        <p>tel: 07931464307</p>
                    </ul>
                    <!-- Additional details for member 2 -->
                </div>
            </div>
            <div class="member">
                <img src="/The_CryptoShow/Assets/Website Images/Kittipat.jpg" alt="Member 2">
                <div class="details">
                    <h2>Kittipat Weng</h2>
                    <ul>
                        <li>Lead Developer</li>
                        <li>Interface/Front End Designer(assistant)</li>
                        <p>tel: 07307726432</p>
                    </ul>
                    <!-- Additional details for member 3 -->
                </div>
            </div>
            <div class="member">
                <img src="/The_CryptoShow/Assets/Website Images/Biijay.jpg" alt="Member 2">
                <div class="details">
                    <h2>Bijay Hang Limbu</h2>
                    <ul>
                        <li>Business analyst</li>
                        <p>tel: 0747542844</p>
                    </ul>
                    <!-- Additional details for member 4 -->
                </div>
            </div>
            <div class="member">
                <img src="member2.jpg" alt="Member 2">
                <div class="details">
                    <h2>Muhammad Nouman Ijaz</h2>
                    <ul>
                        <li>QA</li>
                        <p>tel: 07928526270</p>
                    </ul>
                    <!-- Additional details for member 5 -->
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

    <script src="/JS/Start.js"></script>
    <script src="/JS/AboutUs.js"></script>
</body>

</html>