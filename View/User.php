<?php
session_start();

if (!isset ($_SESSION['user_name'])) {

  header('Location: ../index.php');
  exit;
}

$userName = $_SESSION['user_name'];
require_once ("../Model/Configurations/db.php");
$FetchAllMembers = "SELECT * from member";
$resultofFM = mysqli_query($con, $FetchAllMembers);

$FetchAllEvents = "SELECT e.EventID, e.EventDate, e.EventTime, e.EventLocation, m.Name, d.DeviceName, d.Description
FROM Events e
JOIN Member m ON e.OrganizerID = m.MemberID
JOIN Devices d ON e.DeviceID = d.DeviceID;";
$resultofFE = mysqli_query($con, $FetchAllEvents);

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>User | The CryptoShow</title>
  <link rel="stylesheet" href="CSS/Admin/Home.css">
  <link rel="stylesheet" href="CSS/Admin/Events.css">
  <link rel="stylesheet" href="CSS/Admin/Settings.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
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
        <a href="#Devices" onclick="showSection('Devices-section', this);">
          <i class='bx bx-chat'></i>
          <span class="Btns_Name">Devices</span>
        </a>
        <span class="SB_Btns">Devices</span>
      </li>

      <li>
        <a href="#Events" onclick="showSection('Events-section', this);">
          <i class='bx bx-pie-chart-alt-2'></i>
          <span class="Btns_Name">Events</span>
        </a>
        <span class="SB_Btns">Events</span>
      </li>

      <li>
        <a href="#Settings" onclick="showSection('Settings-section' , this);">
          <i class='bx bx-cog'></i>
          <span class="Btns_Name">Settings</span>
        </a>
        <span class="SB_Btns">Settings</span>
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

  <section class="Dashboard-section sections">
    <div class="Header_text">Dashboard</div>

  </section>

  <section class="Events-section sections">
    <div class="Header_text">Events</div>

    <?php
        $count = 0;
        while ($row = mysqli_fetch_assoc($resultofFE)) {
            if ($count % 4 == 0) {
                echo '<div class="container">';
            }
        ?>
            <div class="Event-Cards" data-event-id="<?php echo $row['EventID']; ?>">
                <div class="content">
                    <div class="EventDetails">
                        <h2><?php echo $row['EventID'] ?></h2>
                        <span><b>Date:</b> <?php echo $row['EventDate'] ?> <br></span>
                        <span><b>Time:</b> <?php echo $row['EventTime'] ?> <br></span>
                        <span><b>Location:</b> <?php echo $row['EventLocation'] ?> <br></span>
                        <span><b>Organizer: </b><?php echo $row['Name']; ?></span>
                    </div>
                </div>
                <div class="Heading">
                    <h2>Event </h2>
                    <h3><?php echo $row['EventID'] ?></h3>
                </div>
            </div>
        <?php
            $count++;
          
            if ($count % 4 == 0) {
                echo '</div>';
            }
        }
        if ($count % 4 != 0) {
            echo '</div>';
        }
        ?>


  </section>

  <section class="Devices-section sections">
    <div class="Header_text">Devices</div>
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

      <div class="setting-option">
        <label for="turn-off-website">Turn off Website:</label>
        <button id="turn-off-website">Turn Off</button>
      </div>
    </div>



  </section>

  <script src="JS/Slidebar.js"></script>
  <script src="JS/Home.js"></script>
  <script src="../Controller/Admin/Member/SearchMember.js"></script>
  <script src="../Controller/Admin/Member/SelectRow.js"></script>
  <script src="../Controller/Admin/Events/RandomClrs.js"></script>

  <script>
    function openMemberPopup(memberID) {
      var dialog = document.getElementById('Member-Popup');
      dialog.showModal();
    }
    function closeMemberPopup() {
      var dialog = document.getElementById('Member-Popup');
      dialog.close();
    }
  </script>

</body>

</html>