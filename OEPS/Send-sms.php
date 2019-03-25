<?php
session_start();
error_reporting(0);
include 'includes/config.php';
if (strlen($_SESSION['alogin']) == 0) {
    header("Location: index.php");

} else {
    $sid = intval($_GET['id']);

    if (isset($_POST['sms'])) {
        // Get the id

        $sql = "SELECT * from studentinfo where id=:sid ";

        $query = $dbh->prepare($sql);
        $query->bindParam(':sid', $sid, PDO::PARAM_STR);
        // Query Execution
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
// For serial number initialization
        $cnt = 1;
        if ($query->rowCount() > 0) {
//In case that the query returned at least one record, we can echo the records within a foreach loop:
            foreach ($results as $result) {
                $no = $result->MobileNumber;
                $matricno = $result->MatricNumber;
                $name = $result->StudentName;
                $seat = $result->SeatingNumber;
                $course = $result->CourseName;
                $section = $result->Section;
                $start = $result->StartTime;
                $end = $result->EndTime;
                $date = $result->ExamDate;
                $hall = $result->HallName;
                $level = $result->LevelNumber;
                $wing = $result->Wing;
                $region = $result->Region;

    include ("src/NexmoMessage.php");
    /**
     * To send a text message.
     * 
     *  */
     // Step 1: Declare new NexmoMessage.
        $nexmo_sms = new NexmoMessage('9d5b0b91', 'IipL2UJLmKVa0n4o');
        $message = "Greetings $name!  Your seating number for the following Course is:
            
        COURSE TITLE : $course

        SECTION : $section

        EXAM DATE : $date

        EXAM TIME : $start TO $end

        VENUE : $hall, Level $level, Wing $wing,

        UNITAR $region

        SEATING NUMBER : $seat 

        Sincerely Yours,
        OEPS";
        
        $from = "OEPS";
               // Step 2: Use sendText( $to, $from, $message ) method to send a message.
                $info = $nexmo_sms->sendText($no, $from, $message);
                // Step 3: Display an overview of the message
                //echo $nexmo_sms->displayOverview($info);
                // Done!
                
                // Mesage after sending SMS
               
                 echo "<script>alert(' SMS notification sent successfully to $name about his seating number!');</script>";
                 
                 // Code for redirection
                 echo "<script>window.location.href='Notify-Students.php'</script>";
                }
            }
        }
     ?>             
                
    <!doctype html>
    <html lang="en">
        <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Admin SMS Student </title>

        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/select2/select2.min.css" >
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
        </head>
        <body>
              <!-- ========== TOP NAVBAR ========== -->
   <?php include 'includes/topbar.php';?>
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">
<?php include 'includes/leftbar.php';?>

                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">SMS Student</h2>
                            </div>

                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
            							<li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a>
                                        <li> Assign Seating Number
            							<li class="active">Notify Students
                                        <li class="active">SMS Student
            						</ul>
                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.container-fluid -->

                        <section class="section">
                            <div class="container-fluid">



                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5><b>Notify Students</b> </h5>
                                                </div>
                                                </div>
     <div class="panel-body p-20">
 <h5><font face="Comic Sans MS" color="purple">Click 'Notify Student' below to send SMS Notification to the selected Student.</font></h5>

           <form method="post" class="form-horizontal" onSubmit="return valid();">
 <?php
$sql = "SELECT * from studentinfo where id=:sid";

    $query = $dbh->prepare($sql);
    $query->bindParam(':sid', $sid, PDO::PARAM_STR);
    // Query Execution
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
// For serial number initialization
    $cnt = 1;
    if ($query->rowCount() > 0) {
//In case that the query returned at least one record, we can echo the records within a foreach loop:
        foreach ($results as $result) {
            ?>
        <!--=====================Full Name of Student===============================-->
<div class="form-group">
<label for="default" class="col-sm-2 control-label">Full Name</label>
<div class="col-sm-10">
<input type="text" name="fullname" class="form-control" id="fullname" value="<?php echo htmlentities($result->StudentName) ?>" required="required" autocomplete="off" readonly>
</div>
</div>
<!--===================== Matric Number of Student===============================-->
<div class="form-group">
<label for="default" class="col-sm-2 control-label">Matric Number</label>
<div class="col-sm-10">
<input type="text" name="matricno" class="form-control" id="matricno" value="<?php echo htmlentities($result->MatricNumber) ?>" maxlength="15" required="required" autocomplete="off" readonly>
</div>
</div>
<!--=====================SMS no of Student===============================-->
<div class="form-group">
<label for="default" class="col-sm-2 control-label">Mobile Number</label>
<div class="col-sm-10">
<input type="tel" name="mobilenum" class="form-control" id="mobilenum" value="<?php echo htmlentities($result->MobileNumber) ?>" required="required" autocomplete="off" readonly>
<p class="help-block">Remove any characters/spaces/negative numbers.  Enter numbers only, e.g. 00601113328804</p> 
</div>
</div>
<!--=====================SMS no of Student===============================-->
<div class="form-group">
<label for="default" class="col-sm-2 control-label">Seating Number</label>
<div class="col-sm-10">
<input type="text" name="seatno" class="form-control" id="sms" value="<?php echo htmlentities($result->SeatingNumber) ?>" required="required" autocomplete="off" readonly>
</div>
</div>

     <?php
}
    }
    ?>
    <div class="form-group">
     <div class="col-sm-offset-2 col-sm-10">
    <!--================ Back Button=================-->
      <a href="Notify-Students.php" class="btn btn-danger"><font face="Trebuchet MS" style="font-size:14px;"><b>Back</font></a>

     <!--================ Sumbit Button=================-->       
      <button class="btn btn-primary text-yellow" name="sms" type="submit" ><font face="Trebuchet MS" style="font-size:14px;"><b>SMS Student</font></button>
        
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
            <!-- Loading Scripts -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>
        <script src="js/prism/prism.js"></script>
        <script src="js/select2/select2.min.js"></script>
        <script src="js/main.js"></script>.
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
<?php }