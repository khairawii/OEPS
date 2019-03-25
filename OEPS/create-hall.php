<?php
session_start();
error_reporting(0);
include 'includes/config.php';
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    //Getting Post Values
    if (isset($_POST['submit'])) {
        $hallname = $_POST['hallname'];
        $hallcapacity = $_POST['hallcapacity'];
        $levelnumber = $_POST['levelnumber'];
        $wing = $_POST['wing'];
        $region = $_POST['region'];
        $paperid = $_POST['coursename'];
        $studentnumber=$_POST['snum']; 
        
        if($hallcapacity > $studentnumber){
        // Query for validation of hallname
        $ret="SELECT * FROM examhall where (HallName=:hname && PaperId=:cname)";
        $queryt = $dbh -> prepare($ret);
        $queryt->bindParam(':hname',$hallname,PDO::PARAM_STR);
        $queryt->bindParam(':cname', $paperid, PDO::PARAM_STR);
        $queryt -> execute();
        $results = $queryt -> fetchAll(PDO::FETCH_OBJ);
        if($queryt -> rowCount() == 0){
    
        // Query for Insertion
        $sql = "INSERT INTO  examhall(HallName,HallCapacity, LevelNumber,Wing, Region,PaperId,StudentNumber) VALUES(:hname,:hallcapacity, :levelnumber,:wing,:region,:cname,:snum)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':hname', $hallname, PDO::PARAM_STR);
        $query->bindParam(':hallcapacity', $hallcapacity, PDO::PARAM_STR);
        $query->bindParam(':levelnumber', $levelnumber, PDO::PARAM_STR);
        $query->bindParam(':wing', $wing, PDO::PARAM_STR);
        $query->bindParam(':region', $region, PDO::PARAM_STR);
        $query->bindParam(':cname', $paperid, PDO::PARAM_STR);
        $query->bindParam(':snum', $studentnumber, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if ($lastInsertId) {
            $msg = " Hall Created successfully";
        } 
        else{
             $error = " Something went wrong. Please try again";
        }

}
else
{
$error=" Hall Name and Course Name already exists. Please use new one.";
}
        }

     else {
        $error = "Capacity is lower than Student no. Please Change the Hall & try again";

        }
}
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SMS Admin Create Exam Hall</title>

        <link rel="stylesheet" href="css/bootstrap.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" > 
        <link rel="stylesheet" href="css/main.css" media="screen" >        
         <script src="js/modernizr/modernizr.min.js"></script>
       
         <style>
 .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
    </style>

<!--===========Java script for check Hall availability from examhall table=============-->
<script>
function checkHallAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check-availability.php",
data:'hallname='+$("#hallname").val(),
type: "POST",
success:function(data){
$("#hallname-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){
}
});
}
</script>
<!--==========Java script for check Course name availability from examhall table==========-->
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
</script><script type="text/javascript">
function val(){
if(frm.hallcapacity.value>="")
{
	alert("Please enter the phone number");
	frm.phone.focus(); 
	return false;
}
if(isNaN(frm.phone.value))
{
	alert("Invalid phone number");
	frm.phone.focus(); 
	return false;
}
if((frm.phone.value).length < 10)
{
	alert("Phone number should be minimum 10 digits");
	frm.phone.focus(); 
	return false;
}

return true;
}
</script>

    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
            <?php include 'includes/topbar.php';?>
          <!--End Top bar-->
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
                                    <h2 class="title">Create Hall</h2>
                                </div>

                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
            							<li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
            							<li><a href="#">Assign Exam Halls</a></li>
            							<li class="active">Create Hall</li>
            						</ul>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.container-fluid -->

                        <section class="section">
                            <div class="container-fluid">

                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5><b>Create Hall</b></h5>
                                                </div>
                                            </div>
<?php if ($msg) {?>
  <div class="alert alert-success left-icon-alert" role="alert">
  <strong>Well done!</strong><?php echo htmlentities($msg); ?>
</div><?php } else if ($error) {?>
 <div class="alert alert-danger left-icon-alert" role="alert">
 <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
</div>  <?php }?>

                                            <div class="panel-body">

                                             <!--========= Hall Name input============== -->

                                                <form method="post">
                                                    <div class="form-group has-success">
                                                        <label for="success" class="control-label">Hall Name</label>
                                                		<div class="">
                                                            <input type="text" name="hallname" class="form-control" onBlur="checkHallAvailability()" placeholder="Enter both letters and numbers" required="required"  id="hallname">
                                                            <span id="hallname-availability-status" style="font-size:12px;"></span> 
                                                          
                                                		</div>
                                                	</div>

                                                    <!--====== Hall Capacity input====== -->

                                                     <div class="form-group has-success">
                                                        <label for="success" class="control-label">Hall Capacity</label>
                                                        <div class="">
                                                            <input type="number" name="hallcapacity" min="1" max="200" placeholder="Enter only Numbers" required="required" class="form-control" id="success">
                                                            <span class="help-block">Eg- 10, 100 etc</span>
                                                        </div>
                                                    </div>

                                                     <!--===== Level number input==== -->

                                                       <div class="form-group has-success">
                                                        <label for="success" class="control-label">Level Number</label>
                                                        <div class="">
                                                            <input type="number" name="levelnumber" min="1" max="10" placeholder="Enter only Numbers" required="required" class="form-control" id="success">
                                                            <span class="help-block">Eg- 1,2,4,5 etc</span>
                                                        </div>
                                                    </div>

                                                     <!--===== Wing input=======-->
                                                    <div class="form-group has-success">
                                                    <label for="success" class="control-label">Wing</label>
                                                     <div class="">
                                                        <select name="wing" class="form-control" id="success" required="required">
                                                              <option value="" disabled  selected hidden>  Select Wing A or B</option>
                                                              <option value="A">A</option>
                                                              <option value="B">B</option>
                                                         </select>

                                                   <!--  <span class="help-block">Eg- A or B etc</span>-->
                                                     </div>
                                                 </div>

                                                        <!--========= Region input========= -->

                                                     <div class="form-group has-success">
                                                        <label for="success" class="control-label">Region</label>
                                                        <div class="">
                                                            <input type="text" name="region" class="form-control" placeholder="Enter only letters" required="required" value="Main Campus" readonly id="success">
                                                            <span class="help-block">Eg- Main Campus,Regional Campus etc</span>
                                                        </div>
                                                    </div>
     <!--=====================Add the Course Name for the Hall===============================-->

<div class="form-group has-success">
     <label for="success" class="control-label">Course Name</label>
     <div class="">
        <select name="coursename" class="form-control" id="coursename" onBlur="checkCoursenameAvailability()" onchange= "cname" required="required">
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

           <!--================ Student number for course ================= -->

 <?php
$sql1 = "SELECT  distinct StudentId from  combinecourse ";
$query2 = $dbh->prepare($sql1);
$query2->execute();
$results2 = $query2->fetchAll(PDO::FETCH_OBJ);
$totalstudent = $query2->rowCount();
?>

                                              <div class="form-group has-success">
                                                 <label for="success" class="control-label">Student Number</label>
                                                 <div class="">
                                                <input type="text" name="snum" class="form-control" placeholder="Enter only number" required="required" value=<?php echo htmlentities($totalstudent);?>  readonly id="success">
                                                <span class="help-block">Eg- Main Campus,Regional Campus etc</span>
                                                        </div>
                                                    </div>


                                                       <!--====Update button with label======-->

                                                       <div class="form-group has-success">
                                                       <div class="">
                                                           <button type="submit" name="submit" class="btn btn-success  btn-labeled" onclick="return val();">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                                                    </div>

                                                </form>


                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-8 col-md-offset-2 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.container-fluid -->
                        </section>
                        <!-- /.section -->

                    </div>
                    <!-- /.main-page -->

                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /.main-wrapper -->

        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/jquery-ui/jquery-ui.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
    </body>
</html>
<?php }?>
