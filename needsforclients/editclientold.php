<?php
require_once('../connections/connections.php');
session_start();

if (empty($_SESSION['user_name'])):
  header("location:../index.php");
endif;

$user = $_SESSION['user_type_id'];

$sql = "SELECT z_user_restriction.client_edit as Res FROM z_user JOIN z_user_restriction
ON z_user.user_type_id= z_user_restriction.user_type_id WHERE z_user_restriction.user_type_id = '$user'";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {

  $usertest = htmlentities($row['Res']);



  if ($usertest == 0) {
    echo "<script> alert('You do not have access to this form!'); </script>";
    echo '<script> setTimeout(function() { window.location.replace("SearchClient.php"); }, 100); </script>';
  } else if ($usertest == 1) {
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Pendragon System</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../assets/vendors/iconfonts/ionicons/css/ionicons.css">
  <link rel="stylesheet" href="../assets/vendors/iconfonts/typicons/src/font/typicons.css">
  <link rel="stylesheet" href="../assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.addons.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" rel="stylesheet">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../assets/css/shared/style.css">
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="../assets/css/demo_1/style.css">
  <!-- End Layout styles -->
  <link rel="shortcut icon" href="../assets/images/favicon.png" />
  <!-- TEXT FIELD ADDING -->
  <script src="jquery310.js"></script>
  <style>
    .container-medium {
      margin-left: auto;
      margin-right: auto;
      width: 80%;
    }
  </style>
  <!--this for loading-->
  <style>
    #loader {
      position: fixed;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background: url('img/Ripple-1.4s-133px.svg') 50% 50% no-repeat rgb(249, 249, 249);
      opacity: 1;
    }

    #pos {
      margin-left: -42px !important;
    }

    #dept {
      padding-top: 8% !important;
    }
  </style>
  <script src="js/jquery.min.js"></script>
  <script type="text/javascript">
    $(window).on('load', function () {
      setTimeout(function () {
        $('#loader').fadeOut('slow');
      });
    });
  </script>
  <!--end this for loading-->
</head>

<body>
  <!---LOADING BAR--->
  <div id="loader"></div>
  <!---LOADING BAR--->
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="../views/index2.php">
          <img src="../assets/images/logo.svg" alt="logo" /> </a>
        <a class="navbar-brand brand-logo-mini" href="../views/index2.php">
          <img src="../assets/images/logo-mini_3.svg" alt="logo" /> </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <ul class="navbar-nav">
          <li class="nav-item font-weight-semibold d-none d-lg-block">Hotline : (02)34636-3833/(02)8552-9868</li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <!-- NOTIF AND MESSAGE-->
          <!-- <li class="nav-item dropdown">
         <a class="nav-link count-indicator" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
             <i class="mdi mdi-bell-outline"></i>
             <span class="count"></span>
         </a>
         <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="messageDropdown">
             <a class="dropdown-item py-3">
                 <p class="mb-0 font-weight-medium float-left">You have 7 unread mails </p>
                 <span class="badge badge-pill badge-primary float-right">View all</span>
             </a>
             <div class="dropdown-divider"></div>
             <a class="dropdown-item preview-item">
                 <div class="preview-thumbnail">
                     <img src="../assets/images/faces/face10.jpg" alt="image" class="img-sm profile-pic"> </div>
                 <div class="preview-item-content flex-grow py-2">
                     <p class="preview-subject ellipsis font-weight-medium text-dark">Marian Garner </p>
                     <p class="font-weight-light small-text"> The meeting is cancelled </p>
                 </div>
             </a>
             <a class="dropdown-item preview-item">
                 <div class="preview-thumbnail">
                     <img src="../assets/images/faces/face12.jpg" alt="image" class="img-sm profile-pic"> </div>
                 <div class="preview-item-content flex-grow py-2">
                     <p class="preview-subject ellipsis font-weight-medium text-dark">David Grey </p>
                     <p class="font-weight-light small-text"> The meeting is cancelled </p>
                 </div>
             </a>
             <a class="dropdown-item preview-item">
                 <div class="preview-thumbnail">
                     <img src="../assets/images/faces/face1.jpg" alt="image" class="img-sm profile-pic"> </div>
                 <div class="preview-item-content flex-grow py-2">
                     <p class="preview-subject ellipsis font-weight-medium text-dark">Travis Jenkins </p>
                     <p class="font-weight-light small-text"> The meeting is cancelled </p>
                 </div>
             </a>
         </div>
         </li>
         <li class="nav-item dropdown">
             <a class="nav-link count-indicator" id="notificationDropdown" href="#" data-toggle="dropdown">
                 <i class="mdi mdi-email-outline"></i>
                 <span class="count bg-success">3</span>
             </a>
             <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
                 <a class="dropdown-item py-3 border-bottom">
                     <p class="mb-0 font-weight-medium float-left">You have 4 new notifications </p>
                     <span class="badge badge-pill badge-primary float-right">View all</span>
                 </a>
                 <a class="dropdown-item preview-item py-3">
                     <div class="preview-thumbnail">
                         <i class="mdi mdi-alert m-auto text-primary"></i>
                     </div>
                     <div class="preview-item-content">
                         <h6 class="preview-subject font-weight-normal text-dark mb-1">Application Error</h6>
                         <p class="font-weight-light small-text mb-0"> Just now </p>
                     </div>
                 </a>
                 <a class="dropdown-item preview-item py-3">
                     <div class="preview-thumbnail">
                         <i class="mdi mdi-settings m-auto text-primary"></i>
                     </div>
                     <div class="preview-item-content">
                         <h6 class="preview-subject font-weight-normal text-dark mb-1">Settings</h6>
                         <p class="font-weight-light small-text mb-0"> Private message </p>
                     </div>
                 </a>
                 <a class="dropdown-item preview-item py-3">
                     <div class="preview-thumbnail">
                         <i class="mdi mdi-airballoon m-auto text-primary"></i>
                     </div>
                     <div class="preview-item-content">
                         <h6 class="preview-subject font-weight-normal text-dark mb-1">New user registration</h6>
                         <p class="font-weight-light small-text mb-0"> 2 days ago </p>
                     </div>
                 </a>
             </div>
         </li>
         -->
          <?php
          require_once('../connections/connections.php');
          $user = $_SESSION['user_id'];
          $sql = "SELECT * FROM z_user
           JOIN z_user_type ON z_user.user_type_id = z_user_type.user_type_id  where user_id = '$user'";


          $result = $conn->query($sql);

          while ($row = $result->fetch_assoc()) {

            $username = htmlentities($row['user_name']);
            $email = htmlentities($row['user_email']);
            $utype = htmlentities($row['user_type']);
            $utypename = htmlentities($row['user_type_name']);
          }
          ?>
          <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <img class="img-xs rounded-circle" src="../assets/images/faces/face8.jpg" alt="Profile image"> </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <div class="dropdown-header text-center">
                <img class="img-md rounded-circle" src="../assets/images/faces/face8.jpg" alt="Profile image">
                <p class="mb-1 mt-3 font-weight-semibold">Welcome!,<font color="red"><?php echo $username; ?></font>
                </p>
                <p class="font-weight-light text-muted mb-0"><?php echo $email; ?></p>
              </div>
              <!-- <a class="dropdown-item">My Profile <span class="badge badge-pill badge-danger">1</span><i class="dropdown-item-icon ti-dashboard"></i></a>
               <a class="dropdown-item">Messages<i class="dropdown-item-icon ti-comment-alt"></i></a>
               <a class="dropdown-item">Activity<i class="dropdown-item-icon ti-location-arrow"></i></a>
               <a class="dropdown-item">FAQ<i class="dropdown-item-icon ti-help-alt"></i></a> -->
              <a class="dropdown-item" href="../controllers/logout.php">Sign Out<i
                  class="dropdown-item-icon ti-power-off"></i></a>
              <!-- 
               <li class="nav-item">
               <a class="nav-link" href="index.php?logout=true">
                   <i class="fa fa-fw fa-sign-out"></i>Logout
               </a>
               </li> -->
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
          data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
              <div class="profile-image">
                <img class="img-xs rounded-circle" src="../assets/images/faces/face8.jpg" alt="profile image">
                <div class="dot-indicator bg-success"></div>
              </div>
              <div class="text-wrapper">
                <p class="profile-name"><?php echo $username; ?></p>
                <p class="designation"><?php echo $utypename; ?></p>
              </div>
            </a>
          </li>
          <li class="nav-item nav-category">Main Menu</li>
          <li class="nav-item">
            <a class="nav-link" href="index2.php">
              <i class="menu-icon typcn typcn-document-text"></i>
              <span class="menu-title">Cases</span>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link " href="SearchClient.php">
              <i class="menu-icon typcn typcn-document-text "></i>
              <span class="menu-title ">Clients</span>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link " href="SearchPatient.php">
              <i class="menu-icon typcn typcn-document-text "></i>
              <span class="menu-title ">Patients</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth2" aria-expanded="false" aria-controls="auth2">
              <i class="menu-icon typcn typcn-document-add"></i>
              <span class="menu-title">Billing</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth2">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href=""> Old Billing </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href=""> Billing 2.0 </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href=""> Client Balance</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">
              <i class="menu-icon typcn typcn-document-text"></i>
              <span class="menu-title">Purchase Orders</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">
              <i class="menu-icon typcn typcn-document-text"></i>
              <span class="menu-title">Vouchers</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">
              <i class="menu-icon typcn typcn-document-text"></i>
              <span class="menu-title">Medical Pathway</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth5" aria-expanded="false" aria-controls="auth2">
              <i class="menu-icon typcn typcn-document-add"></i>
              <span class="menu-title">Reports</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth5">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="Confinement_reports.php">Confinement Records</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth4" aria-expanded="false" aria-controls="auth2">
              <i class="menu-icon typcn typcn-document-add"></i>
              <span class="menu-title">User</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth4">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="View_user.php">User Control </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="Edit_user.php">Edit User </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="registration.php"> Add User </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="user_type.php"> Add User Type </a>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth3" aria-expanded="false" aria-controls="auth2">
              <i class="menu-icon typcn typcn-document-add"></i>
              <span class="menu-title">Set up</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth3">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="SearchLaboratory.php"> Laboratory </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href=""> Item </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href=""> Item Vaccine Mapping</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="SearchClinicService.php"> Clinic Service</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="SearchSupplier.php"> Supplier </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href=""> Efficacy </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href=""> Vaccine </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href=""> Diagnosis </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href=""> Species </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href=""> Breed </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href=""> Category </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href=""> Serum Chem Standard Values </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href=""> App headline </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href=""> Channel </a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
      <?php
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      require_once('../connections/connections.php');
      $ids = $conn->real_escape_string($_GET['client_id']);
      $query = $conn->query("SELECT * FROM  `client` WHERE `client_id` = '$ids'");

      while ($client = $query->fetch_array()) {
        $ClientID = $client['client_id'];


        // $query2 = $conn->query("SELECT * FROM  `client_contacttest` WHERE `client_contact_id` = '$ClientID'");
        // while ($client2 = $query2->fetch_array()) {
        //     $Clienclientcon = $client2['client_contact_id'];
        //     $Clienclientcontactids = $client2['client_id'];
      



        ?>
        <!--EDIT CLIENT FORM -->
        <div class="container">
          <form action="" method="POST">
            <Br><br>
            <?php include('../controllers/editClient_process.php');
            include('../controllers/lock_client_process.php');
            include('../controllers/unlock_client_process.php');
            ?>



            <div class="content-wrapper ">
              <div class="content-header ">
              </div>
              <div class="container-fluid">
                <div class="row">
                  <!-- CONTAINER LEFT -->
                  <div class="col-lg-6">
                    <div class="card text-left">
                      <div class="card-body">
                        <div class="card-title">
                          <h5><b>Edit Client</b></h5>
                        </div>
                        <div class="form-row">
                          <!-- COPY THIS -->
                          <input type="hidden" class="form-control" name="client_id_locked"
                            value="<?php echo $ClientID; ?>" placeholder="ClientID" readonly>

                          <?php
                          if ($client['client_locked'] == 'yes') {
                            echo '<style>
                                                        .locked {
                                                            display:block;
                                                        }
                                                        .notlocked {
                                                        display:none;
                                                        }
                                                        </style>';
                          } else {
                            echo '<style>
                                                        .notlocked {
                                                            display:block;
                                                        }
                                                        .locked {
                                                            display:none;
                                                        }
                                                        </style>';
                          }

                          ?>


                          <div class="form-group col-md-12 notlocked">
                            <button type="submit"
                              onclick="return confirm('Are you sure you want to tag this client as blocked?');"
                              style="<?php if ($_SESSION['user_type_id'] != 1) {
                                echo 'display:none;';
                              } ?>" name="lock_client"
                              class="btn btn-danger" style="float: right;">BLOCK CLIENT</button>
                          </div>

                          <div class="form-group col-md-12 locked">
                            <button type="submit"
                              onclick="return confirm('Are you sure you want to unblock this client?');"
                              style="<?php if ($_SESSION['user_type_id'] != 1) {
                                echo 'display:none;';
                              } ?>" name="unlock_client"
                              class="btn btn-success" style="float: right;">UNBLOCK CLIENT</button>
                          </div>


                          <!-- END OF COPY THIS -->




                          <div class="form-group col-md-4">
                            <label for="client_id">ID</label>
                            <input type="text" class="form-control" id="client_id" value="<?php echo $ClientID; ?>"
                              placeholder="ClientID" readonly>
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="client_firstname">First Name</label>
                            <input type="text" class="form-control" name="client_firstname" id="client_firstname"
                              value="<?php echo $client['client_firstname']; ?>" placeholder="Firstname">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="client_lastname">Last Name</label>
                            <input type="text" class="form-control" name="client_lastname" id="client_lastname"
                              value="<?php echo $client['client_lastname']; ?>" placeholder="LastName">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="client_address">Whole Address</label>
                            <textarea class="form-control" name="client_address" id="client_address"
                              rows="3"><?php echo $client['client_address']; ?></textarea>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="client_remarks">Remarks</label>
                            <textarea class="form-control" name="client_remarks" id="client_remarks"
                              rows="3"><?php echo $client['client_remarks']; ?></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- CONTAINER RIGHT -->
                  <div class="col-lg-6">
                    <div class="card text-left h-100">
                      <div class="card-body">
                        <div class="card-title">
                          <h5><b>Address:</b></h5>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="client_streetno">Street No.</label>
                            <input type="text" class="form-control" name="client_streetno" id="client_streetno"
                              value="<?php echo $client['client_streetno']; ?>" placeholder="StreetNo">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="client_street">Street</label>
                            <input type="text" class="form-control" name="client_street" id="client_street"
                              value="<?php echo $client['client_street']; ?>" placeholder="Street">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="client_barangay">Barangay</label>
                            <input type="text" class="form-control" name="client_barangay" id="client_barangay"
                              value="<?php echo $client['client_barangay']; ?>" placeholder="Barangay">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="client_district">District</label>
                            <input type="text" class="form-control" name="client_district" id="client_district"
                              value="<?php echo $client['client_district']; ?>" placeholder="District">
                          </div>
                          <div class="form-group col-md-4">
                            <label for="client_city">City</label>
                            <input type="text" class="form-control" name="client_city" id="client_city"
                              value="<?php echo $client['client_city']; ?>" placeholder="City">
                          </div>
                          <div class="form-group col-md-4">
                            <label for="client_province">Province</label>
                            <input type="text" class="form-control" name="client_province" id="client_province"
                              value="<?php echo $client['client_province']; ?>" placeholder="Province">
                          </div>
                          <div class="form-group col-md-4">
                            <label for="client_zip">Postal Code</label>
                            <input type="hidden" class="form-control" name="client_id" id="client_zip"
                              value="<?php echo $client['client_id']; ?>">
                            <input type="text" class="form-control" name="client_zip" id="client_zip"
                              value="<?php echo $client['client_zip']; ?>" placeholder="Postal Code">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <hr style="height:3px;border:none;color:rgb(19, 93, 255);background-color:rgb(62, 123, 255); " />
                    <div class="card text-left">
                      <div class="card-body">
                        <div class="card-title">
                          <h5><b>Additional Contact Details:</b></h5>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-12">
                            <div class="col-md-2">
                            </div>
                            <form name="formname" onsubmit="return false">
                              <table class="table table-bordered" id="dynamic_input">
                                <div class="group col-md-10" id="msg"></div>
                                <?php
                                require_once '../connections/connections.php';
                                $query = $conn->query("SELECT (client_contact.client_id) as client_id,(client_contact.client_contact_id) as contactid,client_contact.client_contact_type,client_contact.client_contact_detail FROM client INNER JOIN client_contact ON  client.client_id = client_contact.client_id where client.client_id = '$ClientID' order by client_contact.client_contact_id limit 1") or die(mysqli_error($conn));
                                while ($fetch = $query->fetch_array()) {
                                  $ClientIDss = htmlentities($fetch['client_id']);
                                  $ClientIDssss = $fetch['contactid'];

                                  echo '<tr>
                                           <th>Contact Type</th>
                                           <th>Contact Details</th>
                                          <th>Action</th> 
                                          </tr>';

                                }

                                ?>
                                <?php
                                require_once '../connections/connections.php';
                                $query = $conn->query("SELECT (client_contact.client_id) as client_id,(client_contact.client_contact_id) as contactid,client_contact.client_contact_type,client_contact.client_contact_detail FROM client INNER JOIN client_contact ON  client.client_id = client_contact.client_id where client.client_id = '$ClientID'") or die(mysqli_error($conn));
                                while ($fetch = $query->fetch_array()) {
                                  $ClientIDss = htmlentities($fetch['client_id']);
                                  $contact_type = $fetch['client_contact_type'];
                                  $contact_detail = $fetch['client_contact_detail'];
                                  $ClientIDsss = $fetch['contactid'];
                                  $clientcontactid = $fetch['contactid'];
                                  $client_id = $fetch['client_id'];


                                  ?>
                                  <tr>
                                    <td><select class="form-control contact_type" name="client_contact_type[]"
                                        value="<?php echo $fetch['client_contact_type']; ?>">
                                        <option value="<?php echo $fetch['client_contact_type']; ?>" hidden>
                                          <?php echo $fetch['client_contact_type']; ?></option>
                                        <option value="Email">Email</option>
                                        <option value="Mobile">Mobile</option>
                                        <option value="Telephone">Telephone</option>
                                        <option value="Facebook">Facebook</option>
                                        <option value="Website">Website</option>
                                      </select></td>
                                    <td><input type="text" class="form-control contact_detail"
                                        name="client_contact_detail[]"
                                        value="<?php echo htmlentities($fetch['client_contact_detail']); ?>"
                                        autocomplete="off" /></td>
                                    <td><button type="button" id="add" class="btn btn-success adds">+</button> | <button
                                        type="button" class="btn btn-danger removes"
                                        value="<?php echo $clientcontactid; ?>">x</button> | <button type="button"
                                        class="btn btn-info edit" value="<?php echo $clientcontactid; ?>">edit</button></td>

                                  </tr>
                                  <?php
                                  $var1 = "<?php echo $contact_type;?>";
                                  $var2 = "<?php echo $contact_detail; ?>";
                                  $var3 = "<?php echo $ClientIDsss;?>";
                                  $var4 = "<?php echo $clientcontactid;?>";
                                  ?>
                                <?php } ?>
                              </table>
                            </form>
                            <hr>
                            <script>
                              var me1 = "<?php $var1; ?>";
                              var me2 = "<?php $var2; ?>";
                              var me3 = "<?php $var3; ?>";
                              var me4 = "<?php $var4; ?>";
                              $(document).ready(function () {
                                var i = 1;
                                $('#add').on('click', function () {

                                  i++;
                                  var input = $(

                                    '<tr id="row' + i + '">'
                                    + '<td><select class="form-control" id="client_contact_type" value="' + me1 + '" name="client_contact_type[]"> <option value="' + me1 + '" hidden>' + me1 + '<option value="Email">Email</option> <option value="Mobile">Mobile</option><option value="Telephone">Telephone</option><option value="Facebook">Facebook</option><option id="Website">Website</option></select></td>'
                                    + '<td><input type="text" id="client_contact_detail" value="' + me2 + '"  class="form-control" autocomplete ="off" name="client_contact_detail[]" placeholder ="Additional Details"/></td>'
                                    + '<td><button type="button" id="adds" class="btn btn-primary" id="' + i + '" value="' + me3 + '">save</button> | <button type="button" id="' + i + '"  class="btn btn-danger remove" value="' + me4 + '">x</button></td>'

                                    + '</tr>'

                                  );
                                  $('#dynamic_input').append(input);

                                });

                                ///REMOVE APPEND FIELD 
                                $(document).on('click', '.remove', function () {
                                  var btn_id = $(this).attr("id");
                                  $('#row' + btn_id + '').remove();


                                  $.ajax({
                                    url: '../controllers/delete_contact_process.php',
                                    method: 'POST',
                                    data: { client_contact_id: btn_id },
                                    success: function (data) {
                                      window.location.reload(true);
                                      // alert(data);


                                    }
                                  });

                                })

                              });


                              $(function () {
                                $(document).on("click", "#adds", function (e) {
                                  e.preventDefault();
                                  var delay = 1000;
                                  var a = $(this).closest('tr').find('td #client_contact_type option:selected').val();
                                  var b = $(this).closest('tr').find('td #client_contact_detail').val();
                                  var c = "<?php echo $ClientIDss; ?>";

                                  $.ajax({
                                    type: "POST",
                                    url: "../controllers/AddAppendContact_process.php",
                                    data: {
                                      client_contact_type: a,
                                      client_contact_detail: b,
                                      client_id: c
                                    },

                                    success: function (data) {
                                      setTimeout(function () {
                                        $('#msg').html(data);
                                      }, delay);
                                      setTimeout(location.reload.bind(location), 2000);

                                    },
                                    error: function (data) {
                                      alert("Failed");
                                    }
                                  });
                                });

                              });

                            </script>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <script type="text/javascript"></script>
                  <script>
                    $(document).ready(function () {

                      ///DETETE FROM TABLE    
                      $(document).on('click', '.removes', function () {
                        var btn_ids = $(this).attr("value");
                        $.ajax({
                          url: '../controllers/delete_contact_process.php',
                          method: 'POST',
                          data: { client_contact_id: btn_ids },
                          success: function (data) {
                            window.location.reload(true);

                          }
                        });

                      })

                    });


                  </script>
                  <div class="col-lg-6">
                    <hr style="height:3px;border:none;color:rgb(19, 93, 255);background-color:rgb(62, 123, 255); " />
                    <div class="card text-left ">
                      <div class="card-body">
                        <div class="card-title">
                        </div>
                        <input type="submit" class="btn btn-primary btn-rounded btn-fw" name="client_edit"
                          id="client_submit" value="save">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      <?php } ?>
    </div>
    <script type="text/javascript">

      $(function () {
        $(document).on("click", ".edit", function (e) {
          e.preventDefault();
          var delay = 1000;
          var aa = $(this).closest('tr').find('td .contact_type option:selected').val();
          var bb = $(this).closest('tr').find('td .contact_detail').val();
          var cc = ($(this).attr("value"));
          var dd = "<?php echo $client_id ?>";

          $.ajax({
            type: "POST",
            url: "../controllers/EditAppendContact_process.php",
            data: {
              client_contact_type: aa,
              client_contact_detail: bb,
              client_contact_id: cc,
              client_id: dd
            },

            success: function (data) {
              setTimeout(function () {
                $('#msg').html(data);
              }, delay);
              setTimeout(location.reload.bind(location), 2000);

            },
            error: function (data) {
              alert("Failed");
            }
          });
        });

      });

    </script>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
  <!-- plugins:js -->
  <script src="../assets/vendors/js/vendor.bundle.base.js "></script>
  <script src="../assets/vendors/js/vendor.bundle.addons.js "></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../assets/js/shared/off-canvas.js "></script>
  <script src="../assets/js/shared/misc.js "></script>
  <!-- endinject -->
  <script type="text/javascript">
    var IDLE_TIMEOUT = 600;
    var _idleSecondsCounter = 0;
    document.onclick = function () {
      _idleSecondsCounter = 0;
    };
    document.onmousemove = function () {
      _idleSecondsCounter = 0;
    };
    document.onkeypress = function () {
      _idleSecondsCounter = 0;
    };
    window.setInterval(CheckIdleTime, 1000);

    function CheckIdleTime() {
      _idleSecondsCounter++;
      var oPanel = document.getElementById("SecondsUntilExpire");
      if (oPanel)
        oPanel.innerHTML = (IDLE_TIMEOUT - _idleSecondsCounter) + "";
      if (_idleSecondsCounter >= IDLE_TIMEOUT) {
        document.location.href = "../controllers/logout.php";
      }
    }
  </script>
  <!--End auto logout after 10 minutes-->
</body>

</html>