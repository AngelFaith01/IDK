<!-- Announcements to be change by events -->

<?php
session_start();
include "db.php";

if (isset($_POST['jobadd'])) {
  $job_title = $_POST['job_title']; 
  // $job_desc = $_POST['job_desc'];
  $job_type = $_POST['job_type'];
  $educ_back = $_POST['educ_back'];
  $location = $_POST['location']; 
  $experience = $_POST['experience'];
  $salary = $_POST['salary']; 
  $benefits = $_POST['benefits'];  
  $skills = $_POST['skills'];
  $duties = $_POST['duties'];
  
  $sql = "INSERT INTO `JobOffer` (`job_title`, `job_type`, `educ_back`, `location`, `experience`, `salary`, `benefits`, `skills`, `duties`, `admin_id`) 
  VALUES ('$job_title','$job_type', '$educ_back', '$location', '$experience', '$salary', '$benefits', '$skills', '$duties', '1')";
  $query = $conn->query($sql);
 
} 
?>

<!--Product-->
<?php
include "db.php";

if (isset($_POST['addproduct'])) {
    $prod_name = $_POST['prod_name'];
    $prod_desc = $_POST['prod_desc'];
    $product_type = $_POST['product_type'];
    $product_price = $_POST['product_price'];  //image?

    $sql = "INSERT INTO `product` (`prod_name`, `prod_desc`, `product_type`, `product_price`) 
            VALUES ('$prod_name', '$prod_desc', '$product_type', '$product_price')";
            $query = $conn->query($sql);
}
?>
<!--End Product-->

<?php 
$today = new DateTime();
$currentYear = $today->format('Y');
$currentMonth = $today->format('m');
$currentDay = $today->format('d');

$firstDayOfMonth = new DateTime("$currentYear-$currentMonth-01");
$firstDayOfWeek = $firstDayOfMonth->format('w'); 
$daysInMonth = $firstDayOfMonth->format('t'); 
 
$months = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];
 
$currentMonthName = $months[$currentMonth - 1];

?>
 
<?php
if (isset($_POST['settings'])) {
  require 'db.php';
  $user = $_POST['user'];
  $password = $_POST['password'];

  if (empty($user) || empty($password)) {
    header("Location: ");
  }
}
?>
 
 <?php
include 'db.php';

if (isset($_POST['submit']) || isset($_POST['failed'])) {
    $id = intval($_POST['id']);
    $status = isset($_POST['submit']) ? 'passed' : 'failed';

    $sql = "UPDATE applicant SET status = ? WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) { 
          header("location: admn.php?$status");
        } else { 
            header("location: admn.php?$status");
        }

        $stmt->close();
    } else {
        echo "<p>Failed to prepare statement.</p>";
    }
}   
?>

<?php
include "db.php"; 
if (isset($_POST['addannouncement'])) { 
    $title = $_POST['title']; 
    $desc = $_POST['desc']; 
    $location = $_POST['location'];
    $datetime = $_POST['datetime'];
    
    $sql = "INSERT INTO `announcement` (`title`, `desc`, `location`, `datetime`) Values ('$title', '$desc', '$location', '$datetime')";

    $query = mysqli_query($conn, $sql);  //error even if i change $query - $result $result = $conn->query($sql);
    if ($query) {
        header("Location: admn.php?SavedSuccessfully.");
    }
    else {
        header("Location: admn.php?FailedToSave.");
    }
}
?>
  
<!-- BRB announcement modal(saving), modal job and product 2025-05-16 (Job.php add more data) -->


<!-- <?php
include "db.php";
if (isset($_POST['addevent'])) {
  $event_title = $_POST['event_title'];
  $event_desc = $_POST['event_desc'];
  $event_location = $_POST['event_location'];
  $event_date = $_POST['event_date'];

  $sql = "INSERT INTO `events` (`event_title`, `event_desc`, `event_location`, `event_date`) VALUES ('$event_title', '$event_desc', '$event_location', '$event_date') ";

  $query = mysqli_query($conn, $sql);
  
  if ($query) {
    header ("Location: admn.php? SavedSuccessfully.");
  } else {
    header("Location: admn.php?FailedToSave.");
  }
}
?> -->
 

<?php
include 'db.php';

if (isset($_POST['btn-msubmit']) || isset($_POST['for interview'])) {
  $id = intval($_POST['id']);
  $status = isset($_POST['submit']) ? 'sendmail' : 'sendmail'; 

  $sql = "UPDATE applicant SET status = ? WHERE id = ?";
  if ($stmt = $conn->prepare($sql)){
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
      header("Location: admn.php?$status");
    } else {
      header("Location: admn.php?$status");
    }
    $stmt->close();
  } else {
    echo "<p>Failed to prepare statement.</p>";
  }
} 
?> 

<!-- Calendar -->
<?php
include "db.php";
if (isset($_POST['btn-submit'])) {
  $event_title = $_POST['event_title'];

  $sql = "INSERT INTO `events` (`event_title`) VALUES ('$event_title')" ;
  $query = myssli_query($conn, $sql);

  if ($query) {
    header("Location: admn.php?SavedSuccessfully.");
  } else {
    header("Location: admn.php?FailedToSave.");
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Dashboard</title>
    <meta name="viewport" content="width = device-width, initial-scale = 1, shrink-to-fit = no">

    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" href="">

    <!--Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Cabin|Herr+Von+Muellerhoff|Source+Sans+Pro" rel="stylesheet">

    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
 
    <!--FontAwesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous"> 
    
    <!--Logo-->
    <link rel="icon" href="data:image/png;base64,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">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="admn.css">
</head>
 
<body>
<meta http-equiv="Cache-Control" content="no-store" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
  
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="font-family: 'Poppins', Sans-serif;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="data:image/png;base64,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" alt="" style="height: 30px; width: 30px; border-radius: 50px;">
    </a>
 
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
      aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button> 
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="font-family: 'Poppins', Sans serif;">
        <li class="nav-item">
          <a class="nav-link active text-dark" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="#">Application</a>
        </li> 
        <li class="nav-item">
          <a href="Logout.php" class="nav-link" style="color:rgb(83, 20, 20);">Log Out</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

&nbsp &nbsp

<!--Modal for Settings-->
<div class="modal-dialog" id="settings" style="display: flex; justify-content: center; align-items: center; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050;">
  <div>
    <form action="admn.php" method="POST">
      <a href="#" class="modal-close text-dark" title="close">x</a>
      <p style="text-align: center;">Change Password</p>

      <?Php 
      if (isset($alert)) {
        echo $alert;
      }
      ?>

      <div class="form-group">
        <input type="text" class="form-control border-rounded" style="margin-top: .5rem; border: #1c3347 .5px solid;" placeholder="Username" name="Username" value="" required>
        <input type="file" class="form-control border-rounded" style="margin-top: .5rem; border: #1c3347 .5px solid;">
        <input type="password" class="form-control border-rounded" style="margin-top: .5rem; border: #1c3347 .5px solid;" placeholder="Old Password" name="oldpassword" value="" required>
        <input type="password" class="form-control border-rounded" style="margin-top: .5rem; border: #1c3347 .5px solid;" placeholder="New Password" name="newpassword" value="" required>
        <input type="password" class="form-control border-rounded" style="margin-top: .5rem; border: #1c3347 .5px solid;" placeholder="Confirm Password" name="confirmpassword" value="" required>
      </div>
      <br>
      <button type="settings" class="btn btn-outline-secondary btn-sm text-dark" name="settings" id="settings" style="border: #1c3347 .5px solid;">Submit</button>
    </form>
  </div>
</div>
<!--End Modal for Settings-->  
 
  
<div class="container my-5" style="font-family: 'Poppins', sans-serif;" id="cont">
  <div class="row">
    <!-- Left Panel -->
    <div class="col-md-8 d-flex">
      <div class="card w-100 p-4" style="border: #1c3347 0.5px solid; border-radius: 20px; box-shadow: 5px 0px 10px 0px #1c3347; font-family: 'Poppins', Sans serif;">
        <h2 class="mb-4">Hello, 
          <?php
          include_once "db.php";
          if (isset($_SESSION['admin_id'])) {
              $admin_id = $_SESSION['admin_id'];  
              $sql = "SELECT * FROM admin WHERE admin_id = ?";
              if ($stmt = $conn->prepare($sql)) {
                  $stmt->bind_param("i", $admin_id); 
                  $stmt->execute();
                  $result = $stmt->get_result();
                  if ($result->num_rows > 0) {
                      $row = $result->fetch_assoc();
                      echo htmlspecialchars($row['username']);  
                  } else {
                      echo "User not found.";
                  }
              } else {
                  echo "SQL error.";
              }
          } 
          ?>
          </h2>

        <div class="row">
          <!-- New Applicants --> 
          <div class="col">
            <div class="card h-100 position-relative" style="box-shadow: 5px 0px 10px 0px #1c3347; border: none;"> 
              <span class="position-absolute top-0 start-0 text-white px-3 py-1 rounded-end" style="font-size: 0.75rem; background-color: #1c3347;">
              <?php
                    include_once 'db.php'; 
                    $today = date('Y-m-d');
                    $sql = "SELECT COUNT(*) As total FROM applicant WHERE DATE_FORMAT(datetime, '%Y-%m-%d') = '$today' AND status = 'applicant'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo $row['total'];
                      }
                    }
                    ?>
              </span> 

              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h5 style="margin-top: 1rem;">
                    <i class="fa fa-user"></i> New Applicants
                  </h5> 
                </div>
                <div style="display: flex; justify-content: right;">
                  <a href="#jobs" class="btn btn-outline-secondary btn-sm text-dark" style="border: #1c3347 .5px solid; background-color: transparent; border-radius: 10px;">Add Job</a>
                </div>
                </div>
            </div>
          </div>

          <!-- Scheduled Interviews -->
          <div class="col mt-2 mt-md-0">
            <div class="card h-100" style="box-shadow: 5px 0px 20px 0px #1c3347; border: none;">
              <span class="position-absolute top-0 start-0 text-white px-3 py-1 rounded-end" style="font-size: 0.75rem; background-color: #1c3347;">
              <?php
              include_once "db.php";

              $today = date('Y-m');
              $sql = "SELECT COUNT(*) As total FROM applicant WHERE 
              DATE_FORMAT(datetime, '%Y-%m') = '$today' And status = 'passed'";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo $row['total'];
                }
              }
              ?>
              </span>
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h5 style="margin-top: 1rem;"><i class="fa fa-calendar"></i> Scheduled Interviews</h5> 
                </div>
                <div style="display: flex; justify-content: right;">
                  <a href="#" class="btn btn-outline-secondary btn-sm text-dark" style="border: #1c3347 .5px solid; border-radius: 10px; background-color: transparent;">View</a>
                </div>
              </div>
            </div>
          </div>

          <!-- Notifications -->
          <div class="col mt-2 mt-md-0">
            <div class="card h-100" style="box-shadow: 5px 0px 10px 0px #1c3347; border: none;">
              <span class="position-absolute top-0 start-0 text-white px-3 py-1 rounded-end" style="font-size: 0.75rem; background-color: #1c3347;">
                <?php
                include_once "db.php";
                $today = date('Y-m');
                $sql = "SELECT COUNT(*) As total FROM jobOffer As A inner join applicant As B On A.job_id = B.job_id WHERE DATE_FORMAT(B.datetime, '%Y-%m') = '$today' ";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    echo $row['total'];
                  }
                }
                ?>
              </span>
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h5 style="margin-top: 1rem;"><i class="fa fa-bell"></i> Add</h5></div>
              </div>

              <div style="display: flex; justify-content: right; margin-bottom: 1rem; margin-right: .5rem;"> 
                  <a href="#product" class="btn btn-outline-secondary btn-sm text-dark bg-light" style="border: #1c3347 .5px solid; border-radius: 10px; box-shadow: 5px 0px 10px 0px #1c3347; display: flex; margin-top: 1.5rem; margin-left: .5rem;">Product</a> 
                  <a href="#events" class="btn btn-outline-secondary btn-sm text-dark bg-light" style="border: #1c3347 .5px solid; border-radius: 10px; box-shadow: 5px 0px 10px 0px #1c3347; display: flex; margin-top: 1.5rem; margin-left: .5rem;">Announcement</a> 
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- Calendar BRB -->

    <!-- Right Panel -->
    <div class="col-md-4">
      <!-- Notifications List -->
      <div class="card mb-3" style="max-height: 190px; overflow-y: auto; margin-top: .5rem; box-shadow: 5px 0px 10px 0px #1c3347; border: #1c3347 .5px solid; font-family: 'Poppins', Sans serif;">
        <span class="position-absolute top-0 start-0 text-white px-3 py-1 rounded-end" style="font-size: 0.75rem; background-color:  #1c3347;">
          
          <?php
          include_once "db.php";
          $sql = "SELECT COUNT(*) As total FROM applicant WHERE status = 'applicant' ";
          $result = $conn->query($sql);

          if ($result->num_rows > 0 ) {
            while ($row = $result->fetch_assoc()) {
              echo $row['total'];
            }
          }
          ?>

        </span> 
      <div class="card-body" style="margin-top: 1rem;" >
          <h5>Notifications</h5>
          <?php 
          include_once "db.php";
          $today = date('Y-m-d');
          // $sql = "SELECT * FROM applicant AS A INNER JOIN jobOffer AS B ON A.job_id = B.job_id WHERE DATE_FORMAT(A.datetime, '%Y-%m-%d') = '$today' "; //possible to change this notification if the applicant is for interviewed or already done the interview 
          $sql = "SELECT * FROM applicant As A inner join jobOffer As B On A.job_id = B.job_id WHERE a.status = 'applicant' And DATE_FORMAT(A.datetime, '%Y-%m-%d') = '$today'";
          $result = $conn->query($sql);

          if ($result && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  ?>
                  <div class="card-box" style="border-radius: 10px; box-shadow: 7px 2px 12px 2px #aaa; padding: 1rem; margin: .5rem 0;">
                    <div class="d-flex align-items-center">
                      <span style="background-color: #6184ac; width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 10px;"></span>
                      <p class="mb-0 small"><?= htmlspecialchars($row['job_title']) ?> , <?= htmlspecialchars($row['lastname'])?></p>
                    </div>
                  </div>
                  <?php
              }
          } else {
              echo "<p class='text-muted small'>No applicant for today.</p>";
          }
          ?>

        </div>

        <!-- FOR APP --> 
        <div class="card-body" style="margin-top: 1rem;"> 
          <?php
          include_once "db.php";
          $today = date('Y-m-d');
          $sql = "SELECT * FROM applicant As A inner join jobOffer As B On A.job_id = B.job_id WHERE A.status = 'applicant' And DATE_FORMAT(A.datetime, '%Y-%m-%d') = '$today' ";
          $result = $conn->query($sql);

          if ($result->num_rows > 0 ) {
            while ($row = $result->fetch_assoc()) {
              ?>
              <div class="card-box" style="border-radius: 10px; box-shadow: 7px 2px 12px 2px #aaa; padding: 1rem; margin: .5rem;">
                <div class="d-flex align-item-center">
                  <span style="background-color:rgb(65, 10, 10); width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 10px;"></span>
                  <p class="mb-0 small"> <?= htmlspecialchars($row['job_title'])?>, <?= htmlspecialchars($row['lastname'])?></p>
                </div>
              </div> 
              <?php
            }
          }
          ?>
        </div>

      </div>
          
      <!-- Events List -->
      <!-- <div class="card" style="max-height: 290px; box-shadow: 5px 0px 10px 0px #1c3347; border: #1c3347 .5px solid; font-family: 'Poppins', Sans serif;">
        <div class="card-body">  -->

<!-- Mini Calendar with Schedule -->
 <div class="row">
  <div class="col-sm-6 col-lg-5 mb-3 mb-sm-0">
    <div data-coreui-locale="en-US" data-coreui-toggle="date-picker"></div>
  </div>
  <div class="col-sm-6 col-lg-5">
    <div data-coreui-date="2023/03/15" data-coreui-locale="en-US" data-coreui-toggle="date-picker"></div>
  </div>
</div> 

<div id="mini-calendar" style="max-width:300px; margin:auto; background: #f8f9fa; border-radius:10px; padding:1rem; box-shadow: 5px 0px 10px 0px #1c3347; font-family: 'Poppins', Sans serif;">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <button onclick="prevMonth()" style="background:none; border:none; font-size:1.2rem;">&#8592;</button>
        <span id="calendar-month" style="font-weight:bold;"></span>
        <button onclick="nextMonth()" style="background:none; border:none; font-size:1.2rem;">&#8594;</button>
    </div>
    <table style="width:100%; text-align:center; margin-top:0.5rem;">
        <thead>
            <tr style="background-color: #6184ac; border: #1c3347 .5px solid;">
                <th style="color:rgb(71, 13, 13); border: #1c3347 .5px solid;">Su</th>
                <th style="color: rgb(37, 34, 34); border: #1c3347 .5px solid;">Mo</th>
                <th style="color: rgb(37, 34, 34); border: #1c3347 .5px solid;">Tu</th>
                <th style="color: rgb(37, 34, 34); border: #1c3347 .5px solid;">We</th>
                <th style="color: rgb(37, 34, 34); border: #1c3347 .5px solid;">Th</th>
                <th style="color: rgb(37, 34, 34); border: #1c3347 .5px solid;">Fr</th>
                <th style="color: rgb(37, 34, 34); border: #1c3347 .5px solid;">Sa</th>
            </tr>
        </thead>
        <tbody id="calendar-body" style="border: #1c3347 .5px solid;"></tbody>
    </table>
    <div id="schedule-form" style="display:none; margin-top:1rem;">
        <h6 id="selected-date"></h6> 
        <!-- <div class="form-group">
          <input type="text" id="schedule-input" class="form-control" style="border: #1c3347 .5px solid; border-radius: 15px;" name="event_title" placeholder="Event Title" required>
          <div style="display: flex; justify-content: right; margin-right: .5rem; margin-top: .5rem;">
            <button type="button" onclick="saveSchedule()" class="btn btn-outline-secondary btn-sm text-dark" style="border: #1c3347 .5px solid; border-radius: 15px; background-color: transparent;">Submit</button>
          </div>
        </div> -->
      </div>
 
        <form action="admn.php" method="POST">
        <?php 
         if (isset($alert)) {
          echo $alert;
         }
        ?> 
      <div class="form-group" style="margin-top: .5rem; border: none;"> 
        <input type="calendar" class="form-control" name="event_title" placeholder="Event Title" style="border: #1c3347 .5px solid; border-radius: 15px;" required>
        <div style="display: flex; justify-content: right; margin-right: .5rem; margin-top: .5rem;"> 
          <button type="button" class="btn btn-outline-secondary btn-sm text-dark bg-light" style="border: #1c3347 .5px solid;" name="btn-submit" id="btn-submit">Submit</button>
        </div>
        </div>
      </form>

    <div id="schedule-list" style="margin-top:1rem;"></div>
</div>

<script>
let today = new Date();
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();
let selectedDay = null;

const monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];
let schedules = JSON.parse(localStorage.getItem("schedules") || "{}");

function showCalendar(month, year) {
    let firstDay = (new Date(year, month)).getDay();
    let daysInMonth = 32 - new Date(year, month, 32 ).getDate();  
    let tbl = document.getElementById("calendar-body");
    tbl.innerHTML = "";
    document.getElementById("calendar-month").innerText = monthNames[month] + " " + year;

    let date = 1;
    for (let i = 0; i < 6; i++) {
        let row = document.createElement("tr");
        for (let j = 0; j < 7; j++) {
            if (i === 0 && j < firstDay) {
                let cell = document.createElement("td");
                cell.innerHTML = "";
                row.appendChild(cell);
            } else if (date > daysInMonth) {
                break;
            } else {
                let cell = document.createElement("td");
                cell.innerHTML = date;
                cell.style.cursor = "pointer";
                let key = `${year}-${month+1}-${date}`; 
                if (schedules[key]) {
                    cell.style.background = "#ffe082";
                    cell.style.color = "#b71c1c";
                    cell.title = schedules[key];
                } 
                if (
                    date === today.getDate() &&
                    year === today.getFullYear() &&
                    month === today.getMonth()
                ) {
                    cell.style.background = "#6184ac";
                    cell.style.color = "#fff";
                    cell.style.borderRadius = "50%";
                }
                cell.onclick = function() { openScheduleForm(date, month, year); };
                row.appendChild(cell);
                date++;
            }
        }
        tbl.appendChild(row);
    }
    showScheduleList();
}

function prevMonth() {
    currentYear = (currentMonth === 0) ? currentYear - 1 : currentYear;
    currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
    showCalendar(currentMonth, currentYear);
}

function nextMonth() {
    currentYear = (currentMonth === 11) ? currentYear + 1 : currentYear;
    currentMonth = (currentMonth + 1) % 12;
    showCalendar(currentMonth, currentYear);
}

function openScheduleForm(day, month, year) {
    selectedDay = {day, month, year};
    document.getElementById("schedule-form").style.display = "block";
    document.getElementById("selected-date").innerText = `Add schedule for: ${monthNames[month]} ${day}, ${year}`;
    document.getElementById("schedule-input").value = schedules[`${year}-${month+1}-${day}`] || "";
}

function saveSchedule() {
    if (!selectedDay) return;
    let key = `${selectedDay.year}-${selectedDay.month+1}-${selectedDay.day}`;
    let value = document.getElementById("schedule-input").value.trim();
    if (value) {
        schedules[key] = value;
    } else {
        delete schedules[key];
    }
    localStorage.setItem("schedules", JSON.stringify(schedules));
    document.getElementById("schedule-form").style.display = "none";
    showCalendar(currentMonth, currentYear);
}

function showScheduleList() {
    let listDiv = document.getElementById("schedule-list");
    let html = "<b>Schedules this month:</b><ul>";
    let found = false;
    for (let d = 1; d <= 31; d++) {
        let key = `${currentYear}-${currentMonth+1}-${d}`;
        if (schedules[key]) {
            html += `<li><b>${monthNames[currentMonth]} ${d}:</b> ${schedules[key]}</li>`;
            found = true;
        }
    }
    html += "</ul>";
    listDiv.innerHTML = found ? html : "<i>No schedules or events for this month.</i>";
}

showCalendar(currentMonth, currentYear);
</script>

          <!-- <?php
          include_once "db.php";
          $today = date('Y-m');
          $sql = "SELECT * FROM events WHERE DATE_FORMAT(datetime, '%Y-%m') = '$today' ";
          $result = $conn->query($sql);

          if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              ?>
                  <div class="card-box" style="border-radius: 10px; box-shadow: 7px 2px 12px 2px #aaa; padding: 1rem; margin: .5rem 0;">
                    <div class="d-flex align-items-center">
                      <span style="background-color: #6184ac; width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 10px;"></span>
                      <p class="mb-0 small"><?= htmlspecialchars($row['event_title'])?> (<?= htmlspecialchars($row['event_date'])?>)</p>
                    </div>
                  </div>
              <?php
            }
          } else {
            echo "<p class='text-align: center;'>No event for this month.</p>";
          }
          ?>  -->

        </div>
      </div>
    </div> 
 
  <!--Announcements-->
  <div class="modal-dialog" id="announcement" style="font-family: 'Poppins', Sans serif; display: flex; justify-content: center; align-items: center; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050;">
    <div style="box-shadow: 15px 10px 20px 10px #aaa;">
      <a href="#" class="modal-close text-dark" title="close">x</a>
      <form action="#cont" method="post">
        <div class="form-group">
            <h5 style="display: flex; justify-content: center;">Announcements</h5>
          <div class="mb-3">
            <input type="text" class="form-control" style="margin-top: .5rem; border: #1c3347 .5px solid;" placeholder="Announcement Title" name="title" required>
            <textarea name="desc" style="margin-top: .5rem; border: #1c3347 .5px solid;" id="" placeholder="Description" class="form-control"></textarea>
            <input type="text" class="form-control" style="margin-top: .5rem; border: #1c3347 .5px solid;" placeholder="Location" name="location" required>
            <input type="date" id="event_date" class="form-control" style="margin-top: .5rem; border: #1c3347 .5px solid;" placeholder="Time" name="datetime" required>
          </div> 

            <div style="display: flex; justify-content: right; margin-right: .5rem;">
              <button type="addannouncement" class="btn btn-outline-secondary btn-sm" style="border-radius: 15px; color: #1c3347; border: #1c3347 .5px solid; background-color: white; box-shadow: 5px 0px 10px 0px #aaa;" name="addannouncement" id="addannouncement">Add Product</button></form> 
            </div> 
        </div>
      </form>
    </div>
  </div>
  <!--End Announcements-->

<!-- Job Modal -->
  <div class="modal-dialog" id="jobs" style="font-family: 'Poppins', Sans serif; display: flex; justify-content: center; align-items: center; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050;">
    <div style="box-shadow: 5px 0px 10px 0px #1c3347;">
      <a href="#applicants" class="modal-close text-dark" title="close">x</a>
      <form action="admn.php" method="POST">
        <div class="form-group">
          <h5 style="display: flex; justify-content: center;">Add Job</h5>

          <?php
          if (isset($alert)) {
            echo $alert;
          }
          ?>

          <div class="mb-3">
            <input type="text" class="form-control" style="margin-top: .5rem; border: #1c3347 .5px solid;" placeholder="Job Title" name="job_title" required>
            <!-- <textarea name="job_desc" id="" class="form-control" style="margin-top: .5rem; border: #1c3347 .5px solid;" placeholder="Job Description" rows="3" required></textarea> -->
            <input type="text" class="form-control" style="margin-top: .5rem; border: #1c3347 .5px solid;" placeholder="Job Type" name="job_type" required>
            <input type="text" class="form-control" style="margin-top: .5rem; border: #1c3347 .5px solid;" placeholder="Educational Background" name="educ_back" required>
            <input type="text" class="form-control" style="margin-top: .5rem; border: #1c3347 .5px solid;" name="location" placeholder="Location" required>
            <textarea name="experience" id="" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" placeholder="Experience" row="3" required></textarea>
            <input type="text" name="salary" id="" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" placeholder="Salary" required>
            <input type="text" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem; margin-top: .5rem;" placeholder="Benefits" name="benefits" required>
            <textarea name="skills" id="" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" placeholder="Skills" row=""3 required></textarea>
            <textarea name="duties" id="" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" placeholder="Duties and Responsibilities" rows="3" required></textarea>
          </div>

          <div style="display: flex; justify-content: right; margin-right: .5rem;">
            <button type="jobadd" class="btn btn-outline-secondary btn-sm text-dark" name="jobadd" id="jobadd" style="border: #1c3347 .5px solid; border-radius: 10px; background-color: white; box-shadow: 5px 0px 10px 0px #aaa;">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- End Job Modal -->   

  <!-- Product Modal -->
   <div class="modal-dialog" id="product" style="font-family: 'Poppins', Sans serif; display: flex; justify-content: center; align-items: center; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050;">
    <div style="box-shadow: 5px 0px 10px 0px #1c3347;">
      <a href="" class="modal-close text-dark" title="close">x</a>
      <form action="admn.php" method="POST">
        <div class="form-group">
          <h5 style="text-align: center;">Add Product</h5>

          <div class="mb-3">
            <input type="text" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" placeholder="Product Name" name="prod_name" required>
            <textarea name="prod_desc" id="" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" placeholder="Product Description" rows="3" required></textarea>
            <input type="text" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" placeholder="Product Type" name="product_type" required>
            <input type="text" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" placeholder="Product Price" name="product_price" required>
          </div> 

        <div style="display: flex; justify-content: right; margin-right: .5rem;">
          <button type="addproduct" class="btn btn-outline-secondary btn-sm text-dark" style="border-radius: 15px; border: #1c3347 .5px solid; background-color: transparent; box-shadow: 5px 0px 10px 0px #aaa;" name="addproduct" id="addproduct">Add Product</button>
        </div>
        </div>
      </form>
    </div>
   </div>
  <!-- End Product Modal -->

<!-- COMPANY EVENT -->
  <div class="modal-dialog" id="events" style="font-family: 'Poppins', Sans serif; display: flex; justify-content: center; align-items: center; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050; ">
    <div style="box-shadow: 5px 0px 10px 0px #1c3347;">
      <a href="#" class="modal-close text-dark" title="close">x</a>
      <form action="admn.php" method="POST">
        <div class="form-group">
          <h5 style="text-align: center;">Events</h5>

          <div class="mb-3">
            <input type="text" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" placeholder="Event Title" name="event_title" required>
            <textarea name="event_desc" id="event_desc" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" placeholder="Event Description" rows="3" required></textarea>
            <input type="date" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" placeholder="Event Date" name="event_date" required>
            <input type="text" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" placeholder="Event Location"name="event_location" required>
          </div>

          <div style="display: flex; justify-content: right; margin-right: .5rem;">
            <button type="addevent" class="btn btn-outline-secondary btn-sm text-dark" style="border-radius: 15px; border: #1c3347 .5px solid; background-color: transparent; box-shadow: 5px 0px 10px 0px #1c3347;" name="addevent" id="addevent">Submit</button>
          </div>

        </div>
      </form>
    </div>
  </div>
<!-- END COMPANY EVENT -->


  <!--For Interview Modal-->
  <div class="modal-dialog" id="viewjob" style="display: flex; justify-content: center; align-items: center; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050;">
    <div style="box-shadow: 5px 0px 10px 0px #aaa; border: #1c3347 .5px solid;;">
      <a href="#" class="modal-close text-dark" title="close">x</a>
      <?php 
      include_once 'db.php';
      $today = date('Y-m-d');
      $sql = "SELECT * FROM applicant As A Inner Join jobOffer As B On A.job_id = B.job_id WHERE DATE_FORMAT(A.datetime, '%Y-%m-%d') = '$today' And status='passed'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc())  {
          ?>
          <div class="card" style="margin-top: .5rem; border: none; box-shadow: 5px 0px 10px 0px #aaa;">
            <div class="card-body">
              <h5 style="text-align: center;"><?= $row['job_title']?></h5>
              <p><small><strong>Name: </strong><?= $row['firstname']?> <?= $row['lastname']?></small></p>
              <p><small><strong>Email: </strong><?= $row['email']?></small></p>
              <p><small><strong>Phonenumber: </strong><?= $row['phonenumber']?></small></p>
              <p><small><strong>Description: </strong><?= $row['self_desc']?></small></p>
            </div>
          </div>
          <?php
        }
      }
      ?>
    </div>
  </div>
  <!--End Interview Modal-->  
  
  <!-- <section class="container my-5" style="font-family: 'Poppins', sans-serif;">
  <div class="card" style="padding: 1rem; border: #1c3347 .5px solid; box-shadow: 7px 2px 12px 2px #1c3347; height: 450px; overflow-y: auto; border-radius: 15px;">
  
    <div class="row justify-content-between align-items-center mb-3">
      <div class="col-md-4 col-12 mb-2 mb-md-0">
        <h2>Applicants</h2> 
      </div>
      <div class="col-md-8 col-12">
        <form action="" method="GET">
          <div class="d-flex flex-wrap gap-2 align-items-center">
 
            <?php
            $statuses = $_GET['status'] ?? [];
            function checked($value) {
              global $statuses;
              return (in_array($value, $statuses)) ? 'checked' : '';
            }
            ?>
            <div class="form-check">
              <input class="form-check-input status-checkbox" type="checkbox" name="status[]" value="passed" id="statusPassed" <?= checked('passed') ?> style="border: #1c3347 .5px solid;">
              <label class="form-check-label" for="statusPassed">Passed</label>
            </div>
            <div class="form-check">
              <input class="form-check-input status-checkbox" type="checkbox" name="status[]" value="for interview" id="statusInterview" <?= checked('for interview') ?> style="border: #1c3347 .5px solid;">
              <label class="form-check-label" for="statusInterview">For Interview</label>
            </div>
            <div class="form-check">
              <input class="form-check-input status-checkbox" type="checkbox" name="status[]" value="failed" id="statusFailed" <?= checked('failed') ?> style="border: #1c3347 .5px solid;">
              <label class="form-check-label" for="statusFailed">Failed</label>
            </div>

            <script>
              document.querySelectorAll('.status-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                  if (this.checked) {
                    document.querySelectorAll('.status-checkbox').forEach(cb => {
                      if (cb !== this) cb.checked = false;
                    });
                    this.form.submit();
                  }
                });
              });
            </script>

            <div class="flex-grow-1">
              <input 
                type="search" 
                class="form-control" 
                name="search" 
                placeholder="Search" 
                aria-label="Search"
                style="border: #1c3347 0.5px solid; color: #1c3347; box-shadow: 5px 0px 10px 0px #aaa;"
                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"> 
            </div> 

            <a href="#jobs" class="btn btn-outline-secondary btn-sm text-dark" style="border: #1c3347 .5px solid; background-color: transparent; box-shadow: 5px 0px 10px 0px #aaa;">Add Job</a>
          </div>
        </form>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>    
            <th class="text-center">Job Title</th>
            <th class="text-center">Name</th>
            <th class="text-center">Email</th>
            <th class="text-center">Mail</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $conn = new mysqli("localhost", "root", "", "contact");
          if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

          if (isset($_SESSION['admin_id'])) {
              $searchTerm = trim($_GET['search'] ?? '');
              $statuses = $_GET['status'] ?? [];
              $query = "SELECT A.id, A.firstname, A.lastname, A.email, B.job_title FROM applicant AS A 
                        INNER JOIN joboffer AS B ON A.job_id = B.job_id WHERE 1 ";
              $params = [];
              $types = '';

              if (!empty($statuses)) {
                  $placeholders = implode(',', array_fill(0, count($statuses), '?'));
                  $query .= " AND A.status IN ($placeholders)";
                  $params = array_merge($params, $statuses);
                  $types .= str_repeat('s', count($statuses));
              } else {
                  $today = date('Y-m');
                  $query .= " AND A.status = 'passed' AND DATE_FORMAT(A.datetime, '%Y-%m') = '$today' ";
              }

              if (!empty($searchTerm)) {
                  $query .= " AND (B.job_title LIKE ? OR A.firstname LIKE ? OR A.lastname LIKE ?)";
                  $like = "%$searchTerm%";
                  $params[] = $like;
                  $params[] = $like;
                  $params[] = $like;
                  $types .= 'sss';
              }

              $stmt = $conn->prepare($query);
              if ($params) $stmt->bind_param($types, ...$params);
              $stmt->execute();
              $result = $stmt->get_result();

              if ($result && $result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                      ?>
                      <tr>
                        <td class="text-center"><?= htmlspecialchars($row["job_title"]) ?></td>
                        <td class="text-center"><?= htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) ?></td>
                        <td class="text-center"><?= htmlspecialchars($row['email']) ?></td>
                        <td class="text-center">
                          <button type="button" class="btn btn-outline-secondary btn-sm text-dark bg-light open-mail-modal"
                                  data-bs-toggle="modal" data-bs-target="#MailModal"
                                  data-app-id="<?= $row['id'] ?>"
                                  data-app-name="<?= htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) ?>"
                                  data-app-email="<?= htmlspecialchars($row['email']) ?>">
                            Send Mail
                          </button>
                        </td>
                      </tr>
                      <?php
                  }
              } else {
                  echo "<tr><td colspan='4' class='text-center text-muted'>No results found.</td></tr>";
              }

              if (isset($stmt)) $stmt->close();
              $conn->close();
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
 
<div class="modal fade" id="MailModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content p-3" style="box-shadow: 5px 0px 10px 0px #1c3347;">
      <form action="send_mail.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Send Mail</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="modal-app-id">
          <div class="mb-2">
            <input type="text" class="form-control" name="subject" placeholder="Subject" required>
          </div>
          <div class="mb-2">
            <input type="email" class="form-control" name="name" id="modal-app-email" placeholder="To (Email)" required>
          </div>
          <div class="mb-2">
            <textarea name="message" class="form-control" rows="4" placeholder="Message" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-outline-secondary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div> -->

<script>
  document.querySelectorAll('.open-mail-modal').forEach(button => {
    button.addEventListener('cl ick', () => {
      document.getElementById('modal-app-id').value = button.dataset.appId;
      document.getElementById('modal-app-email').value = button.dataset.appEmail;
    });
  });
</script>


<section class="container my-5" style="font-family: 'Poppins', sans-serif;" id="applicants">
  <div class="card" style="padding: 1rem; border: #1c3347 .5px solid; box-shadow: 7px 2px 12px 2px #1c3347; height: 450px; overflow-y: auto; border-radius: 15px;">
  
    <div class="row justify-content-between align-items-center mb-3" style="font-family: 'Poppins', Sans serif;">
      <div class="col-md-4 col-12 mb-2 mb-md-0">
        <h2>Applicants</h2> 
      </div>
      <div class="col-md-8 col-12">
        <form action="" method="GET">
          <div class="d-flex flex-wrap gap-2 align-items-center">
  
          <div class="form-check" style="font-family: 'Poppins', Sans serif;">
            <input class="form-check-input status-checkbox" type="checkbox" name="status[]" value="passed" id="statusPassed"
              <?= (isset($_GET['status']) && in_array('passed', $_GET['status'])) ? 'checked' : '' ?> style="border: #1c3347 .5px solid;">
            <label class="form-check-label" for="statusPassed">Passed</label>
          </div>

          <div class="form-check">
            <input class="form-check-input status-checkbox" type="checkbox" name="status[]" style="border: #1c3347 .5px solid;" value="for interview" id="statusInterview"
              <?= (isset($_GET['status']) && in_array('for interview', $_GET['status'])) ? 'checked' : '' ?>>
            <label class="form-check-label" for="statusInterview">For Interview</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input status-checkbox" name="status[]" value="failed" id="statusNotQualified"
              <?= (isset($_GET['status']) && in_array('failed', $_GET['status'])) ? 'checked' : '' ?> style="border: #1c3347 .5px solid;">
              <label class="form-check-label" for="statusFailed">Failed</label>
          </div>

            <div class="flex-grow-1">
              <input 
                type="search" 
                class="form-control" 
                name="search" 
                placeholder="Search" 
                aria-label="Search"
                style="border: #1c3347 0.5px solid; color: #1c3347; box-shadow: 5px 0px 10px 0px #aaa;"
                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"> 
            </div> 

            <a 
              href="#jobs" 
              class="btn btn-outline-secondary btn-sm text-dark" 
              style="border: #1c3347 .5px solid; background-color: transparent; box-shadow: 5px 0px 10px 0px #aaa;">
              Add Job
            </a>

          <script> 
            document.querySelectorAll('.status-checkbox').forEach(checkbox => {
              checkbox.addEventListener('change', function () {
                if (this.checked) {
                  document.querySelectorAll('.status-checkbox').forEach(cb => {
                    if (cb !== this) cb.checked = false;
                  });
                  this.form.submit();
                }
              });
            });
          </script> 


          </div>
        </form>
      </div>
    </div>

    <div class="table-responsive" style="font-family: 'Poppins', Sans serif;">
      <table class="table">
        <thead>
          <tr>    
            <th style="text-align: center; border: none;">Job Title</th>
            <th style="text-align: center; border: none;">Name</th>
            <th style="text-align: center; border: none;">Email</th>
            <th style="text-align: center; border: none;">Mail</th>
          </tr>
        </thead>

        <tbody>
        <?php
        $conn = new mysqli("localhost", "root", "", "contact");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_SESSION['admin_id'])) {
            $result = null;

            // Filters
            $searchTerm = trim($_GET['search'] ?? '');
            $statuses = $_GET['status'] ?? [];
            $hasSearch = !empty($searchTerm);
            $hasStatus = !empty($statuses);

            $query = "SELECT A.id, A.firstname, A.lastname, A.email, B.job_title 
                      FROM applicant AS A 
                      INNER JOIN joboffer AS B ON A.job_id = B.job_id 
                      WHERE 1 ";

            $params = [];
            $types = '';

            if ($hasStatus) {
                $placeholders = implode(',', array_fill(0, count($statuses), '?'));
                $query .= " AND A.status IN ($placeholders) ";
                $params = array_merge($params, $statuses);
                $types .= str_repeat('s', count($statuses));
            } else {
                $today = date('Y-m');
                $query .= " AND A.status = 'passed' AND DATE_FORMAT(A.datetime, '%Y-%m') = '$today' ";
            }

            if ($hasSearch) {
                $query .= " AND (B.job_title LIKE ? OR A.firstname LIKE ? OR A.lastname LIKE ?) ";
                $like = "%$searchTerm%";
                $params[] = $like;
                $params[] = $like;
                $params[] = $like;
                $types .= 'sss';
            }

            $stmt = $conn->prepare($query);
            if ($params) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
        ?>
          <tr>
            <td style="text-align: center; border: none;"><?= htmlspecialchars($row["job_title"]) ?></td>
            <td style="text-align: center; border: none;"><?= htmlspecialchars($row['firstname']) . ' ' . htmlspecialchars($row['lastname']) ?></td>
            <td style="text-align: center; border: none;"><?= htmlspecialchars($row['email']) ?></td>
            <td style="text-align: center; border: none;">
              <a href="#MailModal" 
              class="open-mail-modal btn btn-outline-secondary btn-sm text-dark bg-light" 
              data-id="<?= $row['id']?>" style="border: #1c3347 .5px solid; border-radius: 15px; box-shadow: 5px 0px 10px 0px #1c3347;">
              Send Mail
            </a>
            </td>
          </tr>
        <?php
                }
            } else {
                echo "<tr><td colspan='4' class='text-center text-muted'>No results found.</td></tr>";
            }

            if (isset($stmt)) $stmt->close();
            $conn->close();
        }
        ?>
        </tbody>
      </table>
    </div> 
</section>
  
<!-- Modal for Mail sending -->
<div class="modal-dialog" id="MailModal" style="font-family: 'Poppins', Sans serif; display: flex; justify-content: center; align-items: center; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050; ">
  <div style="box-shadow: 5px 0px 10px 0px #1c3347; border: #1c3347 .5px solid; ">
    <a href="#applicants" class="modal-close text-dark" title="close">x</a>

    <div class="form-group">
      <form action="send_mail.php" method="POST">
        <input type="hidden" name="applicant_id" id="modal-applicant-id"> 
        
        <h5 class="text-align: center;" style="justify-content: center; display: flex; margin-top: .5rem;">Send Mail</h5>

        <input type="email" class="form-control" name="email" placeholder="Recipient Email" style="margin-top: .5rem; border: #1c3347 .5px solid; border-radius: 10px; background-color: transparent;" required>
 
        <input type="text" class="form-control" name="subject" placeholder="Subject" style="margin-top: .5rem; border: #1c3347 .5px solid; border-radius: 10px; background-color: transparent;" required>
        
        <textarea name="message" class="form-control" placeholder="Message" rows="10" style="margin-top: .5rem; border: #1c3347 .5px solid; border-radius: 10px; background-color: transparent;" required></textarea>

        <div style="display: flex; justify-content: right; margin-top: 1rem;">
          <button type="submit" class="btn btn-outline-secondary btn-sm text-dark" style="border: #1c3347 .5px solid; border-radius: 10px; border-radius: 10px; background-color: transparent; box-shadow: 5px 0px 10px 0px #aaa;">
            Submit
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
   
<script>
  document.querySelectorAll('.open-mail-modal').forEach(button => {
    button.addEventListener('click', function () {
      const applicantId = this.getAttribute('data-id');  
      document.getElementById('modal-applicant-id').value = applicantId;  
    });
  });
</script>

<!-- End Modal for Mail -->
  
<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
  $('.btn-send').on('click', function (e) {
    e.preventDefault();
    const id = $(this).data('app-id');

    $.ajax({
      url: 'sent_interview_email.php',
      type: 'POST',
      data: { id: id },
      success: function (response) {
        $('#send-mail-content').html(response);
        $('#MailModal').fadeIn();
      },
      error: function () {
        $('#send-mail-content').html('<p>Error loading content.</p>');
      }
    });
  });

  $('#modal-close').on('click', function () {
    $('#MailModal').fadeOut();
  });
});
</script>


<!-- <div class="modal-dialog" id="MailModal" style="display: flex; justify-content: center;">
  <div class="row" style="box-shadow: 15px 10px 20px 10px #aaa; display: flex; justify-content: center;">
    <a href="#" class="modal-close text-dark" title="close">x</a>
    <div id="send-mail-content">
      <p>Please select specific applicant to send mail.</p>
    </div>
  </div>
</div> -->

  <div class="modal-dialog" id="sendMailModal" style="display: flex; justify-content: center;">
    <div style="box-shadow: 15px 10px 20px 10px #aaa;" style="display: flex;">
      <a href="#" class="modal-close text-dark" title="close">x</a>
    <form action="send_interview_email.php" method="POST">  

      <div class="form-group" style="justify-content: center;">
        <div id="sendMailLabel">
          <p><strong>Applicant:</strong> <span id="modal-applicant-name"></span></p>
        </div>
        <div class="mb-3">
          <input type="text" class="form-control" name="subject" style="border: #1c3347 .5px solid; border-radius: 10px; background-color: transparent;" placeholder="Subject" required>
        </div>

        <div class="mb-3">
          <input type="date" class="form-control" style="border-radius: 10px; border: #1c3347 .5px solid; background-color: transparent;" placeholder="Date" name="date" required>
        </div>

        <div class="mb-3"> 
          <input type="time" class="form-control" name="time" placeholder="Time" style="border-radius: 10px; border: #1c3347 .5px solid; background-color: transparent;" required>
        </div>

        <div class="mb-3">
          <textarea name="message" class="form-control" rows="3" style="border: #1c3347 .5px solid; border-radius: 10px; background-color: transparent;" placeholder="Message" required></textarea>
        </div>

      </div>

      <div class="modal-footer">
        <button type="submit" name="sendmail" class="btn btn-outline-secondary btn-sm text-dark bg-light" style="border: #1c3347 .5px solid; border-radius: 15px;">Send Mail</button>
      </div>
    </form>

  </div>
</div>  
<!-- </div> -->

<!--Product Modal-->
<div class="modal-dialog" id="prodmod">
  <div style="box-shadow: 15px 10px 20px 10px #aaa;">
    <a href="#cont" class="modal-close text-dark" title="close">x</a>
    <form action="admn.php" method="POST">
      <h5 style="text-align: center;">Add Product</h5>

      <?php
      if (isset($alert)) {
        echo $alert;
      }
      ?>
      <div class="form-group">
        <div class="mb-3">
          <input type="text" class="form-control" placeholder="Product name" name="prod_name" style="border: #1c3347 .5px solid;" required>
        </div>
        <div class="mb-3">
          <textarea name="prod_desc" id="" class="form-control" placeholder="Product Description" row="3" style="border: #1c3347 .5px solid;" required></textarea>
        </div>
        <div class="mb-3">
          <input type="text" class="form-control" placeholder="Product type" name="product_type" style="border: #1c3347 .5px solid;" required>
        </div>
        <div class="mb-3">
          <input type="text" class="form-control" placeholder="Product price" name="product_price" style="border: #1c3347 .5px solid;" required>
        </div>
        
        <div style="display: flex; justify-content: right; margin-right: .5rem;">
          <button type="addproduct" class="btn btn-outline-secondary btn-sm text-dark" style="border-radius: 15px; border: #1c3347 .5px solid; background-color: transparent; box-shadow: 5px 0px 10px 0px #aaa;" name="addproduct" id="addproduct">Add Product</button></form> 
        </div>
      </form>
    </div>
  </div>
</div>
<!--End Product Modal--> 

  <!--<div class="row g-0" style="margin-top: 1rem; margin-left: 1rem; margin-right: 1rem;">
    <div class="col-sm-6 col-md-3" style="margin-right: 1rem; margin-top: .5rem;">
      <div class="calendar-header" style="font-family: 'Poppins', Sans serif;">Summary</div>
      <div class="card" style="padding: 1rem; border: #1c3347 solid .5px; height: 260px; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; border-top-left-radius: 0; border-top-right-radius: 0;"> 
 
      <div class="card" style="margin-top: .5rem; border: #1c3347 .5px solid ; height: 60px;">
    <p style="margin: .5rem; display: flex; justify-content: space-between; align-items: center; ">
        <small>Applications</small> 
        <h6 style="margin-left: auto; margin-right: 1rem;">  
            <?php 
            include_once "db.php";   
            
            if (isset($_SESSION['admin_id'])) {
              $admin_id = $_SESSION['admin_id'];
              
            $today = date('Y-m');  //per year and month 
 
            //$sql = "SELECT COUNT(*) AS total FROM applicant AS A Inner Join admin AS B On A.admin_id = B.admin_id WHERE DATE_FORMAT(A.datetime, '%Y-%m') = '$today' and admin = 1";

            $sql = "SELECT COUNT(*) AS total FROM applicant WHERE DATE_FORMAT(datetime, '%Y-%m') = '$today'";
            $result = $conn->query($sql); 

            if ($result->num_rows > 0) { 
                $row = $result->fetch_assoc();
                echo $row['total']; 
            } else {
                echo "0";  
            }
            }
            ?> 
        </h6>
    </p>
</div>
 
    <div class="card" style="margin-top: .5rem; border: #1c3347 solid .5px; height: 60px;"> 
        <p style="margin: .5rem; display: flex; justify-content: space-between; align-items:center">
          <small>For Interview</small>
          <h6 style="margin-left: auto; margin-right: 1rem; "> 

            <?php
            include_once "db.php";

            if (isset($_SESSION['admin_id'])) {
              $admin_id = $_SESSION['admin_id'];
               $sql = "SELECT COUNT(*) AS total FROM applicant WHERE status = 'passed'";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                $row = $result-> fetch_assoc();
                echo $row['total'];
              } else {
                echo "0";
              }
            }
            ?>
          </h6>
        </p> 
    </div>

    <div class="card" style="margin-top: .5rem; border: #1c3347 .5px solid; height: 60px; "> 
      <p style="margin: .5rem; display: flex; justify-content: space-between; align-items: center;">
      <small>Products (<?php
      include_once "db.php";
      //$today = date('Y-m');
      //$sql = "SELECT COUNT(*) As total FROM product WHERE DATE_FORMAT(datetime, '%Y-%m') = '$today'"; 
      $sql = "SELECT COUNT(*) As total FROM product";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['total'];
      } else {
        echo "0";
      }
      ?>)</small>- 
      <a href="#addProduct" class="btn btn-outline-secondary btn-sm text-dark" style="border: #1c3347 .5px solid;">Add</a>
      </p>
    </div>
  </div>
</div> 

<div class="col-sm-6 col-md-4" style="margin-right: 1rem; margin-top: .5rem;">
  <div class="calendar-header" id="app" style="font-family: 'Poppins', Sans serif;">Applicants</div>
  <div class="card" style="padding: 1rem; border: #1c3347 solid .5px; overflow-y: auto; height: 260px; border-radius: 0 0 10px 10px;">
    <?php
    $sql = "SELECT * FROM applicant AS A INNER JOIN jobOffer AS B ON A.job_id = B.job_id Where status='applicant'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        ?>
        <div class="card mb-2" style="border: #1c3347 .5px solid;">
          <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
          <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
            <small><?= htmlspecialchars($row['job_title']) ?></small>
            <a href="#applications" class="btn btn-outline-secondary btn-sm text-dark applicant-btn" 
               data-job-id="<?= $row['job_id'] ?>" data-applicant-id="<?= $row['id'] ?>"
               style="border: #1c3347 solid .5px;">More Info</a>
          </div>
        </div>
        <?php
      }
    }
    ?>
  </div> 
</div>
 
  <div class="col-sm-6 col-md-4 " style="margin-top: .5rem; display: flex;" >  
    <div class="calendar"> 
         <div class="calendar-header" id="calendar-header" style="font-family: 'Poppins', Sans serif;">
            <?php echo $currentMonthName . ' ' . $currentYear; ?>
        </div>
        <div class="calendar-grid"> 
            <div class="day-name" >S</div>
            <div class="day-name" >M</div>
            <div class="day-name" >T</div>
            <div class="day-name" >W</div>
            <div class="day-name" >T</div>
            <div class="day-name" >F</div>
            <div class="day-name" >S</div>
 
            <?php for ($i = 0; $i < $firstDayOfWeek; $i++): ?>
                <div class="day-number"></div>
            <?php endfor; ?>
 
            <?php for ($day = 1; $day <= $daysInMonth; $day++): ?>
                <div class="day-number <?php echo ($day == $currentDay) ? 'current-day' : ''; ?>">
                    <?php echo $day; ?>
                </div>
            <?php endfor; ?>
        </div> 
    </div>
    
</div>-->
 

<!-- Modal for Applications -->
<div class="modal-dialog" id="applications" style="display: flex; justify-content: center; ">
  <div style="box-shadow: 15px 10px 10px 0px #aaa;">
    <a href="#app" class="modal-close text-dark" title="close">x</a>
    <div id="app-details-content">
      <p>Select Applicant to see info.</p>
    </div>
  </div>
</div>  

<section >
  <div class="row justify-content"> 
    <div class="col">  
       <div class="card" style="overflow-y: auto; height: 100px; padding: 20px; box-shadow: 5px 0px 10px 0px #aaa; border: none; display: flex; justify-content: center;">
      <!--<?php
      include_once 'db.php';
      $sql = "SELECT * FROM joboffer";
      $result = $conn->query($sql);

      if ($result -> num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          ?>
          <div class="card" style="border: #1c3347 .5px solid; margin-top: .5rem; border-radius: 15px;">
          <div class="card-body">
          <h5 style="text-align: center;"><?= htmlspecialchars($row['job_title'])?></h5>
          <p><?= htmlspecialchars($row['job_desc'])?></p> 
        </div>
      </div>

          <?php
        }
      }
      ?> -->  
      </div>
      </div>

      <div class="col order-5"> 
         <div class="card" style="box-shadow: 5px 0px 10px 0px #aaa; padding: 20px; height: 100px; overflow-y: auto; display: flex; justify-content: center;"> 
           
        </div> 
      </div>

      <div class="col order-1">
        <!-- <img src="" alt=""> -->
        <div class="card" style="box-shadow: 5px 0px 10px 0px #aaa; padding: 20px; height: 100px; display: flex; justify-content: center;">
           
        </div>
      </div>

    </div>
  </div>
</section>

<br>  

<!--End Modal-->
 
<br>
<br> 
<div class="modal-dialog" id="Add" > 
  <div class="col-sm-6"> 
    <div class="card" style="border:rgb(255, 255, 255) solid 1px; width: auto; height: auto;">
      <div class="card-body">
        <div class="row">
            <a href="#" class="modla-close text-dark" title="close" style="margin-left: 18rem">x</a>
          <div class="col-12"> 
            <div class="card" style="text-align: center; background-color:rgb(151, 178, 201)">Add New Job</div>
            <div class="form-group" >
              <label class="form-label text-white fs-7"></label>
              <input type="text" class="form-control border rounded" placeholder="Job Title" name="jobtitle" required>
            
              <label class="form-label text-white fs-7"></label>
              <input type="text" class="form-control border rounded" placeholder="Job Type" name="jobtype" required>

              <label class="form-label text-white fs-7"></label>
              <textarea class="form-control border rounded" placeholder="Job Description" name="jobdesc" rows="2" required></textarea>
           
              <label class="form-label text-white fs-7"></label>
              <textarea name="" id="exp" placeholder="Job Experience" class="form-control border rounded" rows="2" required></textarea>
            
              <label class="form-label text-white fs-7"></label>
              <input type="text" class="form-control border rounded" placeholder="Salary" name="salary" required>

              <label class="form-label text-white fs-7"></label>
              <input type="text" class="form-control border rounded" placeholder="Benefits" name="benefits" required><br>

              <button type="button" class="btn btn-outline-secondary" style="margin-left: 15rem;">Add</button><br><br>

            </div> 
        </div>
      </div>
    </div>
  </div>
</div> 
</div> 

<!--Modal Add Job--> 
  <div class="modal-dialog" id="addProduct" style="align-items: center; justify-content: center; display: flex; font-family: 'Poppins', Sans serif;">
    <div style="box-shadow: 15px 10px 10px 0px #aaa; border: #1c3347 .5px solid;">

    <form action="admn.php" method="POST">
    <a href="#" class="modal-close text-dark" title="close">x</a> 
    <h5 style="text-align: center;">Add Product</h5>

    <?php
    if (isset($alert)) {
      echo $alert;
    }
    ?>   
    <div class="form-group">
      <input type="text" class="form-control border rounded" style="margin-top: .5rem;" placeholder="Product Name" name="prod_name" required>
      <input type="text" class="form-control border rounded" style="margin-top: .5rem;" placeholder="Product Description" name="prod_desc" required>
      <input type="text" class="form-control border rounded" style="margin-top: .5rem;" placeholder="Product Type" name="product_type" required>
      <input type="text" class="form-control border rounded" style="margin-top: .5rem;" placeholder="Product Price" name="product_price" required>
      <input type="file" class="form-control border rounded" style="margin-top: .5rem;" name="image" required>
  
  <div style="display: flex; justify-content: center;">
    <button type="addproduct" class="btn btn-outline-secondary" name="addproduct" id="addproduct">Add Job</button></form> 
  </div>
</div> 
  </div> 

<!--End Modal Add Job-->

<!--Modal--> 
<div id="myModal" class="modal">
  <div class="modal-content"> 
      <span class="close text-dark" id="closeModalBtn">&times;</span> 
      <h3 style="font-family: 'Poppins', Sans-serif;">App</h3>
      
      <table class="table" style="margin-top: 3rem;">
        <thead>
          <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Phonenumber</th>
            <th>Email</th>
            <th>File</th>
          </tr>
        </thead>
        <?php
        include_once "db.php";
        $sql = "SELECT * FROM applicant";
        $result = $conn->query($sql);
        $count = 1;

        if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {   
        ?>
        <tbody>
          <tr>
            <td><?=$row["firstname"]?></td>
            <td><?=$row["lastname"]?></td>
            <td><?=$row["email"]?></td>
            <td><?=$row["phonenumber"]?></td> 
            <td><?=$row["file"]?></td>
          </tr>
        </tbody>
        <?php
        $count++;
        }
        }   
        ?>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!--End Modal App-->

<!--Modal size prob--> 

<div class="modal-dialog" id="modalcon" >
    <div class="card" style="overflow-y: auto;">
        <a href="" class="modal-close text-dark">x</a>
        <h3>Feedbacks</h3> 
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phonenumber</th>
                    <th>Email</th>
                    <th>Message</th>
                </tr>
            </thead>

            <?php 

            include_once "db.php";
            $sql = "SELECT * FROM contact";
            $result = $conn->query($sql);
            $count = 1;

            If ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tbody>
                        <tr>
                            <th style="border: #1c3347 solid .5px"><?=$row["name"]?></th>
                            <th style="border: #1c3347 solid .5px;"><?=$row["phonenumber"]?></th>
                            <th style="border: #1c3347 solid .5px"><?=$row["email"]?></th>
                            <th style="border: #1c3347 solid .5px;"><?=$row["message"]?></th>
                        </tr>
                    </tbody>

                    <?php
                    $count++; 
                }
            } else {
                echo "<tr><th>No data found.</th></td>";
            }
            ?>
        </table>
    </div> 
</div>
<!--End Modal Feedback-->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
   
<script> 
$(document).ready(function() {
  $('.send-btn').on('click', function(e) {
    e.preventDefault();
    const id = $(this).data('id');

    $.ajax({
      url: 'sendmail.php',
      type: 'POST',
      data: { app_id: id },
      success: function(response) {
        $('#sendmail').html(response);
        $('#info').show();
        window.location.hash = 'sendmail';
      },
      error: function() {
        alert('Error loading send mail form.');
      }
    });
  });
  $('.modal-close').on('click', function(e) {
    e.preventDefault();
    $('#sendmail').hide();
    window.location.hash = '';
  });
});
</script>

<!-- Announcement Date -->
<script>
  $(function() {
    var selectedDates;
    datePicker = $('[id*=event_date]').datepicker({
      startDate: new Date();
      minDate: 0,
      format: "mm/dd/YYYY",
      daysOfWeekHighlighted: "0",
      language: 'en',
      daysOfWeekDisabled: [0]
    });
  });
</script>
<!-- End Announcement Date -->

  <script> 
    document.getElementById('openModalBtn').onclick = function() {
      document.getElementById('myModal').style.display = "block";
    } 
    document.getElementById('closeModalBtn').onclick = function() {
      document.getElementById('myModal').style.display = "none";
    }
 
    window.onclick = function(event) {
      if (event.target == document.getElementById('myModal')) {
        document.getElementById('myModal').style.display = "none";
      }
    }
  </script> 

<script>
document.querySelector('form').reset();

document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();  

    var jobTitle = document.querySelector('[name="job_title"]').value;
 
    fetch('check_job_title.php', {
        method: 'POST',
        body: JSON.stringify({ job_title: jobTitle }),
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.exists) {
            alert('This job title already exists.');
        } else { 
            e.target.submit();
        }
    });
});

</script>

<script>
        document.getElementById('nextMonth').addEventListener('click', function() { 
    window.location.href = "?month=" + (currentMonth + 1);
});

document.getElementById('prevMonth').addEventListener('click', function() { 
    window.location.href = "?month=" + (currentMonth - 1);
});

    </script>
<script>
  $(document).ready(function () {
    $('.applicant-btn').click(function () {
        var jobId = $(this).data('job-id');
        var applicantId = $(this).data('applicant-id');
        $.ajax({
            url: 'get_app_details.php',
            type: 'POST',
            data: { job_id: jobId, id: applicantId },
            success: function (response) {
                $('#app-details-content').html(response);
                window.location.hash = 'applications';
            },
            error: function () {
                $('#app-details-content').html('<p>Error loading application details.</p>');
            }
        });
    });
  });
</script>  
  

<!--mail-->
<script>
document.querySelectorAll('.send-mail-btn').forEach(button => {
    button.addEventListener('click', () => {
        const email = button.getAttribute('data-email');
        const name = button.getAttribute('data-name');
        const job = button.getAttribute('data-job'); 
 
        fetch('send_interview_mail.php', {
                    method: 'POST',
            headers: { 
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `email=${encodeURIComponent(email)}&name=${encodeURIComponent(name)}&job=${encodeURIComponent(job)}`
        })
        .then(response => response.text())
        .then(data => {
            alert(data); 
        })
        .catch(error => {
            alert('Error sending email.');
            console.error(error);
        });
    });
});
</script>
 
  <script>
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('sendMailModal');
  modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const appId = button.getAttribute('data-app-id');

    fetch('send_interview.php?id=' + appId)
      .then(response => response.json())
      .then(data => {
        if (data) {
          document.getElementById('modal-app-id').value = data.id;
          document.getElementById('modal-applicant-name').textContent = data.lastname + ' ' + data.firstname;
        }
      });
  });
});
</script>

</body>
</html>