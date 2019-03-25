<?php
session_start();
error_reporting(0);
include 'includes/config.php';
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {

    $hid = intval($_GET['hallid']);

    if (isset($_POST['submit'])) {       

        $studentname = $_POST['studentname'];
        $matricnumber = $_POST['matricnumber'];
        $studentemail = $_POST['studentemail'];
        $mobilenumber = $_POST['mobilenumber'];
        $coursename = $_POST['coursename'];
        $section = $_POST['section'];
        $examdate = $_POST['examdate'];
        $starttime = $_POST['starttime']; 
        $endtime = $_POST['endtime'];
        $hallname = $_POST['hallname'];
        $levelnumber = $_POST['levelnumber'];
        $wing = $_POST['wing'];
        $region = $_POST['region'];
        $seats = $_POST['seats'];     
        
        foreach ($_POST['Student_id'] as $count => $Student_id) {
            $sats = $seats[$count];
            $student= $studentname[$count];
            $matricnum=$matricnumber[$count];
            $email=$studentemail[$count];
            $mobile=$mobilenumber[$count];

     $sql = "INSERT INTO  studentinfo(StudentName,MatricNumber,StudentEmail,MobileNumber,CourseName,Section,ExamDate,StartTime,EndTime,HallName,	LevelNumber,Wing, Region,SeatingNumber) VALUES(:student,:matricnum,:email,:mobile,:coursename,:section,:examdate,:starttime,:endtime,:hallname,:levelnumber,:wing,:region,:sats) ";
        $query = $dbh->prepare($sql);
        $query->bindParam(':student', $student, PDO::PARAM_STR);    
        $query->bindParam(':matricnum', $matricnum, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR); 
        $query->bindParam(':mobile', $mobile, PDO::PARAM_STR); 
        $query->bindParam(':coursename', $coursename, PDO::PARAM_STR);                $query->bindParam(':section', $section, PDO::PARAM_STR);
        $query->bindParam(':examdate', $examdate, PDO::PARAM_STR);
        $query->bindParam(':starttime', $starttime, PDO::PARAM_STR);
        $query->bindParam(':endtime', $endtime, PDO::PARAM_STR);
        $query->bindParam(':hallname', $hallname, PDO::PARAM_STR);
        $query->bindParam(':levelnumber', $levelnumber, PDO::PARAM_STR);
        $query->bindParam(':wing', $wing, PDO::PARAM_STR);
        $query->bindParam(':region', $region, PDO::PARAM_STR);
        $query->bindParam(':sats', $sats, PDO::PARAM_STR);
                                
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId) {
                $msg = "Student info Uploaded successfully";
            } 
             else{
                $error = " Something went wrong. Please try again";
                }
            }
        }
        
    ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SMS Admin|  Upload Student Info  </title>

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
                                    <h2 class="title">Student Info</h2>

                                </div>

                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Assign Seating Number</li>
                                        <li class="active">Student Info</li>
                                    </ul>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div> <br>
                        <div class="container-fluid">

                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5><b>Upload Student info</b></h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
<?php if ($msg) {?>
   <div class="alert alert-success left-icon-alert" role="alert">
<strong>Well done! </strong><?php echo htmlentities($msg); ?>
   </div><?php } else if ($error) {?>
   <div class="alert alert-danger left-icon-alert" role="alert">
<strong>Oh snap! </strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php }?>
                                                <form class="form-horizontal" method="post">

<?php
   $ret = "SELECT examhall.HallName,examhall.LevelNumber,examhall.Wing,examhall.Region,exampaper.CourseName,exampaper.CourseCode,exampaper.Section,exampaper.ExamDate,exampaper.StartTime,exampaper.EndTime from seatnumber
   join examhall on seatnumber.HallId=seatnumber.HallId join unistudents on unistudents.Student_id=seatnumber.StudentId join exampaper on exampaper.Paper_id=examhall.PaperId
   where examhall.HallId=:hid limit 1";

    $query1 = $dbh->prepare($ret);
    $query1->bindParam(':hid', $hid, PDO::PARAM_STR);
    $query1->execute();
    $result = $query1->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
    if ($query1->rowCount() > 0) {
        foreach ($result as $row) {?>

    <!--=============The Name of the Course is called from exampaper======-->                   
    <div class="form-group">
            <label for="default" class="col-sm-2 control-label">Course Name</label>
    <div class="col-sm-10">
<b>        
<input type="text" name="coursename" value="<?php echo htmlentities($row->CourseName);?> (<?php echo htmlentities($row->CourseCode) ?>)" class="form-control" id="default" required="required" readonly>
</b>
      <!--============Hidden inputs for exampaper table===============-->
<input type="hidden" name="section" value="<?php echo htmlentities($row->Section); ?>" >
<input type="hidden" name="examdate" value="<?php echo htmlentities($row->ExamDate); ?>" >
<input type="hidden" name="starttime" value="<?php echo htmlentities($row->StartTime); ?>" >
<input type="hidden" name="endtime" value="<?php echo htmlentities($row->EndTime); ?>" >

<?php echo htmlentities($row->StartTime) ?> - <?php echo htmlentities($row->EndTime) ?>
                                                        </div>
                                                    </div>

     <!--=============The Name of the Hall is called from examhall===============-->   
<div class="form-group">
<label for="default" class="col-sm-2 control-label">Hall Name</label>

<div class="col-sm-10">
 <b>   
<input type="text" name="hallname" readonly value="<?php echo htmlentities($row->HallName); ?>"class="form-control" id="success"> </b>

      <!--============Hidden inputs for examhall table===============-->
<input type="hidden" name="levelnumber" value="<?php echo htmlentities($row->LevelNumber); ?>" >
<input type="hidden" name="wing" value="<?php echo htmlentities($row->Wing); ?>" >
<input type="hidden" name="region" value="<?php echo htmlentities($row->Region); ?>" >
<?php echo htmlentities($row->Region);?>

</div>
</div>
<?php }}?>


<?php

    $sql = "SELECT examhall.HallName,examhall.HallId,exampaper.CourseName,exampaper.CourseCode,unistudents.StudentName,unistudents.MatricNumber,unistudents.StudentEmail,unistudents.MobileNumber,seatnumber.SeatingNumber,seatnumber.Seat_id as seatid from seatnumber join examhall on examhall.HallId=seatnumber.HallId join unistudents on unistudents.Student_id=seatnumber.StudentId join exampaper on exampaper.Paper_id=examhall.PaperId where examhall.HallId=:hid ";

    $query = $dbh->prepare($sql);
    $query->bindParam(':hid', $hid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1; 
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {?>

 <!--=============The Name of the Student is called from unistudents========-->   
<div class="form-group">
<label for="default" class="col-sm-2 control-label "><?php echo htmlentities($result->StudentName) ?></label>

               <!--============Hidden inputs for examhall table===============-->
<div class="col-sm-10">

<input type="hidden" name="Student_id[]" value="<?php echo htmlentities($result->seatid) ?>">    

<input type="hidden" name="studentname[]" value="<?php echo htmlentities($result->StudentName); ?>" >
<input type="hidden" name="matricnumber[]" value="<?php echo htmlentities($result->MatricNumber); ?>" >
<input type="hidden" name="studentemail[]" value="<?php echo htmlentities($result->StudentEmail); ?>" >
<input type="hidden" name="mobilenumber[]" value="<?php echo htmlentities($result->MobileNumber); ?>" >
<input  type="text" name="seats[]" class="form-control" id="seats" value="<?php echo htmlentities($result->SeatingNumber) ?>" maxlength="5" required="required" autocomplete="off">
</div>
      </div>

<?php }}?>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
     <!--================ Back Button=================-->
         <a href="manage-seats.php" class="btn btn-danger btn-labeled pull-left"><font face="Trebuchet MS" ><b>Back</font><span class="btn-label btn-label-right"><i class="fa fa-close"></i></span></a>
              <!--================ Sumbit Button=================-->
         <button type="submit" name="submit" class="btn btn-success btn-labeled pull-left">Upload<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
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
