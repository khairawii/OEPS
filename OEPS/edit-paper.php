<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{
if(isset($_POST['Update']))
{
$faculty = $_POST['faculty'];
$programme = $_POST['programme'];  
$pid=intval($_GET['paperid']);
$coursename = $_POST['coursename'];
$coursecode = $_POST['coursecode'];
$section = $_POST['section'];
$examdate = $_POST['examdate'];
$starttime = $_POST['starttime'];
$endtime = $_POST['endtime'];


$sql="update  exampaper set Faculty=:faculty,Programme=:programme,CourseName=:coursename,CourseCode=:coursecode,Section=:section,ExamDate=:examdate,StartTime=:starttime,EndTime=:endtime where Paper_id=:pid";

$query = $dbh->prepare($sql);
$query->bindParam(':faculty', $faculty, PDO::PARAM_STR);
$query->bindParam(':programme', $programme, PDO::PARAM_STR);
$query->bindParam(':coursename',$coursename,PDO::PARAM_STR);
$query->bindParam(':coursecode',$coursecode,PDO::PARAM_STR);
$query->bindParam(':section', $section, PDO::PARAM_STR);
$query->bindParam(':examdate', $examdate, PDO::PARAM_STR);
$query->bindParam(':starttime', $starttime, PDO::PARAM_STR);
$query->bindParam(':endtime', $endtime, PDO::PARAM_STR);
$query->bindParam(':pid',$pid,PDO::PARAM_STR);
$query->execute();
$msg="Course Info updated successfully";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SMS Admin Update Paper </title>

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
  <?php include('includes/topbar.php');?> 
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">

                    <!-- ========== LEFT SIDEBAR ========== -->
                   <?php include('includes/leftbar.php');?>  
                    <!-- /.left-sidebar -->

                    <div class="main-page">

                     <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Update Paper</h2>
                                
                                </div>
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Assign Exam Papers</li>
            							<li class="active"> Manage Exam Paper</li>
                                        <li class="active"> Update Paper</li>
                                    </ul>
                                </div>
                             
                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="container-fluid">
                           
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Update Paper</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">

<!-- The message you recieve when the info is updated successfully-->
<?php if($msg){?>
 <div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done! </strong><?php echo htmlentities($msg); ?>
</div><?php } 

// The message you recieve when the info is not updated successfully
else if($error){?>
 <div class="alert alert-danger left-icon-alert" role="alert">
 <strong>Oh snap! </strong> <?php echo htmlentities($error); ?>                                        </div> <?php } ?>

  <!--======================= Update the form ==================================-->
          <form class="form-horizontal" method="post">

<!--=====================Update the database of Exam Paper===============================-->

 <?php

$pid = intval($_GET['paperid']);
$sql = "SELECT * from exampaper where Paper_id=:pid";
$query = $dbh->prepare($sql);
$query->bindParam(':pid',$pid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>      

<!--=====================Update the Faculty of Exam Paper===============================-->
<div class="form-group">

         <label for="default" class="col-sm-2 control-label">Faculty</label>
         <div class="col-sm-10">
         <input type="text" name="faculty" value="<?php echo htmlentities($result->Faculty);?>" class="form-control" required="required" id="success" readonly>     
</div>
     </div>

<!--=====================Update the Programme of Exam Paper===============================-->
<div class="form-group">
         <label for="default" class="col-sm-2 control-label">Programme</label>
         <div class="col-sm-10">
         <input type="text" name="programme" value="<?php echo htmlentities($result->Programme);?>" class="form-control" required="required" id="success" readonly>     
</div>
     </div>     
                                       
<!--=====================Update the Course Name of Exam Paper===============================-->  
<div class="form-group">
     <label for="default" class="col-sm-2 control-label">Course Name</label>
<div class="col-sm-10">
     <input type="text" name="coursename" value="<?php echo htmlentities($result->CourseName);?>" class="form-control" id="default" placeholder="Enter only letters" required="required" readonly>
</div>
</div>

<!--=====================Update the Course Code of Exam Paper===============================-->  
<div class="form-group">
     <label for="default" class="col-sm-2 control-label">Course Code</label>
<div class="col-sm-10">
     <input type="text" name="coursecode" class="form-control" value="<?php echo htmlentities($result->CourseCode);?>"  id="default" placeholder="Enter the Course Code of the exam paper" required="required">
</div>
</div>

<!--=====================Update the Section of the Course===============================--> 
<div class="form-group">
     <label for="default" class="col-sm-2 control-label">Section</label>
<div class="col-sm-10">
     <input type="text" name="section" class="form-control" value="<?php echo htmlentities($result->Section);?>"  id="default" placeholder="Enter the Section of the course" required="required">
</div>
</div>

<!--=====================Update the Exam date of the Course===============================-->
<div class="form-group">
     <label for="default" class="col-sm-2 control-label">Exam Date</label>
<div class="col-sm-10">
     <input type="date" name="examdate" class="form-control" value="<?php echo htmlentities($result->ExamDate);?>"  id="default" required="required">
</div>
</div>  

<!--=====================Update the Start time of the Course===============================-->             
<div class="form-group">
     <label for="default" class="col-sm-2 control-label">Start Time</label>
<div class="col-sm-10">
     <input type="time" name="starttime" class="form-control" value="<?php echo htmlentities($result->StartTime);?>"  id="default" required="required">
</div>
</div>      

 <!--=====================Update the End time of the Course===============================-->
<div class="form-group">
     <label for="default" class="col-sm-2 control-label">End Time</label>
<div class="col-sm-10">
     <input type="time" name="endtime" class="form-control" value="<?php echo htmlentities($result->EndTime);?>"  id="default" required="required">
</div>
</div>

 <?php }} ?>

<!--=====================Submit the Info of Paper===============================-->

 <div class="form-group">
     <div class="col-sm-offset-2 col-sm-10">
                  <!--================ Back Button=================-->
         <a href="manage-paper.php" class="btn btn-danger btn-labeled pull-left"><font face="Trebuchet MS" ><b>Back</font><span class="btn-label btn-label-right"><i class="fa fa-close"></i></span></a> 

                   <!--================ Sumbit Button=================-->
         <button type="submit" name="Update" class="btn btn-primary btn-labeled pull-left">Update<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
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
<?PHP } ?>
