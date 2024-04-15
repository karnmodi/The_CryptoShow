<?php
session_start();

if (!isset($_SESSION['user_name']) || !isset($_SESSION['member_id'])) {
  header('Location: ../index.php');
  exit;
}

require_once "../Model/Configurations/db.php";

$loggedInMemberID = $_SESSION['member_id'];
$userName = $_SESSION['user_name'];

$loggedInUserQuery = "SELECT Name, Email, Password FROM Member WHERE MemberID = ?";
$stmt = $con->prepare($loggedInUserQuery);
$stmt->bind_param("i", $loggedInMemberID);
$stmt->execute();
$loggedInUserResult = $stmt->get_result();

if ($row = $loggedInUserResult->fetch_assoc()) {
    $name = htmlspecialchars($row['Name']);
    $email = htmlspecialchars($row['Email']);
    $password = htmlspecialchars($row['Password']);
}


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
    SELECT d.DeviceID, d.DeviceName, d.Description, e.EventName, e.EventDate, e.EventTime
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

$fetchDeviceDetailsQuery = "
    SELECT d.DeviceID, d.DeviceName, d.Description, de.EventID, e.EventName, e.EventDate, e.EventTime
    FROM Devices d
    LEFT JOIN eventdevice de ON d.DeviceID = de.DeviceID
    LEFT JOIN Events e ON de.EventID = e.EventID
    WHERE d.MemberID = ?
";
$stmt = $con->prepare($fetchDeviceDetailsQuery);
$stmt->bind_param("i", $loggedInMemberID);
$stmt->execute();
$fetchDeviceDetailsResult = $stmt->get_result();


$fetchDeviceEventsQuery = "
SELECT 
    e.EventID, 
    e.EventName, 
    e.EventDescription, 
    e.EventDate, 
    e.EventTime, 
    e.EventLocation, 
    e.OrganizerID, 
    e.EventStatus, 
    m.Name AS OrganizerName, 
    CONCAT_WS(', ', GROUP_CONCAT(d.DeviceName SEPARATOR ', ')) AS DeviceNames
FROM 
    Events e
JOIN 
    Member m ON e.OrganizerID = m.MemberID
JOIN 
    EventDevice ed ON e.EventID = ed.EventID
JOIN 
    Devices d ON ed.DeviceID = d.DeviceID
WHERE
    d.MemberID = ?
GROUP BY 
    e.EventID
";
$stmt = $con->prepare($fetchDeviceEventsQuery);
$stmt->bind_param("i", $loggedInMemberID);
$stmt->execute();
$deviceParticipationResult = 
$resultofFE = $stmt->get_result();
$numResults = mysqli_num_rows($resultofFE);


$deviceParticipationQuery = "
    SELECT 
        d.DeviceName, 
        COUNT(ed.EventID) AS EventCount
    FROM 
        Devices d
    LEFT JOIN 
        EventDevice ed ON d.DeviceID = ed.DeviceID
    WHERE 
        d.MemberID = ?
    GROUP BY 
        d.DeviceID
";
$stmt = $con->prepare($deviceParticipationQuery);
$stmt->bind_param("i", $loggedInMemberID);
$stmt->execute();
$deviceParticipationResult = $stmt->get_result();

?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>User : <?php echo $userName ?> | The CryptoShow</title>
  <link rel="stylesheet" href="CSS/Admin/Home.css">
  <link rel="stylesheet" href="CSS/User/Events.css">
  <link rel="stylesheet" href="CSS/Admin/Dashboard.css">
  <link rel="stylesheet" href="CSS/Admin/Events.css">
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
              <?php echo $username; ?>
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
          <h2> Total Participated Events</h2>
          <p>
            <?php echo $numResults; ?>
            <i class="fa-regular fa-calendar-days"></i>
          </p>

        </div>
      </div>

      <div class="Latest-Container">

        <div class="Latest-Member-Widget">
          <h2>Last 5 Logins</h2>
          <ul>
            <?php
            $lastFiveLoginsQuery = " SELECT m.Email, l.LoginDT FROM member m INNER JOIN loginhistory l ON m.MemberID = l.MemberID WHERE m.MemberID = ? ORDER BY l.LoginDT DESC LIMIT 5 ";

            $stmt = $con->prepare($lastFiveLoginsQuery);
            $stmt->bind_param("i", $loggedInMemberID);
            $stmt->execute();
            $lastFiveLoginsResult = $stmt->get_result();

            while ($row = $lastFiveLoginsResult->fetch_assoc()) {
              echo "<li>{$row['LoginDT']}</li>";
            }
            ?>
          </ul>
        </div>



        <div class="Upcoming-Events-widget">
          <h2> Upcoming Events : </h2>
          <ul style="margin-left:20px;">
            <?php
            $currentDate = date('Y-m-d');

            $fetchUpcomingEventsQuery = " SELECT  e.EventName FROM  Events e INNER JOIN  EventDevice ed ON e.EventID = ed.EventID WHERE  e.EventDate >= '$currentDate' GROUP BY  e.EventID ORDER BY  e.EventDate ASC LIMIT 4 ";

            $result = mysqli_query($con, $fetchUpcomingEventsQuery);

            while ($row = mysqli_fetch_assoc($result)) {
              echo "<li>{$row['EventName']}</li>";
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


      <div class="Header">
        <div class="widget-Devices" style="float:left;">
          <h2> Total Devices </h2>
          <p style="Font-size : 25px; font-weight:bold;">
            <?php echo $totalDevicesCount; ?>
            <i class="fa-solid fa-people-group"></i>
          </p>
        </div>
        <div class="add-icon" onclick="toggleNewDeviceForm()">
          <i class="fa-solid fa-plus"></i>
        </div>
        <div class="search">
          <input type="text" id="SearchDevices" name="search" placeholder="Search by Device Name.."
            oninput="filterDeviceSearch()">
        </div>
      </div>

      <div class="NewDevice_form-container" id="NewDeviceForm">
        
        <form method="POST" action="../Controller\User\Device\AddDevice.php" class="form-content">
          <i class="fa fa-window-close x" onclick="closeNewDeviceForm()" title="Close Form"></i>
          <label for="newDeviceName">Device Name:</label>
          <input type="text" id="newDeviceName" name="newDeviceName" required>

          <label for="newDeviceDescription">Device Description:</label>
          <input type="text" id="newDeviceDescription" name="newDeviceDescription">

          <label for="newDeviceEvents">Existing Events to Register:</label>
          <select id="newDeviceEvents" name="newDeviceEvents[]" multiple size="3">
            <?php
            $fetchAllEventsQuery = "SELECT EventID, EventName, EventDate, EventTime FROM Events";
            $fetchAllEventsResult = mysqli_query($con, $fetchAllEventsQuery);
            if ($fetchAllEventsResult) {
              while ($eventRow = mysqli_fetch_assoc($fetchAllEventsResult)) {
                ?>
                <option value="<?php echo htmlspecialchars($eventRow['EventID']); ?>">
                  <?php echo htmlspecialchars($eventRow['EventName'] . ' - ' . $eventRow['EventDate'] . ' , ' . $eventRow['EventTime']); ?>
                </option>
                <?php
              }
            } else {
              echo "<option value=''>Error fetching events</option>";
            }
            ?>
          </select>

          <button type="submit">Create Device</button>
        </form>
      </div>

      <br><br>
      <br><br>

      <div class="Header_text">Your Devices</div>
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
              <h5>
                <?php echo htmlspecialchars($deviceRow['Description']); ?>
              </h5>

              <div id="EDDATA_<?php echo htmlspecialchars($deviceRow['DeviceID']); ?>" class="EDDTAC">
                <i class="fa-solid fa-eye pencil-icon" title="View All Events"
                  onclick="event.stopPropagation(); fetchAllEvents('<?php echo htmlspecialchars($deviceRow['DeviceID']); ?>');"></i>

                <i class="fa-solid fa-square-check update-icon" onclick="reloadPage()"
                  id="iconUpdateDevice_<?php echo htmlspecialchars($deviceRow['DeviceID']); ?>" style="display:none;"
                  title="Reload the Page"></i>

                <i class="fa fa-trash DeleteDevice-icon" aria-hidden="true"
                  id="DeleteDevice<?php echo htmlspecialchars($deviceRow['DeviceID']); ?>"
                  onclick="deleteDevice(<?php echo htmlspecialchars($currentDeviceID); ?>)"></i>

                <i class="fas fa-pencil-alt edit-icon" style="display: block;" title="Edit this Device"
                  onclick="toggleEditDeviceForm('<?php echo htmlspecialchars($deviceRow['DeviceID']); ?>')"
                  id="EDITForm_ICON_<?php echo htmlspecialchars($deviceRow['DeviceID']); ?>"></i>

                  
                <div class="EditDevice_form-container"
                  id="EditDeviceForm<?php echo htmlspecialchars($deviceRow['DeviceID']); ?>" style="display: none;">

                  <i class="fa fa-window-close closeform-icon" style="display: block;" title="Close Edits"
                    onclick="closeEditDeviceForm('<?php echo htmlspecialchars($deviceRow['DeviceID']); ?>')"
                    id="CloseForm_ICON_<?php echo htmlspecialchars($deviceRow['DeviceID']); ?>"></i>

                  <form method="POST" action="../Controller\User\Device\UpdateDevice.php">
                    <input type="hidden" name="deviceId" value="<?php echo htmlspecialchars($deviceRow['DeviceID']); ?>">
                    <label for="deviceName">Device Name:</label>
                    <input type="text" id="deviceName" name="deviceName" required
                      value="<?php echo htmlspecialchars($deviceRow['DeviceName']); ?>">
                    <label for="deviceDescriptionEdit">Device Description:</label>
                    <input type="text" id="deviceDescriptionEdit" name="deviceDescriptionEdit"
                      value="<?php echo htmlspecialchars($deviceRow['Description']); ?>">
                    <label for="Event_Registered_at">Existing Events to Register:</label>
                    <select id="Event_Registered_at" name="Event_Registered_at[]" multiple size="3">
                    <!-- <option value="">None of them.</option> -->
                      <?php
                      $fetchAllEventsQuery = "SELECT EventID, EventName, EventDate, EventTime FROM Events";
                      $fetchAllEventsResult = mysqli_query($con, $fetchAllEventsQuery);
                      if ($fetchAllEventsResult) {
                        while ($eventRow = mysqli_fetch_assoc($fetchAllEventsResult)) {
                          ?>
                          <option value="<?php echo htmlspecialchars($eventRow['EventID']); ?>">
                            <?php echo htmlspecialchars($eventRow['EventName'] . ' - ' . $eventRow['EventDate'] . ' , ' . $eventRow['EventTime']); ?>
                          </option>
                          <?php
                        }
                      } else {
                        echo "<option value=''>Error fetching events</option>";
                      }
                      ?>
                    </select>
                    <button type="submit">Submit</button>
                  </form>

                </div>


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

  <section class="Events-section sections" id="eventsContent">

    <div class="Header_text">Events</div>


    <div class="Body-Content">

      <div class="LHS-content">

        <div class="search">
          <input type="text" id="searchstringForEvents" name="search" placeholder="Search by Event Related anything.."
            oninput="filterEvents()">
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



          while ($row = mysqli_fetch_assoc($resultofFE)):
            $randomIcon = $icons[array_rand($icons)]; ?>

            <div class="tile" data-event-id="<?php echo $row['EventID'] ?>"
              data-event-name="<?php echo $row['EventName'] ?>"
              data-event-description="<?php echo $row['EventDescription'] ?>"
              data-event-location="<?php echo $row['EventLocation'] ?>" data-event-date="<?php echo $row['EventDate'] ?>"
              data-event-time="<?php echo $row['EventTime'] ?>" data-organizer-id="<?php echo $row['OrganizerID'] ?>"
              data-event-status="<?php echo $row['EventStatus'] ?>">
              <div class="tile-header">
                <i class="<?php echo $randomIcon; ?>"></i>
              </div>
              <div class="tile-body">
                <strong><?php echo $row['EventName'] ?> <span class="Event-Desc"
                    style="font-weight:normal; float : right;">Desc :
                    <?php echo $row['EventDescription'] ?></span>
                </strong>

                <div class="tile-footer">
                  <span class="Location"><i class="fa-solid fa-location-dot"></i> &nbsp
                    <?php echo $row['EventLocation']; ?>
                  </span>

                  <span class="Organizer"><b><i class="fa-regular fa-id-card"></i> &nbsp </b>
                    <?php echo $row['OrganizerName']; ?>
                  </span>

                  <div>
                    <span>
                      <?php echo $row['EventTime'] ?> <br>
                    </span>
                    <span>
                      <?php echo $row['EventDate'] ?> <br>
                    </span>
                  </div>

                </div>

                <div class="tile-footer">
                  <div style="float :left;">
                    Your Registred Devices :<br>
                    <span class="ALLREGEDDEVICES"><i class="fa-solid fa-Device-dot"></i> &nbsp
                      <b><?php echo $row['DeviceNames']; ?></b>
                    </span>
                  </div>

                  <span class="EventStatus <?php echo $row['EventStatus'] === 'Visible' ? 'visible' : 'not-visible'; ?>"
                    style="float: right;">
                    <b>Status:</b>
                    <?php echo $row['EventStatus'] ?> <br>
                  </span>

                </div>
              </div>
            </div>
          <?php endwhile; ?>

        </div>

      </div>

      <div class="RHS-ContentUser full-width">
        <span id="EventName"></span>
        <Span id="EventDescription"></Span>
        <br>
        <span id="EventLocation"></span>
        <span id="EventDate"></span>
        <span id="EventTime"></span>
        <br>
        <span id="EventVisibility"></span>
        <br>
        <span id="EventDevices"></span>
      </div>


    </div>

  </section>

  <section class="Settings-section sections" id="settingsContent">
    <div class="Header_text">Settings</div>
    <div class="Body-Content settings-content">
      <div class="setting-option">
        <a href="../Model\Configurations\Logout.php"><button id="logout"> Logout <i class='bx bx-log-out'
              id="log_out"></i> </button></a>

      </div>
      <div class="setting-item">
        <h3>Profile Details</h3>
        <p>Update your profile details</p>
        <p>
          Your Name : <?php echo $userName ?><br>
          Your Email : <?php echo $email ?><br>
          Your Password : <?php echo $password ?><br>
        </p>
        <button id="update-details-btn">Update Details</button>
        <div class="Details-form" id="DetailsForm">
          <h2>Update Deatails</h2>
          <form method="post" action="../Controller/Admin/Settings/UpdateDetails.php">
            <label for="MemberID">MemberID:</label>
            <input type="text" id="MemberID" name="memberid" value="<?php echo $loggedInMemberID; ?>" readonly required>
            <label for="Name">Name:</label>
            <input type="text" id="Name" name="name" value="<?php echo $name; ?>" required>
            <label for="Email">Email:</label>
            <input type="text" id="Email" name="email" value="<?php echo $email; ?>" required>
            <label for="Password">Password:</label>
            <input type="text" id="Password" name="password" value="<?php echo $password; ?>" required>
            <div class="buttons">
              <button onclick="CloseDetailsForm()">Cancel</button>
              <button id="submit-details" type="submit">Save Details</button>
            </div>
          </form>
        </div>
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
      // Arrays to store device names and event counts
      var deviceNames = [];
      var eventCounts = [];

      // Loop through PHP result and push device names and event counts to arrays
      <?php
      while ($row = mysqli_fetch_assoc($deviceParticipationResult)) {
        echo "deviceNames.push('{$row['DeviceName']}');";
        echo "eventCounts.push({$row['EventCount']});";
      }
      ?>

      // Create pie chart
      var ctx = document.getElementById('eventsChart').getContext('2d');
      var eventsChart = new Chart(ctx, {
        type: 'pie',
        data: {
          labels: deviceNames,
          datasets: [{
            label: 'Device Participation in Events',
            data: eventCounts,
            backgroundColor: [
              'rgba(255, 99, 132, 0.5)', // Red
              'rgba(54, 162, 235, 0.5)', // Blue
              'rgba(255, 206, 86, 0.5)', // Yellow
              'rgba(75, 192, 192, 0.5)', // Green
              'rgba(153, 102, 255, 0.5)', // Purple
              'rgba(255, 159, 64, 0.5)' // Orange
            ],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          title: {
            display: true,
            text: 'Device Participation in Events'
          }
        }
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
  <script src="../Controller\User\Events\FetchEventsDataRHS.js"></script>
  <script src="../Controller\User\Device\Search.js"></script>
  <script src="../Controller/Admin/Dashboard/Dashboard.js"></script>
  <script src="../Controller/Admin/Dashboard/Search.js"></script>
  <script src="../Controller/Admin/Events/Filter_Events_Search.js"></script>
  <script src="../Controller/Admin/Events/UpdateEvent.js"></script>
  <script src="../Controller/Admin/Events/FetchEventtoUpdate.js"></script>
  <script src="../Controller/Admin/Events/AddEvent.js"></script>
  <script src="../Controller/Admin/Settings/UpdateDetails.js"></script>
  <script src="../Controller/Admin/Settings/DarkMode.js"></script>


  <script src="../Controller/User/Device/EventDevice.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>