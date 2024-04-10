<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_name']) || !isset($_SESSION['member_id'])) {
  header('Location: ../index.php');
  exit;
}

// Database connection
require_once "../Model/Configurations/db.php";

// Assuming member ID is stored in the session when the user logs in
$loggedInMemberID = $_SESSION['member_id'];

// Query to fetch login history chart data for logged-in member
$loginHistoryChartQuery = "
    SELECT m.Name, COUNT(l.LoginHistoryID) as LoginCount
    FROM member m
    LEFT JOIN loginhistory l ON m.MemberID = l.MemberID
    WHERE m.MemberID = ?
    GROUP BY m.MemberID
";
$stmt = $con->prepare($loginHistoryChartQuery);
$stmt->bind_param("i", $loggedInMemberID);
$stmt->execute();
$loginHistoryChartResult = $stmt->get_result();

$chartData = ['userNames' => [], 'loginCounts' => []];

while ($row = $loginHistoryChartResult->fetch_assoc()) {
  $chartData['userNames'][] = $row['Name'];
  $chartData['loginCounts'][] = $row['LoginCount'];
}

// Example of modifying the Fetch All Events query
$FetchAllEvents = "
    SELECT e.EventID, e.EventName, e.EventDescription, e.EventDate, e.EventTime, e.EventLocation, e.OrganizerID, e.DeviceID, e.EventStatus, m.Name, d.DeviceName, d.Description
    FROM Events e
    JOIN Member m ON e.OrganizerID = m.MemberID
    JOIN Devices d ON e.DeviceID = d.DeviceID
    WHERE e.OrganizerID = ?
";
$stmt = $con->prepare($FetchAllEvents);
$stmt->bind_param("i", $loggedInMemberID);
$stmt->execute();
$resultofFE = $stmt->get_result();

// Fetching all the members in a Member Section
$FetchAllMembers = "SELECT * from member";
$resultofFM = mysqli_query($con, $FetchAllMembers);

$loginCountsQuery = "
    SELECT COUNT(l.LoginHistoryID) as LoginCount
    FROM member m
    LEFT JOIN loginhistory l ON m.MemberID = l.MemberID
    GROUP BY l.LoginHistoryID
";

$loginCountsResult = mysqli_query($con, $loginCountsQuery);



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


// ------------------------------------------- 

// Total Devices count 
$totalDevicesQuery = "SELECT COUNT(*) AS totalDevices FROM devices WHERE MemberID = ?";
$stmt = $con->prepare($totalDevicesQuery);
$stmt->bind_param("i", $loggedInMemberID);
$stmt->execute();
$totalDevicesResult = $stmt->get_result();
$totalDevicesRow = $totalDevicesResult->fetch_assoc();
$totalDevicesCount = $totalDevicesRow['totalDevices'];

$totalEventsQuery = "SELECT COUNT(*) AS totalEvents FROM events WHERE OrganizerID = ?";
$stmt = $con->prepare($totalEventsQuery);
$stmt->bind_param("i", $loggedInMemberID);
$stmt->execute();
$totalEventsResult = $stmt->get_result();
$totalEventsRow = $totalEventsResult->fetch_assoc();
$totalEventsCount = $totalEventsRow['totalEvents'];

$fetchAllDevicesWithEventsQuery = "
    SELECT d.DeviceID, d.DeviceName, e.EventName, e.EventDate, e.EventTime
    FROM Devices d
    LEFT JOIN EventDevice ed ON d.DeviceID = ed.DeviceID
    LEFT JOIN Events e ON ed.EventID = e.EventID
    WHERE d.MemberID = ?
    ORDER BY d.DeviceID, e.EventDate, e.EventTime ASC
";
$stmt = $con->prepare($fetchAllDevicesWithEventsQuery);
$stmt->bind_param("i", $loggedInMemberID);
$stmt->execute();
$fetchAllDevicesResult = $stmt->get_result();
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
  <link rel="stylesheet" href="CSS/Admin/Updateform.css">
  <link rel="stylesheet" href="CSS/User/Devices.css">

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
        <a href="javascript:void(0);" onclick="showSection('devicesContent');">
          <i class='bx bx-chat'></i>
          <span class="Btns_Name">Devices</span>
        </a>
        <span class="SB_Btns">Devices</span>
      </li>

      <li>
        <a href="javascript:void(0);" onclick="showSection('eventsContent');">
          <i class='bx bx-pie-chart-alt-2'></i>
          <span class="Btns_Name">Events</span>
        </a>
        <span class="SB_Btns">Events</span>
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
          <h2> Total Devices </h2>
          <p>
            <?php echo $totalDevicesCount; ?>
            <i class="fa-solid fa-people-group"></i>
          </p>
        </div>


        <div class="event-widget">
          <h2> Total Events Schedules</h2>
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

  <section class="Devices-section sections" id="devicesContent">
    <div class="Header_text">Devices</div>
    <div class="Body_Content">

      <div class="MembersHistory">
        <div class="search">
          <input type="text" id="LoginDatasearchstring" name="search" placeholder="Search.."
            oninput="filterHistorySearch()">
        </div>
      </div>


      <div class="device-tiles">
        <?php
        $currentDeviceID = null;
        while ($deviceRow = mysqli_fetch_assoc($fetchAllDevicesResult)) {
          if ($currentDeviceID !== $deviceRow['DeviceID']) {
            if ($currentDeviceID !== null) {
              echo '</tbody></table></div></div>';
            }
            $currentDeviceID = $deviceRow['DeviceID'];
            ?>
            <div class="device-tile" data-device-id="<?php echo htmlspecialchars($deviceRow['DeviceID']); ?>"
              onclick="toggleDeviceTile(this, '<?php echo htmlspecialchars($deviceRow['DeviceID']); ?>')">
              <h1>
                <?php echo htmlspecialchars($deviceRow['DeviceName']); ?>
              </h1>

              <div id="EDDATA_<?php echo htmlspecialchars($deviceRow['DeviceID']);?>" class="EDDTAC">
                <i class="fas fa-pencil-alt pencil-icon"
                onclick="event.stopPropagation(); fetchAllEvents('<?php echo htmlspecialchars($deviceRow['DeviceID']); ?>');"></i>
                <i class="fa-solid fa-square-check update-icon"
                onclick="event.stopPropagation(); fetchAllRegEvents('<?php echo htmlspecialchars($deviceRow['DeviceID']); ?>');"
                id="iconUpdateDevice_<?php echo htmlspecialchars($deviceRow['DeviceID']); ?>" style="display:none;"></i>
                <p>This device is registered at these events Below</p>

                <table>
                  <thead>
                    <tr>
                      <th>Number</th>
                      <th>Event Name</th>
                      <th>Event Date</th>
                      <th>Event Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $number = 1;
          }
          if ($deviceRow['EventName']) {
            ?>
                    <tr>
                      <td>
                        <?php echo $number++; ?>
                      </td>
                      <td>
                        <?php echo htmlspecialchars($deviceRow['EventName']); ?>
                      </td>
                      <td>
                        <?php echo htmlspecialchars($deviceRow['EventDate']); ?>
                      </td>
                      <td>
                        <?php echo htmlspecialchars($deviceRow['EventTime']); ?>
                      </td>
                    </tr>
                    <?php
          }
        }
        if ($currentDeviceID !== null) {
          echo '</tbody></table></div></div>';
        } else {
          ?>
                  <p>No devices found.</p>
                  <?php
        }
        ?>
          </div>

        </div>

      </div>

    </div>


  </section>

  <div></div>


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


  <script src="../Controller/User/Device/EventDevice.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>