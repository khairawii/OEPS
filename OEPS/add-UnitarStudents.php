<?php
session_start();
error_reporting(0);
include 'includes/config.php';
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
     //Getting Post Values
    if (isset($_POST['submit'])) {
        $studentname = $_POST['fullname'];
        $matricnumber = $_POST['matricno'];
        $studentemail = $_POST['emailid'];
        $mobilenumber = $_POST['mobilenum'];
        $gender = $_POST['gender'];
        $currentsemester = $_POST['sem'];
        $status = 1;

 
// Query for validation of Student name and matric number
$ret="SELECT * FROM unistudents where (StudentName=:sname ||  MatricNumber=:mnumber)";
$queryt = $dbh -> prepare($ret);
$queryt->bindParam(':mnumber',$matricnumber,PDO::PARAM_STR);
$queryt->bindParam(':sname',$studentname,PDO::PARAM_STR);
$queryt -> execute();
$results = $queryt -> fetchAll(PDO::FETCH_OBJ);

// Query for Insertion

if($queryt -> rowCount() == 0)
{
        $sql = "INSERT INTO  unistudents(StudentName,MatricNumber,StudentEmail,MobileNumber,Gender,CurrentSemester,Status) VALUES(:sname,:mnumber,:studentemail,:mobilenumber,:gender,:currentsemester,:status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':sname', $studentname, PDO::PARAM_STR);
        $query->bindParam(':mnumber', $matricnumber, PDO::PARAM_STR);
        $query->bindParam(':studentemail', $studentemail, PDO::PARAM_STR);
        $query->bindParam(':mobilenumber', $mobilenumber, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':currentsemester', $currentsemester, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if ($lastInsertId) {
            $msg = "Student info added successfully";
        } else {
            $error = "Something went wrong. Please try again";
        }
    }
    else
{
$error= " Student Name or Matric Number already exists. Please use new Student Name or Matric Number.";
}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SMS Admin| Student Admission </title>

        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/select2/select2.min.css" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>

        <!--Java script for check Student name availability-->
<script>
function checkStudentnameAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check-availability.php",
data:'studentname='+$("#studentname").val(),
type: "POST",
success:function(data){
$("#studentname-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){
}
});
}
</script>

<!--Java script for check Matric Number availability-->
<script>
function checkMatricnumberAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check-availability.php",
data:'matricnumber='+$("#matricnumber").val(),
type: "POST",
success:function(data){

$("#matricnumber-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){
 event.preventDefault();
}
});
}</script>
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
  <?php include 'includes/topbar.php';?>
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">

                    <!-- ========== LEFT SIDEBAR ========== -->
                   <?php include 'includes/leftbar.php';?>
                    <!-- /.left-sidebar -->

                    <div class="main-page">

                     <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Student Admission</h2>

                                </div>

                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li class="active">Students</li>
                                        <li class="active">Add Students</li>

                                    </ul>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div><br>
                        <div class="container-fluid">

                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5> <b>Fill in the Student info </b></h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">

<!-- The message you recieve when the info is updated successfully-->
<?php if ($msg) {?>
  <div class="alert alert-success left-icon-alert" role="alert">
     <strong>Well done!</strong><?php echo htmlentities($msg); ?>
     </div><?php }

// The message you recieve when the info is not updated successfully
 else if ($error) {?>
  <div class="alert alert-danger left-icon-alert" role="alert">
     <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
  </div> <?php }?>

        <!--======================= Create the form ==================================-->

    <form class="form-horizontal" method="post">

     <!--=====================Create the Full Name of Student===============================-->

<div class="form-group has-success">
  <label for="default" class="col-sm-2 control-label">Full Name</label>
<div class="col-sm-10">
<input type="text" name="fullname" class="form-control" id="fullname"  onBlur="checkStudentnameAvailability()" placeholder="Enter only letters" required="required" autocomplete="off">
<span id="studentname-availability-status" style="font-size:12px;"></span> 
</div>
</div>
<!--=====================Create the Matric Number of Student===============================-->
<div class="form-group has-success">
<label for="default" class="col-sm-2 control-label">Matric Number</label>
<div class="col-sm-10">
<input type="text" name="matricno" class="form-control" id="matricno"  onBlur="checkMatricnumberAvailability()" placeholder="Enter your Matric No." maxlength="15" required="required" autocomplete="off">
<span id="matricnumber-availability-status" style="font-size:12px;"></span> 
</div>
</div>
<!--=====================Create the Email id of Student===============================-->
<div class="form-group has-success">
<label for="default" class="col-sm-2 control-label">Email Address</label>
<div class="col-sm-10">
<input type="email" name="emailid" class="form-control" id="email" placeholder="Enter your email" maxLength="30" required="required" autocomplete="off">
</div>
</div>
<!--=====================Create the Mobile Number of Student===============================-->
<div class="form-group has-success">
<label for="default" class="col-sm-2 control-label">Mobile Number</label>
<div class="col-sm-10">
<input type="tel" name="mobilenum" class="form-control"  id= "mobilenum" placeholder="Enter Only 11 numbers" pattern="[0-9]{14}" maxlength="14"  required title="Remove any characters/spaces/negative numbers. Enter numbers only, e.g. 00601113328804">
<p class="help-block">Remove any characters/spaces/negative numbers.  Enter numbers only, e.g. 00601113328804</p> 
</div>
</div>
<!--=====================Create the Gender of Student===============================-->

<div class="form-group has-success">
<label for="default" class="col-sm-2 control-label"> Gender </label>
<div class="col-sm-10">
  <input type="radio" name="gender" value="Male" required="required" checked=""> Male &nbsp;&nbsp;&nbsp;
  <input type="radio" name="gender" value="Female" required="required"> Female
</div>
</div>
<!--=====================Create Current Semester of Student===============================-->

<div class="form-group has-success">
<label for="date" class="col-sm-2 control-label">Current Semester</label>
     <div class="col-sm-10">
     <input type="month"  name="sem" class="form-control" id="date" value="2018-01" >
</div>
</div>


<!--=====================Create the Submit for Student info===============================-->

<div class="form-group has-success">
  <div class="col-sm-offset-2 col-sm-14">
      <!--================ Back Button=================-->
      <a href="dashboard.php" class="btn btn-danger btn-labeled pull-left"><font face="Trebuchet MS" ><b>Back</font><span class="btn-label btn-label-right"><i class="fa fa-close"></i></span></a>
      <!--================ Sumbit Button=================-->
      <button type="submit" name="submit" class="btn btn-primary btn-labeled pull-left">Add<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
      
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-12 -->
                                </div>
                    </div>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.main-wrapper -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/select2/select2.min.js"></script>
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $(".js-states").select2();
                $(".js-states-limit").select2({
                    maximumSelectionLength: 2
                });
                $(".js-states-hide").select2({
                    minimumResultsForSearch: Infinity
                });
            });
        </script>
    </body>
</html>
<?PHP }?>
