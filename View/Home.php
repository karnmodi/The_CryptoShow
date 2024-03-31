<?php
session_start();

if (!isset($_SESSION['user_name'])) {

  header('Location: ../index.php');
  exit;
}

$userName = $_SESSION['user_name'];
require_once "../Model/Configurations/db.php";
$FetchAllMembers = "SELECT * from member";
$resultofFM = mysqli_query($con, $FetchAllMembers);

$FetchAllEvents = "SELECT e.EventID, e.EventDate, e.EventTime, e.EventLocation, m.Name, d.DeviceName, d.Description
FROM Events e
JOIN Member m ON e.OrganizerID = m.MemberID
JOIN Devices d ON e.DeviceID = d.DeviceID;";
$resultofFE = mysqli_query($con, $FetchAllEvents);

$eventsPerUserQuery = "SELECT m.Name, COUNT(e.EventID) as EventCount
                       FROM Events e
                       JOIN Member m ON e.OrganizerID = m.MemberID
                       GROUP BY e.OrganizerID;";
$eventsPerUserResult = mysqli_query($con, $eventsPerUserQuery);

$eventsPerUserData = [];
while ($row = mysqli_fetch_assoc($eventsPerUserResult)) {
  $eventsPerUserData[] = $row;
}

$loginCountsQuery = "
    SELECT m.Name, COUNT(l.LoginHistoryID) as LoginCount
    FROM member m
    LEFT JOIN loginhistory l ON m.MemberID = l.MemberID
    GROUP BY m.MemberID
";
$loginCountsResult = mysqli_query($con, $loginCountsQuery);

$chartData = [
  'userNames' => [],
  'loginCounts' => []
];

while ($row = mysqli_fetch_assoc($loginCountsResult)) {
  $chartData['userNames'][] = $row['Name'];
  $chartData['loginCounts'][] = $row['LoginCount'];
}
?>


?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin | The CryptoShow</title>
  <link rel="stylesheet" href="CSS/Admin/Home.css">
  <link rel="stylesheet" href="CSS/Admin/Dashboard.css">
  <link rel="stylesheet" href="CSS/Admin/Member.css">
  <link rel="stylesheet" href="CSS/Admin/Events.css">
  <link rel="stylesheet" href="CSS/Admin/Settings.css">
  <link rel="stylesheet" href="CSS/Admin/Updateform.css">

  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <a href="#Dashboard" onclick="showSection('Dashboard-section', this); ">
          <i class='bx bx-grid-alt'></i>
          <span class="Btns_Name">Dashboard</span>
        </a>
        <span class="SB_Btns">Dashboard</span>
      </li>

      <li>
        <a href="#Events" onclick="showSection('Events-section', this);">
          <i class='bx bx-pie-chart-alt-2'></i>
          <span class="Btns_Name">Events</span>
        </a>
        <span class="SB_Btns">Events</span>
      </li>

      <li>
        <a href="#Devices" onclick="showSection('Devices-section', this);">
          <i class='bx bx-chat'></i>
          <span class="Btns_Name">Devices</span>
        </a>
        <span class="SB_Btns">Devices</span>
      </li>


      <li>
        <a href="#Members" onclick="showSection('Members-section' , this);">
          <i class='bx bx-user'></i>
          <span class="Btns_Name">Members</span>
        </a>
        <span class="SB_Btns">Members</span>
      </li>

      <li>
        <a href="#Reviews" onclick="showSection('Review-section' , this);">
          <i class='bx bx-folder'></i>
          <span class="Btns_Name">Review</span>
        </a>
        <span class="SB_Btns">Review</span>
      </li>

      <li>
        <a href="#Settings" onclick="showSection('Settings-section' , this);">
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

      <div class="Revenue-Member-Container">

        <div class="Revenue-widget">
          <h2> Revenue </h3>
            <p>$
              <?php echo rand(1000, 50000); ?>
            </p>
        </div>

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
      </div>
      <div class="Chart">
        <div class="Canvas-Container">
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
          while ($row = mysqli_fetch_assoc($resultofFE)) {



            ?>
            <div class="tile" data-event-id="<?php echo $row['EventID']; ?>"
              onclick="openUpdateEventDialog(<?php echo $row['EventID']; ?>)">
              <div class="tile-header">

              </div>

              <div class="tile-body">
                <strong>Event :
                  <?php echo $row['EventID'] ?>
                </strong>
                <span class="Event-Desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam,
                  praesentium.</span>
                <div class="tile-footer">
                  <span class="Location"><i class="fa-solid fa-location-dot"></i> &nbsp
                    <?php echo $row['EventLocation']; ?>
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
                </div>
              </div>

            </div>

          <?php } ?>

        </div>

      </div>

      <div class="RHS-Content">


      </div>

    </div>

  </section>

  <section class="Devices-section sections" id="devicesContnet">
    <div class="Header_text">Devices</div>
  </section>

  <section class="Members-section sections" id="membersContnet">
    <div class="Header_text">Members</div>

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
            <?php
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

  <section class="Review-section sections" id="reviewContent">
    <div class="Header_text">Review</div>
  </section>

  <section class="Settings-section sections">
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



  </section>

  <script>let eventsPerUserData = <?php echo json_encode($eventsPerUserData); ?>;
  </script>
  <script>
    const chartData = <?php echo json_encode($chartData); ?>;
  </script>


  <script src="JS/Slidebar.js"></script>
  <script src="JS/Home.js"></script>
  <script src="JS/UEChart.js"></script>
  <script src="JS/ULChart.js"></script>
  <script src="../Controller/Admin/Member/SearchMember.js"></script>
  <script src="../Controller/Admin/Member/SelectRow.js"></script>
  <script src="../Controller/Admin/Member/Member_PopUp.js"></script>
  <script src="../Controller/Admin/Events/Filter_Events_Search.js"></script>
  <script src="../Controller/Admin/Dashboard/Dashboard.js"></script>
  <script src="../Controller/Admin/Dashboard/Search.js"></script>
  <script src="../Controller/Admin/Settings/UpdateUserDetails.js"></script>
  <script src="../Controller/Admin/Settings/DarkMode.js"></script>
  <script src="../Controller/Admin/Events/AddEvent.js"></script>
  <script src="../Controller/Admin/Events/UpdateEvent.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>