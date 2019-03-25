<?php
session_start();
error_reporting(0);
include 'includes/config.php';
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
       $hid = intval($_GET['hallid']);

    if (isset($_POST['update'])) {
        $hallname = $_POST['hallname'];
        $hallcapacity = $_POST['hallcapacity'];
        $levelnumber = $_POST['levelnumber'];
        $wing = $_POST['wing'];
        $region = $_POST['region'];
        $paperid = $_POST['coursename'];
       

        $sql = "update  examhall set HallName=:hallname,HallCapacity=:hallcapacity,LevelNumber=:levelnumber,Wing=:wing,Region=:region where HallId=:hid ";

        $query = $dbh->prepare($sql);
        $query->bindParam(':hallname', $hallname, PDO::PARAM_STR);
        $query->bindParam(':hallcapacity', $hallcapacity, PDO::PARAM_STR);
        $query->bindParam(':levelnumber', $levelnumber, PDO::PARAM_STR);
        $query->bindParam(':wing', $wing, PDO::PARAM_STR);
        $query->bindParam(':region', $region, PDO::PARAM_STR);
        $query->bindParam(':hid', $hid, PDO::PARAM_STR);
        $query->execute();
        $msg = "Data has been updated successfully";
    }
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

        <title>OEPS Admin Update Hall</title>

        <link rel="stylesheet" href="css/bootstrap.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" > <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
            <?php include 'includes/topbar.php';?>
          <!-----End Top bar>
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
                                    <h2 class="title">Update Exam Hall</h2>
                                </div>

                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
            							<li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Assign Exam Halls</li>
            							<li class="active">Manage Halls</li>
            							<li class="active">Update Hall</li>
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
                                                    <h5><b>Update Hall info</b></h5>
                                                </div>
                                            </div>
<?php if ($msg) {?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php } else if ($error) {?>
    <div class="alert alert-danger left-icon-alert" role="alert">
    <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
    </div> <?php }?>

<!--======================= Update the form ==================================-->
                    <form method="post">
<!--=====================Update the database of Exam Hall===============================-->
<?php
    
    $sql = "SELECT examhall.HallName,examhall.HallCapacity,examhall.LevelNumber,examhall.Wing,examhall.Region,exampaper.CourseName,exampaper.CourseCode from examhall join exampaper on exampaper.Paper_id=examhall.PaperId where examhall.HallId=:hid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':hid', $hid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {?>
                                                    <!--========Update Hall Name input======== -->

                                                    <div class="form-group has-success">
                                                        <label for="success" class="control-label">Hall Name</label>
                                                		<div class="">
                                                			<input type="text" name="hallname" value="<?php echo htmlentities($result->HallName); ?>" required="required" class="form-control" id="success">
                                                            <span class="help-block">Eg- Hall 3, Hall 4,    Auditorium 2 etc</span>
                                                		</div>
                                                	</div>

                                                    <!--====== Update Hall Capacity input======= -->

                                                       <div class="form-group has-success">
                                                        <label for="success" class="control-label">Hall Capacity</label>
                                                        <div class="">
                                                            <input type="number" name="hallcapacity" value="<?php echo htmlentities($result->HallCapacity); ?>" required="required" class="form-control" id="success">
                                                            <span class="help-block">Eg- 10, 100 etc</span>
                                                        </div>
                                                    </div>

                                         <!--========== Update Level number input=========== -->

                                                     <div class="form-group has-success">
                                                        <label for="success" class="control-label">Level Number</label>
                                                        <div class="">
                                                            <input type="text" name="levelnumber" value="<?php echo htmlentities($result->LevelNumber); ?>" class="form-control" required="required" id="success">
                                                            <span class="help-block">Eg- 1,2,4,5 etc</span>
                                                        </div>
                                                    </div>

                                        <!--============== Update Wing input===============-->

                                                    <div class="form-group has-success">
                                                       <label for="success" class="control-label">Wing</label>
                                                     <div class="">
                                                          <input type="text" name="wing" value="<?php echo htmlentities($result->Wing); ?>" class="form-control" required="required" id="success">
                                                             <span class="help-block">Eg- A or B etc</span>
                                                     </div>
                                                  </div>

                                            <!--============Update Region input============ -->

                                                    <div class="form-group has-success">
                                                        <label for="success" class="control-label">Region</label>
                                                        <div class="">
                                                            <input type="text" name="region" value="<?php echo htmlentities($result->Region); ?>" class="form-control" required="required" id="success">
                                                            <span class="help-block">Eg- Main Campus,Regional Campus etc</span>
                                                        </div>
                                                    </div>
                                                    <?php }}?>

     <!--=====================Update the Course Name of the Hall===============================-->
                                                    <div class="form-group has-success">
                                                       <label for="success" class="control-label">Course Name</label>
                                                      <div class="">
                                                            <input type="text" name="coursename" class="form-control" id="success" value="<?php echo htmlentities($result->CourseName) ?> / <?php echo htmlentities($result->CourseCode) ?>" readonly>
                                                        </div>
                                                    </div>
                                                    

                                                    <!--===========Update input=============== -->

                                                       <div class="form-group has-success">
                                                        <div class="">
                                                    <!--====== Back Button=============-->
                                                       <a href="manage-halls.php" class="btn btn-danger btn-labeled pull-left"><font face="Trebuchet MS" ><b>Back</font><span class="btn-label btn-label-right"><i class="fa fa-close"></i></span></a>

                                                     <!--========== Sumbit Button==========-->
                                                       <button type="submit" name="update" class="btn btn-success btn-labeled">Update<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>

<!-- Danger button with label maybe need for later
<button type="button" class="btn btn-labeled btn-danger"><span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>Danger</button>-->


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


                    <!-- /.right-sidebar -->

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



        <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
    </body>
</html>
<?php }?>
