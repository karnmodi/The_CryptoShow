<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Admin | The CryptoShow</title>
    <link rel="stylesheet" href="CSS/Home.css">
    <link rel="stylesheet" href="CSS/Event.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="sidebar">
    <div class="logo-details">
      <img src="../Assets/Website Images/logo.png" alt="Logo" srcset="" class="icon">
        <div class="logo_name">CryptoShow</div>
        <i class='bx bx-menu' id="btn" ></i>
    </div>
    <ul class="nav-list">
      <li>
        <i class='bx bx-search' ></i>
         <input type="text" placeholder="Search...">
         <span class="SB_Btns">Search</span>
      </li>

      <li>
        <a href="#Dashboard" onclick="showSection('Dashboard-section', this); toggleActive(this); " >
          <i class='bx bx-grid-alt'></i>
          <span class="Btns_Name">Dashboard</span>
        </a>
         <span class="SB_Btns">Dashboard</span>
      </li>

     <li>
       <a href="#Schedules" onclick="showSection('Schedules-section', this); toggleActive(this);">
         <i class='bx bx-chat' ></i>
         <span class="Btns_Name">Schedules</span>
       </a>
       <span class="SB_Btns">Schedules</span>
     </li>

     <li>
       <a href="#Events" onclick="showSection('Events-section', this); toggleActive(this);">
         <i class='bx bx-pie-chart-alt-2' ></i>
         <span class="Btns_Name">Events</span>
       </a>
       <span class="SB_Btns">Events</span>
     </li>
     
     <li>
       <a href="#Members" onclick="showSection('Members-section' , this); toggleActive(this);">
        <i class='bx bx-user' ></i>
        <span class="Btns_Name">Members</span>
      </a>
      <span class="SB_Btns">Members</span>
    </li>
    
    <li>
      <a href="#Reviews"onclick="showSection('Review-section' , this); toggleActive(this);">
        <i class='bx bx-folder'></i>
        <span class="Btns_Name">Review</span>
      </a>
      <span class="SB_Btns">Review</span>
    </li>

     <li>
       <a href="#" onclick="showSection('Settings-section' , this); toggleActive(this);">
         <i class='bx bx-cog' ></i>
         <span class="Btns_Name">Setting</span>
       </a>
       <span class="SB_Btns">Setting</span>
     </li>

     <li class="profile">
         <div class="profile-details">
           <img src="../Assets/Website Images/Github Logo PNG.png" alt="profileImg">
           <div class="name_job">
             <div class="name">Karan Falgun Modi</div>
             <div class="position">Student</div>
           </div>
         </div>
         <a href="../index.php"><i class='bx bx-log-out' id="log_out"></i></a>
     </li>  
    </ul>
    <div id="activeIndicator" class="active-indicator"></div>
  </div>
  <section class="Dashboard-section sections">
      <div class="text">Dashboard</div>
      
  </section>

  <section class="Schedules-section sections">
      <div class="text">Scehdules</div>
     
  </section>
  
  <section class="Events-section sections">
      <div class="text">Events</div>
  
  <div class="container">
    <div class="card">
      <div class="content">
        <div class="EventDetails">
        <h2>The Crypto Show</h2>
        <p> Date: 11/04/2024 <br> Venue: Leicester</p>
        </div>
      </div>
      <div class="Heading">
        <h2>Event </h2>
        <h3> 1 <h3>
      </div>
    </div>
​
    <div class="card">
      <div class="content">
        <div class="EventDetails2">
        <h2>The Crypto Show</h2>
        <p>Date: 12/04/2024 <br> Venue: Leicester</p>
         </div>
      </div>
      <div class="Heading">
        <h2>Event </h2>
        <h3> 2 <h3>
      </div>
    </div>
​
    <div class="card">
      <div class="content">
        <div class="EventDetails3">
        <h2>The Crypto Show</h2>
        <p>Date: 13/04/2024 <br> Venue: Leicester</p>
         </div>
      </div>
      <div class="Heading">
        <h2>Event</h2>
        <h3> 3 <h3>
      </div>
    </div>
  </div>
​
  </section>
  
  <section class="Members-section sections">
      <div class="text">Members</div>
  </section>

  <section class="Review-section sections">
      <div class="text">Review</div>
  </section>
  
  <section class="Settings-section sections">
      <div class="text">Settings</div>
  </section>

  <script src="JS/Slidebar.js"></script>
  <script src="JS/Home.js"></script>
    
</body>
</html>