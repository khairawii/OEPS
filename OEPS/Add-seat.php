<?php
session_start();
error_reporting(0);
include 'includes/config.php';
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    if (isset($_POST['submit'])) {
        $seats = array();
        $paperid = $_POST['coursename'];
        $hallid = $_POST['hallid'];
        $seat = $_POST['seats'];

        $stmt = $dbh->prepare("SELECT unistudents.StudentName,unistudents.Student_id FROM combinecourse join  unistudents on  unistudents.Student_id=combinecourse.StudentId WHERE combinecourse.PaperId=:pid order by unistudents.StudentName");
        $stmt->execute(array(':pid' => $paperid));
        $sid1 = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            array_push($sid1, $row['Student_id']);
        }

        for ($i = 0; $i < count($seat); $i++) {
            $sea = $seat[$i];
            $sid = $sid1[$i];
            
            $sql = "INSERT INTO  seatnumber(PaperId,HallId,StudentId,SeatingNumber) VALUES(:coursename,:hallid,:sid,:seats)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':coursename', $paperid, PDO::PARAM_STR);
            $query->bindParam(':hallid', $hallid, PDO::PARAM_STR);            
            $query->bindParam(':sid', $sid, PDO::PARAM_STR);
            $query->bindParam(':seats', $sea, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId) {
                $msg = " Seating Number info added successfully";
            } else {
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

        <title>SMS Admin| Add Seating Number </title>

        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/select2/select2.min.css" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>

        <script>

function getHall(val) {
    $.ajax({
    type: "POST",
    url: "get_Hall.php",
    data:'courseid='+val,
    success: function(data){
        $("#hallid").html(data);

    }
    });
$.ajax({
        type: "POST",
        url: "get_Hall.php",
        data:'courseid1='+val,
        success: function(data){
            $("#student").html(data); 

        }
        });
}
    </script>
<script>

function getseats(val,clid)
{

var clid=$(".clid").val();
var val=$(".stid").val();;
var abh=clid+'$'+val;
//alert(abh);
    $.ajax({
        type: "POST",
        url: "get_Hall.php",
        data:'studpaper='+abh,
        success: function(data){
            $("#haid").html(data); 

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
                                    <h2 class="title">Declare Seating Number</h2>

                                </div>

                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Assign Seating Number</li>
                                        <li class="active">Add Seats</li>                
                                    </ul>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="container-fluid">

                        <div class="row"> <br>
                                    <div class="col-md-12">
                                        <div class="panel">

                                            <div class="panel-body">
<?php if ($msg) {?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php } else if ($error) {?>
<div class="alert alert-danger left-icon-alert" role="alert">
  <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
</div> <?php }?>

   <!--======================= Create the Form ==================================-->

                       <form class="form-horizontal" method="post">

 <!--======================= Select the Course Name ==================================-->
 <div class="form-group has-success">
<label for="default" class="col-sm-2 control-label">Course Name</label>
    <div class="col-sm-10">
    <select name="coursename" class="form-control clid" id="courseid" onChange="getHall(this.value);" required="required">
<option value="" disabled  selected hidden>Select Course Name</option>
<?php $sql = "SELECT * from exampaper";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {?>
<option value="<?php echo htmlentities($result->Paper_id); ?>"><?php echo htmlentities($result->CourseName); ?> &nbsp; / <?php echo htmlentities($result->CourseCode); ?></option>
<?php }}?>        
 </select>
                                                        </div>
                                                    </div>

        <!--======================= Select the Hall Name ==================================-->                      
<div class="form-group has-success">
        <label for="date" class="col-sm-2 control-label ">Hall Name</label>
           <div class="col-sm-10">
 <select name="hallid" class="form-control stid" id="hallid" required="required" onChange="getseats(this.value);">
   </select>
     </div>
        </div>
         <div class="form-group">

           <div class="col-sm-10">
             <div  id="haid">
               </div>
                 </div>
                   </div>

     <!--======================= List of students ==================================-->  

<div class="form-group has-success">
        <label for="date" class="col-sm-2 control-label">Students</label>
          <div class="col-sm-10">
             <div  id="student">

               </div>
                 </div>
                  </div>

    <!--======================= Create the Submit button ==================================--> 

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
         <!--================ Back Button=================-->
      <a href="dashboard.php" class="btn btn-danger btn-labeled pull-left"><font face="Trebuchet MS" ><b>Back</font><span class="btn-label btn-label-right"><i class="fa fa-close"></i></span></a>
       
            <!--================ Sumbit Button=================-->
      <button type="submit" name="submit" id="submit" class="btn btn-primary btn-labeled pull-left">Declare Seats<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>

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
