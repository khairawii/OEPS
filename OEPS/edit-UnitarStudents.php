<?php
session_start();
error_reporting(0);
include 'includes/config.php';
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {

       if (isset($_POST['submit'])) {
        $stid = intval($_GET['stid']);
        $studentname = $_POST['fullname'];
        $matricnumber = $_POST['matricno'];
        $studentemail = $_POST['emailid'];
        $mobilenumber = $_POST['mobilenum'];
        $gender = $_POST['gender'];
        $currentsemester = $_POST['sem']; 
        $status = $_POST['status'];

        $sql = "update unistudents set StudentName=:studentname,MatricNumber=:matricnumber,StudentEmail=:studentemail,MobileNumber=:mobilenumber,Gender=:gender,CurrentSemester=:CurrentSemester,Status=:status where Student_id=:stid ";

        $query = $dbh->prepare($sql);
        $query->bindParam(':studentname', $studentname, PDO::PARAM_STR);
        $query->bindParam(':matricnumber', $matricnumber, PDO::PARAM_STR);
        $query->bindParam(':studentemail', $studentemail, PDO::PARAM_STR);
        $query->bindParam(':mobilenumber', $mobilenumber, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':CurrentSemester', $currentsemester, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':stid', $stid, PDO::PARAM_STR);
        $query->execute();

        $msg = "Student info updated successfully";
    }

    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SMS Admin| Update Students </title>

        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/select2/select2.min.css" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
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
                                        <li> Students</li>
            							<li class="active">Manage Students</li>
                                        <li class="active">Update Students</li>                           
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
                                                    <h5><b>Update the Student info</b></h5>
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
 </div><?php }?>

 <!--======================= Update the form ==================================-->
<form class="form-horizontal" method="post">

<!--=====================Update the database of Student===============================-->

<?php
    $stid = intval($_GET['stid']);
    $sql = "SELECT * from unistudents where Student_id=:stid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':stid', $stid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {?>

<!--=====================Update the Full Name of Student===============================-->
<div class="form-group">
<label for="default" class="col-sm-2 control-label">Full Name</label>
<div class="col-sm-10">
<input type="text" name="fullname" class="form-control" id="fullname" value="<?php echo htmlentities($result->StudentName) ?>" required="required" autocomplete="off">
</div>
</div>
<!--=====================Update the Matric Number of Student===============================-->
<div class="form-group">
<label for="default" class="col-sm-2 control-label">Matric Number</label>
<div class="col-sm-10">
<input type="text" name="matricno" class="form-control" id="matricno" value="<?php echo htmlentities($result->MatricNumber) ?>" maxlength="15" required="required" autocomplete="off">

</div>
</div>
<!--=====================Update the Email id of Student===============================-->
<div class="form-group">
<label for="default" class="col-sm-2 control-label">Email Address</label>
<div class="col-sm-10">
<input type="email" name="emailid" class="form-control" id="email" value="<?php echo htmlentities($result->StudentEmail) ?>" required="required" autocomplete="off">
</div>
</div>

<!--=====================Update the Mobile Number of Student===============================-->
<div class="form-group">
<label for="default" class="col-sm-2 control-label">Mobile Number</label>
<div class="col-sm-10">
<input type="tel" name="mobilenum" class="form-control"  id= "mobilenum" value="<?php echo htmlentities($result->MobileNumber) ?>" required="required" autocomplete="off">
<p class="help-block">Remove any characters/spaces/negative numbers.  Enter numbers only, e.g. 00601113328804</p> 
</div>
</div>

    <!--============Update the Gender of Student if male is selected==================-->
<div class="form-group">
<label for="default" class="col-sm-2 control-label">Gender</label>
<div class="col-sm-10">
<?php $gndr = $result->Gender;
            if ($gndr == "Male") {
                ?>
<input type="radio" name="gender" value="Male" required="required" checked>Male &nbsp;&nbsp;&nbsp;
<input type="radio" name="gender" value="Female" required="required">Female
<?php }?>

 <!--============Update the Gender of Student if female is selected==================-->
<?php
if ($gndr == "Female") {
                ?>
<input type="radio" name="gender" value="Male" required="required" >Male <input type="radio" name="gender" value="Female" required="required" checked>Female
<?php }?>
</div>
</div>

<!--=====================Update Current Semester of Student===============================-->
<div class="form-group">
<label for="date" class="col-sm-2 control-label">Current Semester</label>
     <div class="col-sm-10">
     <input type="month"  name="sem" class="form-control" value="<?php echo htmlentities($result->CurrentSemester) ?>" id="date">
</div>
</div>

<!--=====================No need to Updated the Reg date for Students=======================-->
<div class="form-group">
<label for="default" class="col-sm-2 control-label">Reg Date: </label>
<div class="col-sm-10">
<?php echo htmlentities($result->RegDate) ?>
</div>
</div>

<!--=====================Updated the Status for Students===============================-->
<div class="form-group">
<label for="default" class="col-sm-2 control-label">Status</label>
<div class="col-sm-10">
<?php $stats = $result->Status;
            if ($stats == "1") {
                ?>
<input type="radio" name="status" value="1" required="required" checked>Active  &nbsp;&nbsp;&nbsp;
<input type="radio" name="status" value="0" required="required">Block
<?php }?>
<?php
if ($stats == "0") {
                ?>
<input type="radio" name="status" value="1" required="required" >Active  &nbsp;&nbsp;&nbsp;
<input type="radio" name="status" value="0" required="required" checked>Block
<?php }?>
</div>
</div>

<?php }}?>
<!--=====================Submit the Info of Student===============================-->

 <div class="form-group">
     <div class="col-sm-offset-2 col-sm-10">
     
        <!--================ Back Button=================-->
         <a href="manage-UnitarStudents.php" class="btn btn-danger btn-labeled pull-left"><font face="Trebuchet MS" ><b>Back</font><span class="btn-label btn-label-right"><i class="fa fa-close"></i></span></a>
          <!--================ Sumbit Button=================-->
         <button type="submit" name="submit" class="btn btn-primary btn-labeled pull-left">Update<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button> 
   
        
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
