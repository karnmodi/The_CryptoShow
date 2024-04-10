 <?php
session_start();

if (!isset($_SESSION['user_name'])) {

  header('Location: ../index.php');
  exit;
}

// Database Connection
$userName = $_SESSION['user_name'];
require_once "../Model/Configurations/db.php";


// Fetching Login History for the Chart in the Dashboard Section
$loginHistoryChartQuery = "
    SELECT m.Name, COUNT(l.LoginHistoryID) as LoginCount
    FROM member m
    LEFT JOIN loginhistory l ON m.MemberID = l.MemberID
    GROUP BY m.MemberID
";

$loginHistoryChartResult = mysqli_query($con, $loginHistoryChartQuery);

$chartData = [
  'userNames' => [],
  'loginCounts' => []
];

while ($row = mysqli_fetch_assoc($loginHistoryChartResult)) {
  $chartData['userNames'][] = $row['Name'];
  $chartData['loginCounts'][] = $row['LoginCount'];
}


// Fetching all the Events in a Event Section
$FetchAllEvents = "SELECT e.EventID,e.EventName,e.EventDescription, e.EventDate, e.EventTime, e.EventLocation,e.OrganizerID, e.DeviceID, e.EventStatus, m.Name, d.DeviceName, d.Description
FROM Events e
JOIN Member m ON e.OrganizerID = m.MemberID
JOIN Devices d ON e.DeviceID = d.DeviceID;";
$resultofFE = mysqli_query($con, $FetchAllEvents);

// Fetching all the Events which are created by the Selected USER
$eventsPerUserQuery = "SELECT m.Name, COUNT(e.EventID) as EventCount
                       FROM Events e
                       JOIN Member m ON e.OrganizerID = m.MemberID
                       GROUP BY e.OrganizerID;";
$eventsPerUserResult = mysqli_query($con, $eventsPerUserQuery);

$eventsPerUserData = [];
while ($row = mysqli_fetch_assoc($eventsPerUserResult)) {
  $eventsPerUserData[] = $row;
}

// Query for fetching visible events in the Published Event Section
$fetchVisibleEventsQuery = "SELECT e.EventID, e.EventName, e.EventDescription, e.EventDate, e.EventTime, e.EventLocation, e.OrganizerID, e.DeviceID, e.EventStatus, m.Name AS OrganizerName, d.DeviceName
FROM Events e
JOIN Member m ON e.OrganizerID = m.MemberID
JOIN Devices d ON e.DeviceID = d.DeviceID
WHERE e.EventStatus = 'Visible';
";
$visibleEventsResult = mysqli_query($con, $fetchVisibleEventsQuery);

// Query for fetching hidden events in the Published Event Section
$fetchHiddenEventsQuery = "SELECT e.EventID, e.EventName, e.EventDescription, e.EventDate, e.EventTime, e.EventLocation, e.OrganizerID, e.DeviceID, e.EventStatus, m.Name AS OrganizerName, d.DeviceName
FROM Events e
JOIN Member m ON e.OrganizerID = m.MemberID
JOIN Devices d ON e.DeviceID = d.DeviceID
WHERE e.EventStatus = 'Hidden';
";
$hiddenEventsResult = mysqli_query($con, $fetchHiddenEventsQuery);

// Fetching all the members in a Member Section
$FetchAllMembers = "SELECT * from member";
$resultofFM = mysqli_query($con, $FetchAllMembers);

// Total Login Counts for the Login history Section
$loginCountsQuery = "
    SELECT COUNT(l.LoginHistoryID) as LoginCount
    FROM member m
    LEFT JOIN loginhistory l ON m.MemberID = l.MemberID
    GROUP BY l.LoginHistoryID
";

$loginCountsResult = mysqli_query($con, $loginCountsQuery);


// Fetching Last Login Details from the Login History Table to the Section
$lastLoginQuery = "SELECT LoginDT FROM loginhistory ORDER BY LoginDT DESC LIMIT 1";
$lastLoginResult = mysqli_query($con, $lastLoginQuery);
if ($lastLoginRow = mysqli_fetch_assoc($lastLoginResult)) {
  $lastLoginTime = $lastLoginRow['LoginDT'];
} else {
  $lastLoginTime = "No login history available";
}

// Fetching Last three Email based on the DT from the login History who did login.
$lastThreeLoginsQuery = "
    SELECT m.Email, l.LoginDT
    FROM member m
    INNER JOIN loginhistory l ON m.MemberID = l.MemberID
    ORDER BY l.LoginDT DESC
    LIMIT 3
";
$lastThreeLoginsResult = mysqli_query($con, $lastThreeLoginsQuery);


// Fetching Login History of Member individually for the Login History Section

$loginHistoryByMemberQuery = "
    SELECT m.Name AS MemberName, l.LoginDT AS LoginDateTime
    FROM member m
    LEFT JOIN loginhistory l ON m.MemberID = l.MemberID
    ORDER BY m.Name, l.LoginDT DESC
";
$loginHistoryByMemberResult = mysqli_query($con, $loginHistoryByMemberQuery);

$fetchAllMembersQuery = "SELECT * FROM member";
$fetchAllMembersResult = mysqli_query($con, $fetchAllMembersQuery);

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin | The CryptoShow</title>
  <link rel="stylesheet" href="CSS/Admin/Home.css">
  <link rel="stylesheet" href="CSS/Admin/Dashboard.css">
  <link rel="stylesheet" href="CSS/Admin/Events.css">
  <link rel="stylesheet" href="CSS/Admin/Published_Events.css">
  <link rel="stylesheet" href="CSS/Admin/Member.css">
  <link rel="stylesheet" href="CSS/Admin/Login_History.css">
  <link rel="stylesheet" href="CSS/Admin/Settings.css">

  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <script>

    <?php if (isset($_SESSION['message']) && !empty($_SESSION['message'])): ?>
      window.onload = function () {
        alert("<?php echo $_SESSION['message']; ?>");
        <?php unset($_SESSION['message']); ?>
      };
    <?php endif; ?>

    document.addEventListener('DOMContentLoaded', function () {

      var lastActiveSection = localStorage.getItem('activeSection');

      if (lastActiveSection) {
  showSection(lastActiveSection);
} 

      var organizerSelect = document.getElementById('organizerName');
      var deviceSelect = document.getElementById('deviceName');
      var initialDevicesOptions = Array.from(deviceSelect.options);

      organizerSelect.addEventListener('change', function () {
        const selectedOrganizerId = this.value;
        while (deviceSelect.options.length > 1) deviceSelect.remove(1);

        initialDevicesOptions.forEach(function (option) {
          if (option.dataset.memberId === selectedOrganizerId) {
            deviceSelect.add(option.cloneNode(true));
          }
        });
      });

    });


  </script>

</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <img src="../Assets/Website Images/logo.png" alt="Logo" srcset="" class="icon">
      <div class="logo_name">CryptoShow</div>
      <i class='bx bx-menu' id="btn"></i>
    </div>
    <ul class="nav-list">
      <li>
        <i class='bx bx-search'></i>
        <input type="text" placeholder="Search...">
        <span class="SB_Btns">Search</span>
      </li>

      <li>
        <a href="javascript:void(0);" onclick="showSection('dashboardContent');">
          <i class='bx bx-grid-alt'></i>
          <span class="Btns_Name">Dashboard</span>
        </a>
        <span class="SB_Btns">Dashboard</span>
      </li>

      <li>
        <a href="javascript:void(0);" onclick="showSection('eventsContent');">
          <i class='bx bx-pie-chart-alt-2'></i>
          <span class="Btns_Name">Events</span>
        </a>
        <span class="SB_Btns">Events</span>
      </li>

      <li>
        <a href="javascript:void(0);" onclick="showSection('PublishedEventsContent');">
          <i class='bx bx-chat'></i>
          <span class="Btns_Name">Published Events</span>
        </a>
        <span class="SB_Btns">Published Events</span>
      </li>


      <li>
        <a href="javascript:void(0);" onclick="showSection('membersContnet');">
          <i class='bx bx-user'></i>
          <span class="Btns_Name">Members</span>
        </a>
        <span class="SB_Btns">Members</span>
      </li>

      <li>
        <a href="javascript:void(0);" onclick="showSection('LoginHistoryContent');">
          <i class='bx bx-folder'></i>
          <span class="Btns_Name">Login History</span>
        </a>
        <span class="SB_Btns">Login History</span>
      </li>

      <li>
        <a href="javascript:void(0);" onclick="showSection('settingsContent');">
          <i class='bx bx-cog'></i>
          <span class="Btns_Name">Setting</span>
        </a>
        <span class="SB_Btns">Setting</span>
      </li>

      <li class="profile">
        <div class="profile-details">
          <img src="../Assets/Website Images/Github Logo PNG.png" alt="profileImg">
          <div class="name_job">
            <div class="name">
              <?php echo $userName; ?>
            </div>
            <div class="position">Student</div>
          </div>
        </div>
        <a href="../Model\Configurations\Logout.php"><i class='bx bx-log-out' id="log_out"></i></a>
      </li>
    </ul>
  </div>


  <section class="Dashboard-section sections" id="dashboardContent">
    <div class="Header_text">Dashboard</div>

    <div class="Body-Content">
      <div class="dashboard-widgets">
        <div class="widget">
          <h2> Total Members </h2>
          <p>
            <?php echo mysqli_num_rows($resultofFM); ?>
            <i class="fa-solid fa-people-group"></i>
          </p>
        </div>


        <div class="event-widget">
          <h2> Total Events Schedules</h2>
          <?php
          $totalEventsCount = mysqli_num_rows($resultofFE);
          ?>
          <p>
            <?php echo $totalEventsCount; ?>
            <i class="fa-regular fa-calendar-days"></i>
          </p>

        </div>
      </div>

      <div class="Latest-Container">

        <div class="Latest-Member-Widget">
          <h2>Latest Member</h2>
          <ul>
            <?php
            $latestMembersQuery = "SELECT * FROM member ORDER BY MemberID";
            $latestMembersResult = mysqli_query($con, $latestMembersQuery);
            while ($row = mysqli_fetch_assoc($latestMembersResult)) {
              echo "<li> {$row['Name']}</li>";
            }
            ?>
          </ul>
        </div>


        <div class="Upcoming-Events-widget">
          <h2> Upcoming Events : </h2>
          <ul style="margin-left:20px;">
            <?php
            $currentDate = date('Y-m-d');

            $latestEventsQuery = "SELECT * FROM events WHERE EventDate >= '$currentDate' ORDER BY EventDate ASC LIMIT 4";
            $latestEventsResult = mysqli_query($con, $latestEventsQuery);
            while ($row = mysqli_fetch_assoc($latestEventsResult)) {
              echo "<li> {$row['EventName']}</li>";
            }
            ?>
          </ul>
        </div>


      </div>
      <div class="Chart">
        <div class="canvas-container">
          <canvas id="eventsChart"></canvas>
          <canvas id="UserLoginChart"></canvas>
        </div>
      </div>

    </div>
  </section>

  <section class="Events-section sections" id="eventsContent">

    <div class="Header_text">Events</div>


    <div class="Body-Content">

      <div class="LHS-content">

        <div class="search">
          <input type="text" id="searchstringForEvents" name="search" placeholder="Search.." oninput="filterEvents()">
        </div>

        <div class="tile-container">
          <?php
          $icons = [
            'fa-solid fa-bitcoin-sign',
            'fa-solid fa-chart-line',
            'fa-solid fa-wallet',
            'fa-solid fa-computer-mouse',
            'fa-solid fa-lock',
            'fa-solid fa-gears',
            'fa-solid fa-sack-dollar',
            'fa-solid fa-hand-holding-dollar',
            'fa-solid fa-network-wired',
            'fa-solid fa-database',
          ];

          while ($row = mysqli_fetch_assoc($resultofFE)) {
            $randomIcon = $icons[array_rand($icons)];
            ?>


            <div class="tile" data-event-id="<?php echo $row['EventID'] ?>"
              data-event-name="<?php echo $row['EventName'] ?>"
              data-event-description="<?php echo $row['EventDescription'] ?>"
              data-event-location="<?php echo $row['EventLocation'] ?>" data-event-date="<?php echo $row['EventDate'] ?>"
              data-event-time="<?php echo $row['EventTime'] ?>" data-organizer-id="<?php echo $row['OrganizerID'] ?>"
              data-device-id="<?php echo $row['DeviceID'] ?>" data-event-status="<?php echo $row['EventStatus'] ?>">


              <div class="tile-header">
                <i class="<?php echo $randomIcon; ?>"></i>
              </div>

              <div class="tile-body">
                <strong>
                  <?php echo $row['EventName'] ?>
                </strong>
                <span class="Event-Desc">
                  <?php echo $row['EventDescription'] ?>
                </span>
                <div class="tile-footer">
                  <span class="Location"><i class="fa-solid fa-location-dot"></i> &nbsp
                    <?php echo $row['EventLocation']; ?>
                  </span>
                  <span class="Device"><i class="fa-solid fa-Device-dot"></i> &nbsp
                    <?php echo $row['DeviceName']; ?>
                  </span>
                  <span class="Organizer"><b><i class="fa-regular fa-id-card"></i> &nbsp </b>
                    <?php echo $row['Name']; ?>
                  </span>
                </div>
                <div class="tile-footer">
                  <span><b>Time:</b>
                    <?php echo $row['EventTime'] ?> <br>
                  </span>
                  <span><b>Date:</b>
                    <?php echo $row['EventDate'] ?> <br>
                  </span>
                  <span class="Organizer"><b>Status:</b>
                    <?php echo $row['EventStatus'] ?> <br>
                  </span>
                </div>
              </div>

            </div>

          <?php } ?>

        </div>

      </div>


      <div class="RHS-Content">
        <form id="eventForm" action="../Controller/Admin/Events/AddEvent.php" method="post">
          <input type="hidden" id="eventId" name="event_id">
          <input type="hidden" id="formAction" name="action" value="add">

          <label for="eventName">Event Name:</label>
          <input type="text" id="eventName" name="eventName" placeholder="Event Name" required>

          <label for="eventDescription">Event Description:</label>
          <input type="text" id="eventDescription" name="eventDescription" placeholder="Event DEscription" required>

          <label for="eventLocation">Location:</label>
          <input type="text" id="eventLocation" name="eventLocation" placeholder="Location" required>

          <label for="organizerName">Organizer Name:</label>
          <select id="organizerName" name="organizerName" required>
            <option value="">Select an Organizer</option>
            <?php
            $organizersQuery = "SELECT memberID, name FROM member";
            $organizersResult = mysqli_query($con, $organizersQuery);
            while ($organizer = mysqli_fetch_assoc($organizersResult)) {
              echo "<option value='{$organizer['memberID']}'>{$organizer['name']}</option>";
            }
            ?>
          </select>

          <label for="deviceName">Device Name:</label>
          <select id="deviceName" name="deviceName" required>
            <option value="">Select a Device</option>
            <?php
            $devicesQuery = "SELECT DeviceID, DeviceName, MemberID FROM devices";
            $devicesResult = mysqli_query($con, $devicesQuery);
            while ($device = mysqli_fetch_assoc($devicesResult)) {
              echo "<option value='{$device['DeviceID']}' data-member-id='{$device['MemberID']}'>{$device['DeviceName']}</option>";
            }
            ?>
          </select>

          <label for="eventTime">Time:</label>
          <input type="time" id="eventTime" name="eventTime" required>

          <label for="eventDate">Date:</label>
          <input type="date" id="eventDate" name="eventDate" required>

          <label for="eventStatus">Status:</label>
          <select id="eventStatus" name="eventStatus">
            <option value="Visible">Visible</option>
            <option value="Hidden">Hidden</option>
          </select>

          <div id="formButtons">

            <button type="button" id="updateEventbtn" style="display: none;">Update Event</button>
            <button type="button" id="deleteEventbtn" style="display: none;">Delete Event</button>

            <button type="submit" name="action" value="add" id="addEvent">Add Event</button>
          </div>


        </form>
      </div>

    </div>

  </section>

  <section class="Published_Event-section sections" id="PublishedEventsContent">
    <div class="Header_text">Published Events</div>
    <div class="Body_Content">
      <table class="PublishedEventsTable">
        <thead>
          <tr>
            <th>Event Name</th>
            <th>Description</th>
            <th>Date</th>
            <th>Time</th>
            <th>Location</th>
            <th>Organizer</th>
            <th>Device</th>
          </tr>
        </thead>
        <tbody>
          <?php
         while ($row = mysqli_fetch_assoc($visibleEventsResult)) {
          echo "<tr id='publishedEventRow_" . $row['EventID'] . "' onclick='toggleEventStatus(" . $row['EventID'] . ", \"" . $row['EventName'] . "\", \"Visible\")'>";
            echo "<td>" . $row['EventName'] . "</td>";
            echo "<td>" . $row['EventDescription'] . "</td>";
            echo "<td>" . $row['EventDate'] . "</td>";
            echo "<td>" . $row['EventTime'] . "</td>";
            echo "<td>" . $row['EventLocation'] . "</td>";
            echo "<td>" . $row['OrganizerName'] . "</td>";
            echo "<td>" . $row['DeviceName'] . "</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <div class="Header_text">Un-Published Events</div>
    <div class="Body_Content">
      <table class="UnpublishedEventsTable">
        <thead>
          <tr>
            <th>Event Name</th>
            <th>Description</th>
            <th>Date</th>
            <th>Time</th>
            <th>Location</th>
            <th>Organizer</th>
            <th>Device</th>
          </tr>
        </thead>
        <tbody>
          <?php
           while ($row = mysqli_fetch_assoc($hiddenEventsResult)) {
            echo "<tr id='unpublishedEventRow_" . $row['EventID'] . "' onclick='toggleEventStatus(" .$row['EventID'] . ", \"" . $row['EventName'] . "\", \"Hidden\")'>";
            echo "<td>" . $row['EventName'] . "</td>";
            echo "<td>" . $row['EventDescription'] . "</td>";
            echo "<td>" . $row['EventDate'] . "</td>";
            echo "<td>" . $row['EventTime'] . "</td>";
            echo "<td>" . $row['EventLocation'] . "</td>";
            echo "<td>" . $row['OrganizerName'] . "</td>";
            echo "<td>" . $row['DeviceName'] . "</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </section>

  <section class="Members-section sections" id="membersContnet">
    <div class="Header_text">Members</div>
<button class="add-member-btn" onclick="openNewMemberForm()">+</button>
    <div class="Body_content">
      <div class="search">
        <input type="text" id="searchstring" name="search" placeholder="Search.." oninput="filterSearch()">
      </div>

      <table class="Members_Data">
        <thead>
          <tr>
            <th>MemberID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>UserType</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($row = mysqli_fetch_assoc($resultofFM)) {
            if ($row["UserType"] == "member") {
            ?>
            <tr class="Member-Rows" data-member-id="<?php echo $row['MemberID']; ?>"
              onclick="openMemberPopup(<?php echo $row['MemberID']; ?>)">
              <td>
                <?php echo $row['MemberID'] ?>
              </td>
              <td>
                <?php echo $row['Name'] ?>
              </td>
              <td>
                <?php echo $row['Email'] ?>
              </td>
              <td class="Password_data">
                <?php echo $row['Password'] ?>
              </td>
              <td>
                <?php echo $row['UserType'] ?>
              </td>
            </tr>
            <?php }
          }
          ?>
        </tbody>
      </table>
          
          <table class="Admins_Data">
      <thead>
        <tr>
          <th>AdminID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Password</th>
          <th>UserType</th>
        </tr>
      </thead>
      <tbody>
        <?php
        mysqli_data_seek($resultofFM, 0); // Reset result pointer to beginning
        while ($row = mysqli_fetch_assoc($resultofFM)) {
          if ($row['UserType'] === 'admin') {
            ?>
            <tr>
              <td>
                <?php echo $row['MemberID'] ?>
              </td>
              <td>
                <?php echo $row['Name'] ?>
              </td>
              <td>
                <?php echo $row['Email'] ?>
              </td>
              <td class="Password_data">
                <?php echo $row['Password'] ?>
              </td>
              <td>
                <?php echo $row['UserType'] ?>
              </td>
            </tr>
          <?php }
        }
        ?>
      </tbody>
    </table>
    </div> 

    <dialog id="Member-Popup">
      <h2>Selected Member Details</h2>
      <form class="form-container" action="../Controller/Admin/Member/UpdateMember.php" method="post">


        <div class="form-row">
          <div class="form-group">
            <label for="selected-member-Id">Member ID:</label>
            <input type="text" id="selected-member-Id" name="memberid" readonly>
          </div>
          <div class="form-group">
            <label for="selected-member-Name">Name:</label>
            <input type="text" id="selected-member-Name" name="name">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="selected-member-Email" name="email" readonly>
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="text" id="selected-member-Password" name="password">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="usertype">User Type:</label>
            <select id="selected-member-UserType" name="usertype">
              <option value="member">Member</option>
              <option value="admin">Admin</option>
            </select>
          </div>
          <div class="submit">
            <input type="submit" value="Update" id="btnUpdate">
          </div>

        </div>
      </form>
      <button onclick="closeMemberPopup();" aria-label="close" class="x">❌</button>
    </dialog>


  </section>

  <section class="Login_History-section sections" id="LoginHistoryContent">
    <div class="Header_text">Login History Overview</div>

    <div class="Body-Content">
      <div class="LoginHistory-widgets">
        <div class="widgetofLH">
          <h2> Total Logins </h2>
          <p>
            <?php echo mysqli_num_rows($loginCountsResult); ?>
            <i class="fa-solid fa-sign-in-alt"></i>
          </p>
        </div>

        <div class="widgetofLH">
          <h2> Last 3 Logged ins : <i class="fa-regular fa-clock"></i> </h2>
          <ul style="margin-left:20px;">
            <?php

            while ($row = mysqli_fetch_assoc($lastThreeLoginsResult)) {
              echo "<li> {$row['Email']}</li>";
            }
            ?>
          </ul>
        </div>

        <div class="widgetofLH">
          <h2> Last Login </h2>
          <p>
            <?php echo $lastLoginTime; ?>
            <i class="fa-regular fa-clock"></i>
          </p>
        </div>

      </div>


      <div class="Header_text">Members with the Login history</div>
      <div class="MembersHistory">
        <div class="search">
          <input type="text" id="LoginDatasearchstring" name="search" placeholder="Search.."
            oninput="filterHistorySearch()">
        </div>

        <div class="member-tiles">
          <?php
          while ($row = mysqli_fetch_assoc($fetchAllMembersResult)) {
            $number = 1; ?>
            <div class="member-tile" data-member-id="<?php echo $row['MemberID']; ?>"
              onclick="toggleTile(this, <?php echo $row['MemberID']; ?>)">
              <h1>
                <?php echo $row['Name']; ?>
              </h1>
              <div id="LHDATA">
                <table>
                  <thead>
                    <tr>
                      <th>Number</th>
                      <th>Login Date & Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $memberId = $row['MemberID'];
                    $loginHistoryQuery = "SELECT LoginDT FROM LoginHistory WHERE MemberID = $memberId ORDER BY LoginDT DESC LIMIT 10";
                    $loginHistoryResult = mysqli_query($con, $loginHistoryQuery);

                    if (mysqli_num_rows($loginHistoryResult) > 0) {
                      while ($loginRow = mysqli_fetch_assoc($loginHistoryResult)) { ?>
                        <tr>
                          <td>
                            <?php echo $number++; ?>
                          </td>
                          <td>
                            <?php echo $loginRow['LoginDT']; ?>
                          </td>
                        </tr>
                      <?php }
                    } else { ?>
                      <tr>
                        <td colspan="2">No login history available</td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>

    </div>
  </section>

  <!-- <section class="Settings-section sections" id="settingsContent">>
    <div class="Header_text">Settings</div>

    <div class="Body_content">
      <div class="setting-option">
        <a href="../Model\Configurations\Logout.php"><button id="logout"> Logout <i class='bx bx-log-out'
              id="log_out"></i> </button></a>

      </div>

      <div class="setting-option">
        <label for="change-user-details">Change User Details:</label>
        <button id="change-user-details">Change</button>

      </div>

      <dialog id="Update-User-Details">
        <h2> Update Details</h2>
        <form method="post" action="../Controller/Admin/Settings/UpdateUserDetails.php">
          <label for="member_id">Member ID:</label>
          <input type="text" id="member_id" name="member_id" required><br><br>
          <label for="Name"> Update Name:</label>
          <input type="text" id="Name" name="Name" required> <br><br>
          <label for="Password"> Update Password:</label>
          <input type="text" id="Password" name="Password" required><br><br>
          <div class="buttons">
            <button id="cancel-update">Cancel</button>
            <button id="Submit" type="submit">Save Changes</button>
          </div>
        </form>
      </dialog>

      <div class="setting-option">
        <label for="turn-off-website">Turn off Website:</label>
        <button id="turn-off-website">Turn Off</button>

      </div>

      <div class="setting-option">
        <label for="DarkMode">Dark/Light Mode:</label>
        <button id="Mode" onclick="myFunction()">Dark Mode</button>
      </div>
    </div>



  </section> -->

  <section class="Settings-section sections" id="settingsContent">
    <div class="Header_text">Settings</div>
    <div class="Body-Content settings-content">
      <div class="setting-option">
        <a href="../Model\Configurations\Logout.php"><button id="logout"> Logout <i class='bx bx-log-out'
              id="log_out"></i> </button></a>

      </div>
      <div class="setting-item">
        <h3>User Details</h3>
        <p>Update your profile details</p>
        <button onclick="location.href='updateDetails.php'">Update Details</button>
      </div>

      <div class="setting-item theme-preview">
        <h3>Live Theme Preview</h3>
        <p>Preview how themes will look:</p>
        <div id="themePreview" class="preview-container">
          <div class="Pcontainer">
            <div class="preview-dashboard">
              <div class="preview-widget" id="previewWidget1">Widget 1</div>
              <div class="preview-widget" id="previewWidget2">Widget 2</div>
            </div>
          </div>
        </div>
        <button id="themePreviewToggle">Toggle Preview Theme</button>
      </div>


      <div class="setting-item">
        <h3>Theme Selection</h3>
        <p>Switch between Light and Dark mode</p>
        <button id="Mode">Toggle Theme</button>
      </div>
    </div>
  </section>


  <script>let eventsPerUserData = <?php echo json_encode($eventsPerUserData); ?>;
  </script>
  <script>
    const chartData = <?php echo json_encode($chartData); ?>;
  </script>

  <script>
    
    document.addEventListener('DOMContentLoaded', function () {
      var organizerSelect = document.getElementById('organizerName');
      var deviceSelect = document.getElementById('deviceName');
      var initialDevicesOptions = Array.from(deviceSelect.options);

      organizerSelect.addEventListener('change', function () {
        const selectedOrganizerId = this.value;
        while (deviceSelect.options.length > 1) deviceSelect.remove(1);


        initialDevicesOptions.forEach(function (option) {
          if (option.dataset.memberId === selectedOrganizerId) {
            deviceSelect.add(option.cloneNode(true));
          }
        });
      });
    });

    document.addEventListener('DOMContentLoaded', function () {
      document.getElementById('Mode').addEventListener('click', function myFunction() {
        var element = document.body;
        element.classList.toggle("dark-mode");
      });

      document.getElementById('themePreviewToggle').addEventListener('click', function togglePreviewTheme() {
        var previewContainer = document.getElementById('themePreview');
        previewContainer.classList.toggle("preview-dark-mode");
      });
    });

  </script>

  <script src="JS/Slidebar.js"></script>
  <script src="JS/Home.js"></script>
  <script src="JS/UEChart.js"></script>
  <script src="JS/ULChart.js"></script>
  <script src="../Controller/Admin/Dashboard/Dashboard.js"></script>
  <script src="../Controller/Admin/Dashboard/Search.js"></script>
  <script src="../Controller/Admin/Events/Filter_Events_Search.js"></script>
  <script src="../Controller/Admin/Events/UpdateEvent.js"></script>
  <script src="../Controller/Admin/Events/FetchEventtoUpdate.js"></script>
  <script src="../Controller/Admin/Events/AddEvent.js"></script>
  <script src="../Controller/Admin/PublishEvent/UpdateEventStatus.js"></script>
  <script src="../Controller/Admin/Member/SearchMember.js"></script>
  <script src="../Controller/Admin/Member/SelectRow.js"></script>
  <script src="../Controller/Admin/Member/Member_PopUp.js"></script>
  <script src="../Controller/Admin/LoginHistory/LoginHistory.js"></script>
  <script src="../Controller/Admin/LoginHistory/LoginHistorySearch.js"></script>
  <script src="../Controller/Admin/Settings/UpdateUserDetails.js"></script>
  <script src="../Controller/Admin/Settings/DarkMode.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>