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
    $product_price = $_POST['product_price'];
 
    if (isset($_FILES['prod_image']) && $_FILES['prod_image']['error'] === UPLOAD_ERR_OK) {
        $prod_image = $_FILES['prod_image']['name'];
        $tmp = explode(".", $prod_image);
        $newFilename = round(microtime(true)) . '.' . end($tmp);
        $uploadpath = "uploads/" . $newFilename;

        if (move_uploaded_file($_FILES['prod_image']['tmp_name'], $uploadpath)) { 
            $sql = "INSERT INTO `product` 
                    (`prod_name`, `prod_desc`, `product_type`, `product_price`, `prod_image`) 
                    VALUES ('$prod_name', '$prod_desc', '$product_type', '$product_price', '$newFilename')";
            
            if ($conn->query($sql)) { 
                header("Location: admn.php?ProductAddedSuccessfully.");
            } else { 
                header("Location: admn.php?Error: . $conn->error");
            }
        } else { 
            header("Location: admn.php?Failed");
        }
    } else { 
        header("Location: admn.php?ImageUploadFaliedOrNoImageSelected");
    }
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
  $event_date = $_POST['event_date'];
  $event_desc = $_POST['event_desc'];
  $event_location = $_POST['event_location'];

  $sql = "INSERT INTO `events` (`event_title`, `event_date`, `event_desc`, `event_location`) VALUES ('$event_title', '$event_date', '$event_desc', '$event_location')" ;
  $query = mysqli_query($conn, $sql);

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

    <style>
      /* Calendar */
      td {
      padding: 10px;
      cursor: pointer;
      position: relative; 
      }
      td:hover {
        background: #6184ac; 
        color: white;
      }
      .selected {
        background-color: #6184ac !important;
        color: black;
        border-radius: 50%;
      }
      .event-day {
        background-color:rgb(63, 15, 15);
        border-radius: 50%; 
        box-shadow: 5px 0px 10px 0px #aaa;  
        color: white;
      }
      .today {
        background-color:rgb(14, 34, 51);
        border-radius: 100%;
        color: white;
      } 
      #selected-date-display {
        text-align: center;
        margin-top: 10px;
        font-weight: bold;
      }
            
      .flex-calendar {
        max-width: 350px;
        margin: auto;
        font-family: 'Poppins', sans-serif; 
      }
      .flex-calendar table {
        width: 100%;
        text-align: center;
        border-collapse: collapse;
      }
      .flex-calendar th { 
        font-weight: 600;
        padding: 0.3em 0;
      }
      .flex-calendar td {
        padding: 0.4em 0;
        cursor: pointer;
        border-radius: 50%;
        transition: background 0.2s;
      }
      .flex-calendar td:hover { 
        color: #fff;
      }
      .flex-calendar .calendar-nav-btn {
        border: none;
        background: transparent;
        font-size: 1.2rem;
        cursor: pointer;
      }
      .flex-calendar .calendar-header {
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1.5em;
        margin-bottom: 0.5em;
      }
      .flex-calendar .calendar-form input[type="text"] { 
        border-radius: 10px;
        width: 100%;
        margin-bottom: 0.5em;
        padding: 0.3em;
      }
      .flex-calendar .calendar-form button { 
        border-radius: 10px;
        background: transparent;
        margin-top: 0.5em;
      }
      @media (max-width: 500px) {
        .flex-calendar { max-width: 100%; padding: 0.5rem; }
      }
    </style>
</head>
 
<body>
<meta http-equiv="Cache-Control" content="no-store" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
   
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="display: flex; justify-content: center; font-family: 'Poppins', Sans-serif;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
        <img src="data:image/png;base64,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" alt="" style="height: 30px; width: 30px; border-radius: 50px;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav" style="justify-content: right;">
      <ul class="navbar-nav" style="font-family: 'Poppins', Sans serif;">
        <li class="nav-item">
          <a class="nav-link" href="#">Home</a>
        </li> 
        <li class="nav-item">
          <a class="nav-link" href="#applicants">Application</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="Logout.php" style="color:rgb(71, 15, 15);">Log Out</a>
        </li> 
      </ul>
    </div>
  </div>
</nav>
 
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.navbar-collapse .nav-link');
    const navbarCollapse = document.querySelector('.navbar-collapse');

    navLinks.forEach(function (link) {
      link.addEventListener('click', function () {
        if (navbarCollapse.classList.contains('show')) {
          new bootstrap.Collapse(navbarCollapse).hide();
        }
      });
    });
  });
</script> 

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
          $sql = "SELECT * FROM admin WHERE admin_id = '1' ";
          $result = $conn->query($sql);
          
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { 
              echo htmlspecialchars($row['username']);
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
                  <a href="#jobs" class="btn btn-outline-secondary btn-sm text-dark" style="border: #1c3347 .5px solid; background-color: transparent; border-radius: 10px; box-shadow: 5px 0px 10px 0px #aaa;">Add Job</a>
                </div>
              </div>
            </div>
          </div>   

          <!-- Scheduled Interviews -->
          <div class="col mt-2 mt-md-0">
            <div class="card h-100" style="box-shadow: 5px 0px 20px 0px #1c3347; border: none;">
              <span class="position-absolute top-0 start-0 text-white px-3 py-1 rounded-end" 
              style="font-size: 0.75rem; background-color: #1c3347;">
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
                  <a href="#" class="btn btn-outline-secondary btn-sm text-dark" style="border: #1c3347 .5px solid; border-radius: 10px; background-color: transparent; box-shadow: 5px 0px 10px 0px #aaa;">View</a>
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
 

          <div class="col mt-2 mt-md-0">
            <div class="card h-100" style="box-shadow: 5px 0px 10px 0px #1c3347; border: none; position: relative;">
              
              <span class="position-absolute top-0 start-0 text-white px-3 py-1 rounded-end" 
                    style="font-size: 0.75rem; background-color: #1c3347;">
                <?php
                include_once "db.php";
                $date = date('Y-m');
                $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM jobOffer WHERE DATE_FORMAT(datetime, '%Y-%m') = ? AND status = '1' ");
                $stmt->bind_param("s", $date);
                $stmt->execute();
                $stmt->bind_result($totalJobs);
                $stmt->fetch();
                echo $totalJobs;
                $stmt->close();
                ?>
              </span>

              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h5 style="margin-top: 1rem;"><i class="fa fa-solid fa-briefcase"></i> Jobs</h5>
                </div>

                <div style="max-height: 100px; overflow-y: auto;">
                  <?php
                  $sql = "SELECT job_id, job_title FROM jobOffer WHERE status = '1' ";
                  $result = $conn->query($sql);

                  if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                  ?>
                      <div class="card mb-2 p-2" style="border: #1c3347 .5px solid; border-radius: 10px; ">
                        <div class="d-flex justify-content-between align-items-center">
                          <p class="mb-1"><?= htmlspecialchars($row['job_title']) ?></p>
                          <!-- <a href="#jobinfo" 
                            class="btn btn-outline-secondary btn-sm app-btn text-dark" 
                            data-job-id="<?= $row['job_id'] ?>" 
                            style="border: #1c3347 .5px solid; border-radius: 15px; background: transparent; margin-bottom: .5rem; 
                            margin-right: .5rem; font-family: 'Poppins', Sans serif; box-shadow: 5px 0px 10px 0px #aaa;">View</a>  -->
                            
                            <button class="btn btn-outline-secondary btn-sm text-dark bg-light app-btn" data-job-id="<?= htmlspecialchars($row['job_id'])?>" style="border-radius: 15px; border: #1c3347 .5px solid; box-shadow: 5px 0px 10px 0px #aaa;">View Job</button>
                        </div>
                      </div>
                  <?php
                    }
                  } else {
                    echo "<p>No job offers available.</p>";
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>

 
        </div>
      </div>
    </div>
    <!--  -->   

    <!-- Right Panel -->
    <div class="col-md-4" style="margin-top: .5rem; margin-bottom: .5rem;"> 
      <!-- <div class="card mb-3" style="max-height: 190px; overflow-y: auto; border-radius: 15px; margin-top: .5rem; box-shadow: 5px 0px 10px 0px #1c3347; border: #1c3347 .5px solid; font-family: 'Poppins', Sans serif;">
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

        </span>  -->

      <!-- <div class="card-body" style="margin-top: 1rem;" >
          <h5>Notifications</h5>
          <?php 
          include_once "db.php";
          $today = date('Y-m-d');
          $sql = "SELECT * FROM applicant As A inner join jobOffer As B On A.job_id = B.job_id WHERE a.status = 'applicant' And DATE_FORMAT(A.datetime, '%Y-%m-%d') = '$today'";
          $result = $conn->query($sql);

          if ($result && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  ?>
                  <div class="card-box" style="border-radius: 15px; box-shadow: 7px 2px 12px 2px #aaa; padding: 1rem; margin: .5rem 0;">
                    <div class="d-flex align-items-center">
                      <span style="background-color: #6184ac; width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 10px;"></span>
                      <p class="mb-0 small"><?= htmlspecialchars($row['job_title']) ?> , <?= htmlspecialchars($row['lastname'])?></p>
                    </div>
                  </div>
                  <?php
              }
          } else {
              echo "<p class='text-muted small' style='text-align: center;'>No applicant for today.</p>";
          }
          ?>

        </div>
  
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

      </div> -->
          
      <!-- Events List --> 
<!-- Calendar with Script --> 
 
  <div id="calendar" class="flex-calendar" style="margin-top: 1rem; margin: 1rem; max-width: 400px; margin: auto; font-family: 'Poppins', Sans serif; border: #1c3347 .5px solid; padding: 1rem; box-shadow: 7px 2px 12px 2px #1c3347; border-radius: 15px;">
    
    <div style="text-align: center; justify-content: center;">
      <button onclick="changeMonth(-1)" style="border: none; background-color: transparent;">&#8592;</button>
      <span id="month-year"></span>
        <button onclick="changeMonth(1)" style="border: none; background-color: transparent;">&#8594;</button>
    </div>

    <table style="width: 100%; text-align: center; border-collapse: collapse; ">
      <thead style="border: #1c3347 .5px solid;">
        <tr>
          <th style="color:rgb(100, 13, 13);">Su</th>
          <th class="text-dark">Mo</th>
          <th class="text-dark">Tu</th>
          <th class="text-dark">We</th>
          <th class="text-dark">Th</th>
          <th class="text-dark">Fr</th>
          <th class="text-dark">Sa</th>
        </tr>
      </thead>
      <tbody id="calendar-body" style="border: #1c3347 .5px solid;" class="text-dark"></tbody>
    </table>

    <div id="selected-date-display" style="display: flex; justify-content: center;">No date selected</div>
 
    <form action="admn.php" method="POST" style="margin-top: 10px; text-align: center;"> 
      
      <input type="hidden"  id="selected-date" name="event_date"> 
      <input type="text" class="form-control" style="border: #1c3347 .5px solid; border-radius: 10px; box-shadow: 5px 0px 10px 0px #aaa;" placeholder="Event title" name="event_title" required>
      <textarea name="event_desc" id="" class="form-control" style="border: #1c3347 .5px solid; background-color: transparent; border-radius: 10px; margin-top: .5rem; box-shadow: 5px 0px 10px 0px #aaa;" placeholder="Event Description" rows="3" required></textarea>
      <input type="text" class="form-control" style="border: #1c3347 .5px solid; background-color: transparent; border-radius: 10px; margin-top: .5rem; box-shadow: 5px 0px 10px 0px #aaa;" placeholder="Event Location" required>
      <div style="display: flex; justify-content: right;">
        <button type="submit" name="btn-submit" class="btn btn-outline-secondary btn-sm text-dark" style="border: #1c3347 .5px solid; border-radius: 10px; background-color: transparent; margin-top: .5rem; box-shadow: 5px 0px 10px 0px #1c3347;">Submit</button>
      </div>
    </form>

  </div>

 <script>
    let currentDate = new Date();
    let selectedCell = null;
    let eventDates = [];

    fetch('get_events.php')
        .then(response => response.json())
        .then(data => {
            eventDates = data;
            showCalendar(currentDate.getMonth(), currentDate.getFullYear());
        });

    function showCalendar(month, year) {
        const calendarBody = document.getElementById("calendar-body");
        calendarBody.innerHTML = "";

        const firstDay = new Date(year, month).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        document.getElementById("month-year").innerText =
            new Date(year, month).toLocaleString('default', { month: 'long', 
                year: 'numeric' });

        const today = new Date();
        let date = 1;
        for (let i = 0; i < 6; i++) {
            const row = document.createElement("tr");

            for (let j = 0; j < 7; j++) {
                const cell = document.createElement("td");
                if (i === 0 && j < firstDay) {
                    cell.innerText = "";
                } else if (date <= daysInMonth) {
                    const currentDay = date;
                    const fullDate = `${year}-${String(month + 1).padStart(2,
                     '0')}-${String(currentDay).padStart(2, '0')}`;

                    cell.innerText = currentDay;
                    cell.onclick = () => selectDate(currentDay, month, year,
                    cell);

                    const isToday =
                        currentDay === today.getDate() &&
                        month === today.getMonth() &&
                        year === today.getFullYear();

                    const hasEvent = eventDates.includes(fullDate);

                    if (hasEvent) cell.classList.add("event-day");
                    if (isToday) cell.classList.add("today");

                    date++;
                } else {
                    cell.innerText = "";
                }
                row.appendChild(cell);
            }

            calendarBody.appendChild(row);
        }
    }

    function changeMonth(offset) {
        currentDate.setMonth(currentDate.getMonth() + offset);
        showCalendar(currentDate.getMonth(), currentDate.getFullYear());
    }

    function selectDate(day, month, year, cell) {
        if (selectedCell) selectedCell.classList.remove("selected");
        selectedCell = cell;
        selectedCell.classList.add("selected");

        const formatted = `${year}-${String(month + 1).padStart(2, '0')
        }-${String(day).padStart(2, '0')}`;
 
        document.getElementById("selected-date").value = formatted;
        document.getElementById("selected-date-display").innerText = "Selected Date:" + formatted;
        } 
  
</script>
  
<!-- End Calendar Script -->
  
        </div>
      </div>
    </div>  

<!-- Modal -->
<div class="modal-dialog" id="jobinfooo">
  <div>
    <a href="#" class="modal-close text-dark" title="close">x</a>
    <div class="form-group">
      <?php
      include_once "db.php";
      $sql = "SELECT * FROM jobOffer";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          ?>
          <h5><?= htmlspecialchars($row['job_title'])?></h5>
          <p><?= htmlspecialchars($row['job_desc'])?></p>
          <p><?= htmlspecialchars($row['job_type'])?></p>
          <?php
        }
      }
      ?>
    </div>
  </div>
</div>
 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Modal -->
<div class="modal-dialog" id="jobinfo" style="display: none; font-family: 'Poppins', sans-serif; justify-content: center; align-items: center; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050;">
  <div style="box-shadow: 7px 2px 12px 2px #aaa; background: #fff;">
    <a href="#" class="modal-close text-dark" title="close" id="modal-close" style="float:right; margin: 10px; font-weight:bold; cursor:pointer;">x</a>
    <div id="job-info-content" style="padding: 20px;">
      <p style="text-align: center;">Select job to see more info.</p>
    </div>
  </div>
</div> 
<!-- Script -->

<!-- PHP GRAPH -->
<?php 
include_once 'db.php'; 
$date = date('Y');

$sql = "SELECT B.job_title, COUNT(*) AS applicant_count, A.status, COUNT(*) As applicant_status FROM applicant AS A INNER JOIN jobOffer AS B ON A.job_id = B.job_id 
WHERE DATE_FORMAT(A.datetime, '%Y') = '$date' GROUP BY B.job_title ORDER BY B.job_title";

$result = $conn->query($sql);

$jobTitleCount = [];
while ($row = $result->fetch_assoc()) {
    $jobTitleCount[$row['job_title']] = (int)$row['applicant_count'];
    $jobStatusCount[$row['status']] = (int)$row['applicant_status'];
}
 
$labels = json_encode(array_keys($jobTitleCount));
$data = json_encode(array_values($jobTitleCount));

$label = json_encode(array_keys($jobStatusCount));
$datas = json_encode(array_values($jobStatusCount));
?>  

 <!-- GRAP CONTAINER -->
<div class="container text-center">
  <div class="row row-cols-1 row-cols-md-3 g-4">
    <div class="col" style="font-family: 'Poppins', Sans serif;">
      <div class="card shadow p-4" style="border: #1c3347 .5px solid; border-radius: 10px;"> 
        <h4 class="text-center mb-4">Total of Applicants per Job Title</h4>
        <canvas id ="applicantsChart" height="100"></canvas>
      </div>
    </div>

    <div class="col" style="font-family: 'Poppins', Sans serif;">
      <!-- <div class="card shadow p-4" style="border: #1c3347 .5px solid; border-radius: 10px; font-family: 'Poppins', Sans serif;">
        <h4 class="text-center mb-4">Total of Passed Applicants</h4>
        <canvas id="gradientLineChart" height="100"></canvas>
      </div>  -->
    </div>

    <div class="col">
      <!-- <div class="card shadow p-4" style="border: #1c3347 .5px solid; border-radius: 10px; font-family: 'Poppins', Sans serif;">
        <h4 class="text-center mb-4"></h4>
        <canvas id="testChart" height="100"></canvas>
      </div> -->
    </div>

  </div>
</div> 
 
<!-- GRAPH SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script> 
const barCtx = document.getElementById('applicantsChart').getContext('2d');

new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: <?php echo $labels; ?>,
        datasets: [{
            label: 'Number of Applicants',
            data: <?php echo $data; ?>,
            backgroundColor: '#6184ac',
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        animation: {
            duration: 1500,
            easing: 'easeOutQuart',
            delay: (context) => context.dataIndex * 300, 
        },
        plugins: {
            legend: { display: false },
            title: {
                display: true,
                // text: 'Applicants per Job Title'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        const value = context.raw;
                        const percent = ((value / total) * 100).toFixed(1);
                        return `${value} applicants (${percent}%)`;
                    }
                }
            },
            datalabels: {
                anchor: 'end',
                align: 'top',
                formatter: function(value, context) {
                    const data = context.chart.data.datasets[0].data;
                    const total = data.reduce((a, b) => a + b, 0);
                    const percent = ((value / total) * 100).toFixed(1);
                    return `${value} (${percent}%)`;
                },
                color: '#000',
                font: {
                    weight: 'bold'
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Applicants'
                }
            }
        }
    },
    plugins: [ChartDataLabels]
});

//For Line Graph
// const lineCtx = document.getElementById('gradientLineChart').getContext('2d');
// const gradientPurple = lineCtx.createLinearGradient(0, 0, 0, 300);
// gradientPurple.addColorStop(0, 'rgb(57, 89, 125)' );
// gradientPurple.addColorStop(1, 'rgb(28, 46, 74)');

// const gradientOrange = lineCtx.createLinearGradient(0, 0, 0, 300);
// gradientOrange.addColorStop(0, 'rgb(28, 51, 71)');
// gradientOrange.addColorStop(1,'rgb(82, 103, 125)' );

// const gradientBlue = lineCtx.createLinearGradient(0, 0, 0, 300);
// gradientBlue.addColorStop(0, 'rgb(62, 105, 133)'); 
// gradientBlue.addColorStop(1, 'rgb(189, 196, 212)'); 

// new Chart(lineCtx, {
//     type: 'line',
//     data: { 
//         labels: <?php echo $labels; ?>,
//         datasets: [
//             {
//                 label: 'Passed', 
//                 data: <?php echo $datas; ?>, 
//                 borderColor: '#1c2e4a',
//                 backgroundColor: gradientPurple,
//                 tension: 0.4,
//                 fill: true,
//                 pointBackgroundColor: '#1c2e4a',
//                 pointRadius: 5
//             },
//             {
//                 label: 'For Interview', 
//                 data: <?php echo $datas; ?>,
//                 borderColor: '#6184ac',
//                 backgroundColor: gradientOrange,
//                 tension: 0.4,
//                 fill: true,
//                 pointBackgroundColor: '#6184ac',
//                 pointRadius: 5
//             }, 
//              {
//                 label: 'Failed',
//                 data: <?php echo $datas; ?>,
//                 borderColor: '#3e6985',
//                 backgroundColor: gradientBlue,
//                 tension: 0.4,
//                 fill: true,
//                 pointBackgroundColor: '#3e6985',
//                 pointRadius: 5
//             }
//         ]
//     },
//     options: {
//         responsive: true,
//         plugins: {
//             legend: {
//                 position: 'top'
//             }
//         },
//         scales: {
//             y: {
//                 beginAtZero: true
//             }
//         }
//     }
// });
      

// For Donut Graph
// const testCtx = document.getElementById('testChart').getContext('2d');

// new Chart(testCtx, {
//     type: 'pie',
//     data: { 
//         labels: <?php echo $labels; ?>,
//         datasets: [{  
//             data: <?php echo $data; ?>,
//             backgroundColor: ['#6184ac', '#1c3347', '#3053a6', '#3e6985', '#1c2e4a']
//         }]
//     },
//     options: {
//         responsive: true,
//         plugins: {
//             datalabels: {
//                 formatter: (value, context) => {
//                     const dataArr = context.chart.data.datasets[0].data;
//                     const sum = dataArr.reduce((a, b) => a + b, 0);
//                     const percentage = ((value / sum) * 100).toFixed(1);
//                     return `${value} (${percentage}%)`;
//                 },
//                 color: '#fff',
//                 font: {
//                     weight: 'bold',
//                     size: 14
//                 }
//             },
//             legend: {
//                 position: 'bottom'
//             }
//         }
//     },
//     plugins: [ChartDataLabels]
// });
 
</script>

<!-- Applicants Lists (Passed, For interview, Failed) --> 
 <section class="container my-5" style="font-family: 'Poppins', sans-serif;" id="applicants" style="font-family: 'Poppins', Sans serif;">
  <div class="card" style="padding: 1rem; border: #1c3347 .5px solid; box-shadow: 7px 2px 12px 2px #1c3347; height: 450px; overflow-y: auto; border-radius: 15px;">
  
    <div class="row justify-content-between align-items-center mb-3">
      <div class="col-md-4 col-12 mb-2 mb-md-0">
        <h2 style="font-family: 'Poppins', Sans serif;">Applicants</h2> 
      </div>
      <div class="col-md-8 col-12">
        <form action="" method="GET">
          <div class="d-flex flex-wrap gap-2 align-items-center">
  
            <div class="form-check">
              <input class="form-check-input status-checkbox" type="checkbox" name="status[]" value="passed" id="statusPassed"
                <?= (isset($_GET['status']) && in_array('passed', $_GET['status'])) ? 'checked' : '' ?>>
              <label class="form-check-label" for="statusPassed">Passed</label>
            </div>

            <div class="form-check">
              <input class="form-check-input status-checkbox" type="checkbox" name="status[]" value="for interview" id="statusInterview"
                <?= (isset($_GET['status']) && in_array('for interview', $_GET['status'])) ? 'checked' : '' ?>>
              <label class="form-check-label" for="statusInterview">For Interview</label>
            </div> 

            <div class="form-check">
              <input type="checkbox" class="form-check-input status-checkbox" name="status[]" value="failed" id="statusNotQualified"
                <?= (isset($_GET['status']) && in_array('failed', $_GET['status'])) ? 'checked' : '' ?>>
              <label class="form-check-label" for="statusNotQualified">Failed</label>
            </div>

            <div class="flex-grow-1">
              <input 
                type="search" 
                class="form-control" 
                name="search" 
                placeholder="Search" 
                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"> 
            </div> 

            <a href="#jobs" class="btn btn-outline-secondary btn-sm text-dark">
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
            <th style="text-align: center;">Job Title</th>
            <th style="text-align: center;">Name</th>  
            <th style="text-align: center;">File</th>
            <th style="text-align: center;">Mail</th>
          </tr>
        </thead>
        <tbody>
         
        <?php 
              include_once 'db.php';
              $searchTerm = trim($_GET['search'] ?? '');
              $statuses = $_GET['status'] ?? [];

              $query = "SELECT A.*, B.job_title FROM applicant AS A
                        LEFT JOIN joboffer AS B ON A.job_id = B.job_id WHERE 1";

              $params = [];
              $types = '';

              if (!empty($statuses)) {
                  $placeholders = implode(',', array_fill(0, count($statuses), '?'));
                  $query .= " AND A.status IN ($placeholders)";
                  $params = array_merge($params, $statuses);
                  $types .= str_repeat('s', count($statuses));
              }

              if (!empty($searchTerm)) {
                  $query .= " AND (A.firstname LIKE ? OR A.lastname LIKE ? OR B.job_title LIKE ?)";
                  $searchLike = '%' . $searchTerm . '%';
                  $params[] = $searchLike;
                  $params[] = $searchLike;
                  $params[] = $searchLike;
                  $types .= 'sss';
              }

              $stmt = $conn->prepare($query);
              if (!$stmt) {
                  echo "<tr><td colspan='4' class='text-danger'>Error: " . $conn->error . "</td></tr>";
              } else {
                  if (!empty($params)) {
                      $stmt->bind_param($types, ...$params);
                  }
                  $stmt->execute();
                  $result = $stmt->get_result();

                  if ($result && $result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                          $fullName = htmlspecialchars($row['firstname'] . ' ' . $row['lastname']);
                          $jobTitle = htmlspecialchars($row['job_title']);
                          $filename = basename($row['file']);
                          $filepath = "files/" . $filename;
                          $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); 
                          if (empty($filename) || !file_exists($filepath)) {
                              $filepath = "files/default.pdf";
                          }
                          ?> 

                          <tr> 
                            <td style="text-align: center;"><?= $jobTitle ?></td>
                            <td style="text-align: center;"><?= $fullName ?></td> 
                            <td>
                              <?php if (in_array($ext, ['pdf', 'doc', 'docx'])): ?>
                                <a href="<?= $filepath ?>" target="_blank">View File</a>
                              <?php else: ?>
                                <span class="text-muted">No file</span>
                              <?php endif; ?>
                            </td>
                            <td class="text-center">
                              <!-- <a href="#MailModal" 
                                 class="btn btn-outline-secondary btn-sm text-dark bg-light send-btn" 
                                 data-id="<?= $row['id'] ?>" 
                                 style="border-radius: 15px;">
                                Send Mail
                              </a> -->
                              <a href="#MailModal"
                              class="btn btn-outline-secondary btn-sm text-dark bg-light send-btn"
                              data-id="<?= $row['id'] ?>"
                              data-email="<?= htmlspecialchars($row['email']) ?>"
                              data-fullname="<?= htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) ?>"
                              style="border-radius: 15px;">
                              Send Mail
                            </a>

                              <!-- <button onclick="openMailModal(12345)" class="btn btn-outline-secondary btn-sm text-dark bg-light send-btn">Send Mail</button> -->
                            </td>
                        </tr>
                          <?php
                      }
                  } else {
                      echo '<tr><td colspan="4" class="text-muted text-center">No applicants found.</td></tr>';
                  }
                  $stmt->close();
              }

              $conn->close();
            ?>
        </tbody>
      </table>
    </div>  
  </div>
</section>
        
<div class="modal-dialog" id="MailModal" style="font-family: 'Poppins', Sans-serif; display: flex; justify-content: center; align-items: center; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050; background: white; padding: 1rem; border: #1c3347 0.5px solid; box-shadow: 5px 0px 10px 0px #1c3347; ">
  <div > 
    <a href="#" onclick="closeModal()" class="modal-close text-dark" title="close" style="float: right; font-size: 1.5rem; text-decoration: none;">x</a>
 
    <div id="mailResponse" class="text-success mb-2"></div>
 
    <form id="mailForm" action="send_mail.php" method="POST">
      <input type="text" name="id" id="modal-applicant-id" class="form-control mb-2" placeholder="Applicant ID" hidden>

      <input type="email" name="email" class="form-control mb-2" placeholder="Recipient Email" required style="border-radius: 10px; border: #1c3347 0.5px solid; box-shadow: 5px 0px 10px #aaa;">
      
      <input type="text" name="subject" class="form-control mb-2" placeholder="Subject" required style="border-radius: 10px; border: #1c3347 0.5px solid; box-shadow: 5px 0px 10px #aaa;">
      
      <textarea name="message" class="form-control mb-2" placeholder="Message" rows="6" required style="border-radius: 10px; border: #1c3347 0.5px solid; box-shadow: 5px 0px 10px #aaa;"></textarea>

      <div class="text-end">
        <button type="submit" class="btn btn-outline-secondary btn-sm text-dark" style="border-radius: 10px; border: #1c3347 0.5px solid; box-shadow: 5px 0px 10px #aaa;">Submit</button>
      </div>
    </form>
  </div>
</div>

<!-- End Applicants Lists (Passed, For Interview, Failed) --> 

<!-- BRB 2025-06-11 -->
 
<!-- <div class="modal-dialog" id="MailModal" style="font-family: 'Poppins', Sans serif; display: flex; justify-content: center; align-items: center; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050;">
  <div style="box-shadow: 5px 0px 10px 0px #1c3347; border: #1c3347 .5px solid; ">
    <a href="#applicants" class="modal-close text-dark" title="close">x</a>

    <div class="form-group"> 
       <form action="sendmail.php" method="POST">  
        <input type="text" name="id" id="modal-applicant-id"> 

        <input type="email" name="email" class="form-control" style="border-radius: 10px; border: #1c3347 .5px solid; box-shadow: 5px 0px 10px 0px #aaa; margin-top: .5rem;" placeholder="Recipient Email" required>
        <input type="text" name="subject" class="form-control" style="border: #1c3347 .5px solid; border-radius: 10px; box-shadow: 5px 0px 10px 0px #aaa; margin-top: .5rem;" placeholder="Subject" required>
        <textarea name="message" class="form-control" placeholder="Message" rows="10" style="border: #1c3347 .5px solid; border-radius: 10px; border-radius: 5px 0px 10px 0px #aaa; margin-top: .5rem;" required></textarea>

        <div class="text-end mt-3">
          <button type="submit" class="btn btn-outline-secondary btn-sm text-dark" style="border-radius: 10px; border: #1c3347 .5px solid; box-shadow: 5px 0px 10px 0px #aaa; margin-top: .5rem;">Submit</button>
        </div>
      </form>
    </div> 

  </div>
</div>   -->

<!-- Modal -->
<script>
  // Handle AJAX form submission
  document.getElementById('mailForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Stop default form submission

    const form = e.target;
    const formData = new FormData(form);

    fetch(form.action, {
      method: 'POST',
      body: formData
    })
    .then(res => res.text())
    .then(data => {
      document.getElementById('mailResponse').innerHTML = data;
      form.reset(); // Optional: Reset the form after submit
    })
    .catch(err => {
      document.getElementById('mailResponse').innerHTML = `<span class="text-danger">Error: ${err.message}</span>`;
    });
  });

  // Modal close function
  function closeModal() {
    document.getElementById('MailModal').style.display = 'none';
  }
</script>



<!-- JavaScript to Control Modal -->
<script>
  function openMailModal(applicantId) {
    document.getElementById('modal-applicant-id').value = applicantId;
    document.getElementById('MailModal').style.display = 'flex';
  }

  function closeMailModal() {
    document.getElementById('MailModal').style.display = 'none';
  }
</script>

  
<script>
$(document).ready(function () {
    $('.app-btn').on('click', function (e) {
        e.preventDefault();
        const jobId = $(this).data('job-id');

        $.ajax({
            url: 'get_details.php',
            type: 'POST',
            data: { job_id: jobId },
            success: function (response) {
                console.log("AJAX Success Response:", response); // Debug
                $('#job-info-content').html(response);
                $('#jobinfo').fadeIn();
                window.location.hash = 'jobinfo';
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error); // Debug
                $('#job-info-content').html('<p>Error loading job details.</p>');
            }
        });
    });

    $('#modal-close').on('click', function (e) {
        e.preventDefault();
        $('#jobinfo').fadeOut();
        window.location.hash = '';
    });
});
</script>

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
      <form action="admn.php" method="POST" enctype="multipart/form-data">
        <input type="text" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" placeholder="Product Name" name="prod_name" required>
        <textarea class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" rows="3" placeholder="Product Description" name="prod_desc" required></textarea>
        <input type="text" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" placeholder="Product Type" name="product_type" required>
        <input type="number" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" placeholder="Product Price" name="product_price" required>
        <input type="file" name="prod_image" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" required>
        <div style="display: flex; justify-content: right; margin-right: .5rem; margin-top: .5rem;"> 
          <button type="submit" name="addproduct" class="btn btn-outline-secondary btn-sm text-dark bg-light" style="border: #1c3347 .5px solid; border-radius: 15px;">Add Product</button>
        </div>
    </form>

      <!-- <form action="admn.php" method="POST">
        <div class="form-group">
          <h5 style="text-align: center;">Add Product</h5>

          <div class="mb-3">
            <input type="text" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" placeholder="Product Name" name="prod_name" required>
            <textarea name="prod_desc" id="" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" placeholder="Product Description" rows="3" required></textarea>
            <input type="text" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" placeholder="Product Type" name="product_type" required>
            <input type="text" class="form-control" style="border: #1c3347 .5px solid; margin-top: .5rem;" placeholder="Product Price" name="product_price" required>
            <input type="file" class="form-control border rounded" style="margin-top: .5rem;" name="prod_image required>
          </div> 

        <div style="display: flex; justify-content: right; margin-right: .5rem;">
          <button type="addproduct" class="btn btn-outline-secondary btn-sm text-dark" style="border-radius: 15px; border: #1c3347 .5px solid; background-color: transparent; box-shadow: 5px 0px 10px 0px #aaa;" name="addproduct" id="addproduct">Add Product</button>
        </div>
        </div>
      </form> -->
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

<script>
  document.querySelectorAll('.open-mail-modal').forEach(button => {
    button.addEventListener('click', () => {
      document.getElementById('modal-app-id').value = button.dataset.appId;
      document.getElementById('modal-app-email').value = button.dataset.appEmail;
    });
  });
</script>
  
<script>
  document.querySelectorAll('.open-mail-modal').forEach(button => {
    button.addEventListener('click', function () {
      const applicantId = this.getAttribute('data-id');  
      document.getElementById('modal-applicant-id').value = applicantId;  
    });
  });
</script> 
   
<!-- <script>
  document.querySelectorAll('.open-mail-modal').forEach(button => {
    button.addEventListener('click', function () {
      const applicantId = this.getAttribute('data-id');  
      document.getElementById('modal-applicant-id').value = applicantId;  
    });
  });
</script> -->
 
<div class="modal-dialog" title="modal">
  <div style="border: #1c3347 .5px solid; box-shadow: 5px 0px 10px 0px #1c3347">
    <a href="#" class="modal-close text-dark" title="close">x</a>
    <div class="form-group">
      <div class="col-12">
        <input type="text" class="form-control" style="border: #1c3347 .5px solid; border-radius: 15px; box-shadow: 5px 0px 10px 0px #aaa; background-color: transparent;" placeholder="Title" name="" required>
      </div>
      <div class="col-12">
        <textarea type="text" class="form-control" style="border: #1c3347 .5px solid; border-radius: 15px; bo-shadow: 5px 0px 10px 0px #aaa; background-color: transparent;" placeholder="Description" name="title_desc" rows="3" required></textarea>
      </div>
      <div class="col-12"></div>
      
    </div>
  </div>
</div>

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
 

  <div class="modal-dialog" id="sendMailModal" style="display: flex; justify-content: center; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1050;">
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

   
<!-- Modal for Applications -->
<div class="modal-dialog" id="applications" style="display: flex; justify-content: center; ">
  <div style="box-shadow: 15px 10px 10px 0px #aaa;">
    <a href="#app" class="modal-close text-dark" title="close">x</a>
    <div id="app-details-content">
      <p>Select Applicant to see info.</p>
    </div>
  </div>
</div>   

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

    <form action="admn.php" method="POST" enctype="mutlipart/form-data">
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
      <input type="file" class="form-control border rounded" style="margin-top: .5rem;" name="prod_image required">
  
  <div style="display: flex; justify-content: center;>
    <button type="addproduct" class="btn btn-outline-secondary" name="addproduct" id="addproduct">Add Job</button></form> 
  </div>
</div> 
  </div> 

<!--End Modal Add Job--> 

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
