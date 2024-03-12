<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/AboutUs.Css">
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

    <Section id="Section2">

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
                    <span>Lorem, ipsum dolor sit amet </span>
                    <p> Lorem ipsum </p>
                </div>

                <div class="Two">
                    <span>Lorem, ipsum dolor sit amet </span>
                    <p> Lorem ipsum </p>
                </div>

                <div class="Three">
                    <span>Lorem, ipsum dolor sit amet </span>
                    <p> Lorem ipsum </p>
                </div>
            </div>
    </Section>

    <Section id="Section3">
        <div class="text3">
            <span>Our Mission</span>
            <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima enim officia dolorum consectetur eveniet
                pariatur veritatis unde sed nam non facere, rerum quia nulla, recusandae dicta dolore maiores aliquid
                itaque vitae cupiditate quod at! Ullam deserunt dicta eos ratione quia, quasi doloribus aperiam
                perferendis, repellendus alias fuga atque placeat incidunt! Tempore modi repellendus vero neque, illum
                facilis rem cupiditate dolorem voluptate officia quisquam delectus nostrum non, eum itaque aut ducimus?
            </p>
        </div>
        <div class="picture">
        </div>
    </Section>

    <Section id="Section4">

        <div class="Picture2">
        </div>

        <div class="text4">
            <span>Our Vision</span>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatibus deserunt provident facere at
                voluptatum unde veritatis consequuntur iste molestiae deleniti, voluptate quidem nostrum aspernatur
                rerum facilis, libero voluptas molestias? Nam earum aperiam voluptate, magnam fuga nesciunt!
                Veritatis, aperiam sequi hic et perspiciatis minus ullam? Ex ad labore corrupti. Odit, magnam?<br>
                Qui commodi numquam assumenda illum ipsa fugiat vitae<br> natus voluptatem excepturi, ipsum deserunt
                facilis facere ex<br> aperiam atque ullam sed nesciunt.</p>
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