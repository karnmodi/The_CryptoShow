<?php
session_start();

if (!isset($_SESSION['user_name'])) {
  // Redirect to the login page if the user is not logged in
  header('Location: ../index.php');
  exit;
}

$userName = $_SESSION['user_name'];
require_once("../Model/Configurations/db.php");
$query = "SELECT * from member";
$result = mysqli_query($con, $query);

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin | The CryptoShow</title>
  <link rel="stylesheet" href="CSS/Admin/Home.css">
  <link rel="stylesheet" href="CSS/Admin/Member.css">
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
        <a href="#Dashboard" onclick="showSection('Dashboard-section', this); toggleActive(this); ">
          <i class='bx bx-grid-alt'></i>
          <span class="Btns_Name">Dashboard</span>
        </a>
        <span class="SB_Btns">Dashboard</span>
      </li>

      <li>
        <a href="#Schedules" onclick="showSection('Schedules-section', this); toggleActive(this);">
          <i class='bx bx-chat'></i>
          <span class="Btns_Name">Schedules</span>
        </a>
        <span class="SB_Btns">Schedules</span>
      </li>

      <li>
        <a href="#Events" onclick="showSection('Events-section', this); toggleActive(this);">
          <i class='bx bx-pie-chart-alt-2'></i>
          <span class="Btns_Name">Events</span>
        </a>
        <span class="SB_Btns">Events</span>
      </li>

      <li>
        <a href="#Members" onclick="showSection('Members-section' , this); toggleActive(this);">
          <i class='bx bx-user'></i>
          <span class="Btns_Name">Members</span>
        </a>
        <span class="SB_Btns">Members</span>
      </li>

      <li>
        <a href="#Reviews" onclick="showSection('Review-section' , this); toggleActive(this);">
          <i class='bx bx-folder'></i>
          <span class="Btns_Name">Review</span>
        </a>
        <span class="SB_Btns">Review</span>
      </li>

      <li>
        <a href="#" onclick="showSection('Settings-section' , this); toggleActive(this);">
          <i class='bx bx-cog'></i>
          <span class="Btns_Name">Setting</span>
        </a>
        <span class="SB_Btns">Setting</span>
      </li>

      <li class="profile">
        <div class="profile-details">
          <img src="../Assets/Website Images/Github Logo PNG.png" alt="profileImg">
          <div class="name_job">
            <div class="name"><?php echo $userName; ?></div>
            <div class="position">Student</div>
          </div>
        </div>
        <a href="../Model\Configurations\Logout.php"><i class='bx bx-log-out' id="log_out"></i></a>
      </li>
    </ul>
    <div id="activeIndicator" class="active-indicator"></div>
  </div>
  <section class="Dashboard-section sections">
    <div class="Header_text">Dashboard</div>

  </section>

  <section class="Schedules-section sections">
    <div class="Header_text">Scehdules</div>
  </section>

  <section class="Events-section sections">
    <div class="Header_text">Events</div>
  </section>

  <section class="Members-section sections">
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
          <tr>
            <?php

            while ($row = mysqli_fetch_assoc($result)) {

              ?>

              <td>
                <?php echo $row['MemberID'] ?>
              </td>
              <td>
                <?php echo $row['Name'] ?>
              </td>
              <td>
                <?php echo $row['Email'] ?>
              </td>
              <td>
                <?php echo $row['Password'] ?>
              </td>
              <td>
                <?php echo $row['UserType'] ?>
              </td>

            </tr>

            <?php
            }
            ?>
          <tr class="active-row">
            <td>Melissa</td>
            <td>5150</td>
          </tr>
        </tbody>
      </table>

    </div>
  </section>

  <section class="Review-section sections">
    <div class="Header_text">Review</div>
  </section>

  <section class="Settings-section sections">
    <div class="Header_text">Settings</div>
  </section>

  <script src="JS/Slidebar.js"></script>
  <script src="JS/Home.js"></script>

</body>

</html>