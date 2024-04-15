<?php

require_once "Model/Configurations/db.php";

$visibleEvents = [];
$upcomingEvents = [];
$pastEvents = [];

try {

    $currentDate = date('Y-m-d');

    // Query for upcoming events
    $upcomingEventsQuery = "
        SELECT EventID, OrganizerID, DeviceID, EventName, EventDate, EventTime, EventDescription, EventLocation, EventStatus
        FROM events
        WHERE EventStatus = ? AND EventDate >= ?;
    ";

    $stmt = $con->prepare($upcomingEventsQuery);
    $visibleStatus = 'Visible';
    $stmt->bind_param("ss", $visibleStatus, $currentDate);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        array_push($upcomingEvents, $row);
    }

    $stmt->close();

    // Query for past events
    $pastEventsQuery = "
        SELECT EventID, OrganizerID, DeviceID, EventName, EventDate, EventTime, EventDescription, EventLocation, EventStatus
        FROM events
        WHERE EventStatus = ? AND EventDate < ?;
    ";

    $stmt = $con->prepare($pastEventsQuery);
    $stmt->bind_param("ss", $visibleStatus, $currentDate);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        array_push($pastEvents, $row);
    }

    $stmt->close();

} catch (Exception $e) {
    error_log($e->getMessage());
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | The CryptoShow</title>
    <link rel="stylesheet" href="View/CSS/NavBar.css">
    <link rel="stylesheet" href="View/CSS/index.css">
    <link rel="stylesheet" href="View/CSS/Demo.css">
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
        <div class="Events-card-container">
            <?php foreach ($upcomingEvents as $event): ?>
                <div class="Events-card-box">
                    <div class="Events-card-index">
                        <a href="#" class="Events-card-Component"
                            onclick="showEventData(<?php echo htmlspecialchars($event['EventID']); ?>)">
                            <div class="Events-card-bg"></div>

                            <div class="Events-card-Name">
                                <?php echo htmlspecialchars($event['EventName']); ?> <br>
                                <?php echo htmlspecialchars($event['EventDescription']); ?>
                            </div>

                            <div class="Events-card-date-box">
                                Date:
                                <span class="Events-card-date">
                                    <?php echo htmlspecialchars($event['EventDate']); ?>
                                </span>
                            </div>
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="past-events" class="index-cards-container">
        <h2>Past Events</h2>
        <div class="Events-card-container">
            <?php foreach ($pastEvents as $event): ?>
                <div class="Events-card-box">
                    <div class="Events-card-index">
                        <a href="#" class="Events-card-Component"
                            onclick="showEventData(<?php echo htmlspecialchars($event['EventID']); ?>)">
                            <div class="Events-card-bg"></div>

                            <div class="Events-card-Name">
                                <?php echo htmlspecialchars($event['EventName']); ?> <br>
                                <?php echo htmlspecialchars($event['EventDescription']); ?>
                            </div>

                            <div class="Events-card-date-box">
                                Date:
                                <span class="Events-card-date">
                                    <?php echo htmlspecialchars($event['EventDate']); ?>
                                </span>
                            </div>
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </section>


    <div class="event-popup" id="eventPopup">
        <div class="Event-Data">
            <span id="EventName"></span><br>
            <span id="EventDescription"></span><br>
            <span id="EventLocation"></span><br>
            <span id="EventDate"></span><br>
            <span id="EventTime"></span><br>
            <span id="EventDevices"></span>
        </div>
    </div>


    <section id="basic-overview" class="index-cards-container">
        <h1>Basic Overview</h1>
        <p>
        <h3>The Cryptoshow</h3>

        <blockquote style="font-size: 18px">
            The CryptoShow is not just another event management platform; it's a groundbreaking experience in the
            digital realm. Founded by a dynamic team of five developers - Karan, Farhad, Peter, Bijay, and Nouman, The
            CryptoShow is the epitome of innovation and collaboration.
        </blockquote>

        <blockquote style="font-size: 18px">
        Our journey began with a shared vision to revolutionize the way events are managed and experienced. With a
        fusion of creativity, technical expertise, and a passion for excellence, we embarked on a mission to create
        a platform that transcends conventional boundaries.
        </blockquote>

        <blockquote style="font-size: 18px">
        At The CryptoShow, we believe in empowering users to engage, connect, and flourish in the ever-evolving
        digital event landscape. Our platform seamlessly integrates cutting-edge technology with user-centric design
        to provide an unparalleled experience for both organizers and attendees. <br>

        Driven by our vision to be at the forefront of technological innovation, we are committed to pushing the
        boundaries of what's possible. Our goal is not just to manage events efficiently but to set new standards in
        the industry and inspire a future where technology and security converge seamlessly. <br>

        Join us on this journey as we redefine the way events are perceived and experienced. Together, let's create
        transformative experiences that leave a lasting impact on the world of events and beyond. Welcome to The
        CryptoShow - where every event is an opportunity for innovation and growth.
        </blockquote>
        </p>
    </section>

    <script src="View/JS/index.js"></script>
    <script src="View/JS/SignUp.js"></script>
    <script src="View/JS/Login.js"></script>

    <script>
        function showEventData(eventID) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var eventData = JSON.parse(xhr.responseText);
                        displayEventData(eventData);
                    } else {
                        console.error('Failed to fetch event data.');
                    }
                }
            };

            xhr.open('GET', 'Controller/Fetch_Upcoming_Events.php?eventID=' + eventID, true);
            xhr.send();
        }

        function displayEventData(eventData) {
            document.getElementById("EventName").innerHTML = "Event Name: " + eventData.EventName;
            document.getElementById("EventDescription").innerHTML = "Description: " + eventData.EventDescription;
            document.getElementById("EventLocation").innerHTML = "Location: " + eventData.EventLocation;
            document.getElementById("EventDate").innerHTML = "Date: " + eventData.EventDate;
            document.getElementById("EventTime").innerHTML = "Time: " + eventData.EventTime;

            if (eventData.DeviceNames !== "") {
                var devices = eventData.DeviceNames.split(",");
                var deviceList = "";
                devices.forEach(function (deviceID) {
                    deviceList += deviceID + "<br>";
                });
                document.getElementById("EventDevices").innerHTML = "Devices: <br>" + deviceList;
            } else {
                document.getElementById("EventDevices").innerHTML = "Devices: <br> No devices have been registered yet.";
            }

            document.getElementById("eventPopup").style.display = "block";
        }

        window.onclick = function (event) {
            if (event.target == document.getElementById("eventPopup")) {
                document.getElementById("eventPopup").style.display = "none";
            }
        }

    </script>

</body>

</html>