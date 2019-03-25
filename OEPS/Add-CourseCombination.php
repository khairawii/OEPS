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
        $paperid = $_POST['coursename'];
        $status = 1;

        // Query for validation of Student name and Course name
        $ret="SELECT * FROM combinecourse where (StudentId=:sname && PaperId=:cname)";
        $queryt = $dbh -> prepare($ret);
        $queryt->bindParam(':sname', $studentname, PDO::PARAM_STR);
        $queryt->bindParam(':cname',$paperid,PDO::PARAM_STR);
        $queryt -> execute();
        $results = $queryt -> fetchAll(PDO::FETCH_OBJ);

        // Query for Insertion
   if($queryt -> rowCount() == 0)
   {       
        $sql = "INSERT INTO  combinecourse(StudentId,PaperId,status) VALUES(:sname,:cname,:status)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':sname', $studentname, PDO::PARAM_STR);
        $query->bindParam(':cname', $paperid, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if ($lastInsertId) {
            $msg = "Combination added successfully";
        } else {
            $error = "Something went wrong. Please try again";
        }
    }
    else {
$error=" Student Name and Course Name already exists. Please use new Student Name or Course Name.";
}
}
?>
    
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SMS Admin Course Combination< </title>

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

<!--Java script for check Course name availability-->
<script>
function checkCoursenameAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check-availability.php",
data:'coursename='+$("#coursename").val(),
type: "POST",
success:function(data){
$("#coursename-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){
}
});
}
</script>

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
                                    <h2 class="title">Add Combination</h2>

                                </div>

                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Students</li>
                                        <li class="active">Add Course Combination</li>
                                    </ul>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="container-fluid"><br>

                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5><b>Add Course Combination</b></h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">

<?php if ($msg) {?>
    <div class="alert alert-success left-icon-alert" role="alert">
     <strong>Well done! </strong><?php echo htmlentities($msg); ?>
 </div><?php } else if ($error) {?>
     <div class="alert alert-danger left-icon-alert" role="alert">
     <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                    </div>
                                        <?php }?>

     <!--======================= Select the Student Name ==================================-->
     
            <form class="form-horizontal" method="post">
                <div class="form-group has-success">
                     <label for="default" class="col-sm-2 control-label">Student Name</label>
                           <div class="col-sm-10">
    
 <select name="fullname" class="form-control" id="fullname" onBlur="checkStudentnameAvailability()" required="required">
     <option value="" disabled  selected hidden>Select Student Name</option>
<?php $sql = "SELECT * from unistudents";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {?>
<option value="<?php echo htmlentities($result->Student_id); ?>"><?php echo htmlentities($result->StudentName); ?></option>
<?php }}?>
 </select> <span id="studentname-availability-status" style="font-size:12px;"></span> 
                                                        </div>
                                                    </div>

    <!--======================= Select the Course Name ==================================-->

<div class="form-group has-success">
         <label for="default" class="col-sm-2 control-label">Course Name</label>
             <div class="col-sm-10">
<select name="coursename" class="form-control" id="coursename" onBlur="checkCoursenameAvailability()" required="required">
       <option value="" disabled  selected hidden>Select Course Name</option>
<?php $sql = "SELECT * from exampaper";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {?>
<option value="<?php echo htmlentities($result->Paper_id); ?>"><?php echo htmlentities($result->CourseName); ?> &nbsp; / <?php echo htmlentities($result->CourseCode); ?></option>
<?php }}?>
 </select> <span id="coursename-availability-status" style="font-size:12px;"></span>
                                                        </div>
                                                    </div>
<!--======================= Create the Add Button ==================================-->
  <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
      
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