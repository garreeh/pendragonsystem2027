<?php
require_once('../connections/connections.php');
session_start();

if (empty($_SESSION['user_name'])):
  header("location:../index.php");
endif;

$user = $_SESSION['user_type_id'];

$sql = "SELECT z_user_restriction.client_add as Res FROM z_user JOIN z_user_restriction
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

    #dropdown {
      width: 200px !important;
    }

    #emailvalidation {
      width: 200px;
    }
  </style>

  <!-- JS for APPENDING -->
  <script type="text/javascript">
    function add_row() {
      $rowno = $("#employee_table tr").length;
      $rowno = $rowno + 1;
      $("#employee_table tr:last").after("<tr id='row" + $rowno + "'><td><select class='form-control' data-skip-name='true' name='client_contact_type[]' class='form-control'><option value='Email'>Email</option><option value='Mobile'>Mobile</option><option value='Telephone'>Telephone</option><option value='Facebook'>Facebook</option><option value='Website'>Website</option></select></td><td><input type='text' class='form-control' name='client_contact_detail[]' placeholder='Add Contact'></td><td><input type='button' class='btn btn-inverse-danger'  value='X' onclick=delete_row('row" + $rowno + "')></td></tr>");
    }

    function delete_row(rowno) {
      $('#' + rowno).remove();
    }
  </script>
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
    <?php include "includes/navs.php" ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_sidebar.html -->


      <!-- ADD CLIENT FORM -->
      <div class="container" id="fullscreen">
        <form action="" method="POST">
          <?php include('../controllers/addClient_process.php'); ?>
          <div class="content-wrapper ">
            <div class="row">
              <!-- CONTAINER LEFT -->
              <div class="col-lg-6">
                <div class="card text-left">
                  <div class="card-body">
                    <div class="card-title">
                      <h5><b>Add Client:</b></h5>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-4">
                        <label for="client_id">ID</label>
                        <input type="text" class="form-control" id="client_id" placeholder="ClientID">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="client_firstname">First Name</label>
                        <input type="text" class="form-control" name="client_firstname" id="client_firstname"
                          placeholder="Firstname" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="client_lastname">Last Name</label>
                        <input type="text" class="form-control" name="client_lastname" id="client_lastname"
                          placeholder="LastName" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="client_address">Whole Address</label>
                        <textarea class="form-control" name="client_address" id="client_address" rows="3"
                          required></textarea>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="client_remarks">Remarks</label>
                        <textarea class="form-control" name="client_remarks" id="client_remarks" rows="3"
                          required></textarea>
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
                          placeholder="StreetNo" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="client_street">Street</label>
                        <input type="text" class="form-control" name="client_street" id="client_street"
                          placeholder="Street" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="client_barangay">Barangay</label>
                        <input type="text" class="form-control" name="client_barangay" id="client_barangay"
                          placeholder="Barangay" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="client_district">District</label>
                        <input type="text" class="form-control" name="client_district" id="client_district"
                          placeholder="District" required>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="client_city">City</label>
                        <input type="text" class="form-control" name="client_city" id="client_city" placeholder="City"
                          required>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="client_province">Province</label>
                        <input type="text" class="form-control" name="client_province" id="client_province"
                          placeholder="Province" required>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="client_zip">Postal Code</label>
                        <input type="text" class="form-control" name="client_zip" id="client_zip"
                          placeholder="Postal Code" required>
                      </div>




                    </div>
                  </div>
                </div>
              </div>


              <!-- <div class="col-lg-6">
                                    <hr style="height:3px;border:none;color:rgb(19, 93, 255);background-color:rgb(62, 123, 255); " />
                                    <div class="card text-left">
                                        <div class="card-body">
                                            <div class="card-title">
                                                <h5><b>Required contact Details:</b></h5>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="Email">Email</label>
                                                    <input type="email" class="form-control" name="Email" id="Email" placeholder="Email">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="MobileNum">Mobile no.</label>
                                                    <input type="email" class="form-control" name="MobileNum" id="MobileNum" placeholder="MobileNum">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div> -->

              <div class="col-lg-6">
                <hr style="height:3px;border:none;color:rgb(19, 93, 255);background-color:rgb(62, 123, 255); " />
                <div class="card text-left">
                  <div class="card-body">
                    <div class="card-title">
                      <h5><b>Additional Contact Details:</b></h5>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <table id="employee_table">
                          <tr id="row1">
                            <td>
                              <select class="form-control" id="dropdown" data-skip-name="true"
                                name="client_contact_type[]" required>
                                <option value="Email">Email</option>
                              </select>
                            </td>
                            <td><input type="email" class="form-control" id="emailvalidation"
                                name="client_contact_detail[]" placeholder="Add Contact" required></td>
                          </tr>
                        </table>
                      </div>

                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <input type="button" class="btn btn-primary btn-rounded btn-fw" onclick="add_row();"
                            value="Add Contact">
                        </div>

                      </div>

                    </div>





                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <hr style="height:3px;border:none;color:rgb(19, 93, 255);background-color:rgb(62, 123, 255); " />
                <div class="card text-left ">
                  <div class="card-body">
                    <div class="card-title">
                    </div>
                    <!-- <button type="button" name="client_submit" class="btn btn-primary btn-rounded btn-fw">Save</button> -->
                    <input type="submit" id="ids" class="btn btn-primary btn-rounded btn-fw" name="client_submit"
                      id="client_submit" value="save">

                  </div>
                </div>
              </div>
            </div>

          </div>
        </form>
      </div>
      <script type="text/javascript">
        $("#ids").unbind('click').on("click", function () {


          dropdownvalidate();
          emailvalidate();

          if (dropdownvalidate() === true &&
            emailvalidate() === true

          ) {

          };


        });


        function dropdownvalidate() {
          if ($("#dropdown option:selected").val() === "") {
            $("#dropdown").removeClass("is-valid").addClass("is-invalid");
            return false;
          } else {
            $("#dropdown").removeClass("is-invalid").addClass("is-valid");
            return true;
          }

        };

        function emailvalidate() {
          if ($('#emailvalidation').val() == '') {
            $('#emailvalidation').css('border-color', '#dc3545');
            return false;
          } else {
            $('#emailvalidation').css('border-color', '#28a745');
            return true;
          }

        };
      </script>

      <!-- content-wrapper ends -->
      <!-- partial:../../partials/_footer.html -->

      <!-- partial -->
    </div>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../assets/vendors/js/vendor.bundle.base.js "></script>
  <script src="../assets/vendors/js/vendor.bundle.addons.js "></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../assets/js/shared/off-canvas.js "></script>
  <script src="../assets/js/shared/misc.js "></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
  <!--Start auto logout after 10 minutes-->
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