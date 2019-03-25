<?php
session_start();
error_reporting(0);
include 'includes/config.php';
if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
} else {
    //Getting Post Values
    if (isset($_POST['submit'])) {
        $faculty = $_POST['faculty'];
        $programme = $_POST['programme'];
        $coursename = $_POST['coursename'];
        $coursecode = $_POST['coursecode'];
        $section = $_POST['section'];
        $examdate = $_POST['examdate'];
        $starttime = $_POST['starttime'];
        $endtime = $_POST['endtime'];
      
        // Query for validation of Course Name
        $ret = "SELECT * FROM exampaper where CourseName=:cname";
        $queryt = $dbh->prepare($ret);
        $queryt->bindParam(':cname', $coursename, PDO::PARAM_STR);
        $queryt->execute();
        $results = $queryt->fetchAll(PDO::FETCH_OBJ);
        
        // Query for Insertion
        if ($queryt->rowCount() == 0) 
        {
            $sql = "INSERT INTO  exampaper(Faculty,Programme,CourseName,CourseCode,Section,ExamDate,StartTime,EndTime) VALUES(:faculty,:programme,:cname,:coursecode,:section,:examdate,:starttime,:endtime)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':faculty', $faculty, PDO::PARAM_STR);
            $query->bindParam(':programme', $programme, PDO::PARAM_STR);
            $query->bindParam(':cname', $coursename, PDO::PARAM_STR);
            $query->bindParam(':coursecode', $coursecode, PDO::PARAM_STR);
            $query->bindParam(':section', $section, PDO::PARAM_STR);
            $query->bindParam(':examdate', $examdate, PDO::PARAM_STR);
            $query->bindParam(':starttime', $starttime, PDO::PARAM_STR);
            $query->bindParam(':endtime', $endtime, PDO::PARAM_STR);
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId) {
                $msg = "Exam paper Created successfully ";
            } else {
                $error = "Something went wrong. Please try again ";
            }

        } else {
            $error = " Course name already exists. Please use new Course name.";
        }
    }?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SMS Admin Exam Paper Creation </title>

        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/select2/select2.min.css" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
        
       
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
                                    <h2 class="title">Exam Paper Creation</h2>

                                </div>

                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Assign Exam Papers</li>
                                        <li class="active">Create Exam Paper</li>
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
                                                    <h5><b>Create Paper</b></h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">

 <!-- The message you recieve when the info is updated successfully-->

<?php if ($msg) {?>
<div class="alert alert-success left-icon-alert" role="alert">
  <strong>Well done! </strong><?php echo htmlentities($msg); ?>
</div><?php }

// The message you recieve when the info is not updated successfully
    else if ($error) {?>
 <div class="alert alert-danger left-icon-alert" role="alert">
     <strong>Oh snap! </strong> <?php echo htmlentities($error); ?>
 </div> <?php }?>

   <!--======================= Create the form ==================================-->
      <form class="form-horizontal" method="post">

   <!--============The java script for faculty Dynamic List Elements======-->
<script type="text/javascript">
function Selectfaculty(f1,p1) {
    var f1 = document.getElementById(f1);
    var p1 = document.getElementById(p1);
    p1.innerHTML = "";
    if(f1.value == "Faculty of Business Technology and Accounting"){
        var optionArray = ["|Select Programme","Bachelor of Information Technology (Hons)|Bachelor of Information Technology (Hons)","Bachelor of Business Administration (Hons)|Bachelor of Business Administration (Hons)","Diploma in Accounting|Diploma in Accounting"];
    }else if(f1.value == "Faculty of Education and Humanities"){
        var optionArray = ["|Select Programme","Bachelor of Communication (Hons)|Bachelor of Communication (Hons)","Bachelor of Education (Hons)|Bachelor of Education (Hons)","Diploma in Children Performing Arts|Diploma in Children Performing Arts"];
        }
    for(var option in optionArray){
        var pair = optionArray[option].split("|");
        var newOption = document.createElement("option");
        newOption.value = pair[0];
        newOption.innerHTML = pair[1];
        p1.options.add(newOption);
    }
}
// Javascript for Programme Dynamic List Elements
function SelectProgramme(p1,c1) {
    var p1 = document.getElementById(p1);
    var c1 = document.getElementById(c1);
    c1.innerHTML = "";
    if(p1.value == "Bachelor of Information Technology (Hons)"){
        var optionArray = ["|Select Course Name","Issues in ICT|Issues in ICT","Discrete Mathematics|Discrete Mathematics","Databases|Databases","Operating Systems|Operating Systems","Knowledge Management|Knowledge Management","Object-Oriented Programming|Object-Oriented Programming","Requirements Engineering|Requirements Engineering"];

    }else if(p1.value == "Bachelor of Business Administration (Hons)"){
        var optionArray = ["|Select Course Name","Principles of Accounting|Principles of Accounting","Human Resource Management|Human Resource Management"];
        }
        else if(p1.value == "Diploma in Accounting"){
        var optionArray = ["|Select Course Name","Principles of Performing Arts|Principles of Performing Arts","Voice and Speech|Voice and Speech"];
        }
        else if(p1.value == "Bachelor of Communication (Hons)"){
        var optionArray = ["|Select Course Name","News Writing|News Writing","Online Journalism|Online Journalism"];
        }
        else if(p1.value == "Bachelor of Education (Hons)"){
        var optionArray = ["|Select Course Name","Counselling in Education|Counselling in Education","Statistics in Education|Statistics in Education"];
        }
        else if(p1.value == "Diploma in Children Performing Arts"){
        var optionArray = ["|Select Course Name","Critical Thinking|Critical Thinking","Voice and Speech|Voice and Speech"];
        }
    for(var option in optionArray){
        var pair = optionArray[option].split("|");
        var newOption = document.createElement("option");
        newOption.value = pair[0];
        newOption.innerHTML = pair[1];
        c1.options.add(newOption);

    }
}
// Javascript for Course Name List Elements
function SelectCourseName(c1,d1) {
    var c1 = document.getElementById(c1);
    var d1 = document.getElementById(d1);
    d1.innerHTML = "";

    if(c1.value == "Issues in ICT"){
        var optionArray = ["ITIB3182|ITIB3182"];
    }
        else if(c1.value == "Discrete Mathematics"){
        var optionArray = ["ITNB1023|ITNB1023"];
        }
         else if(c1.value == "Databases"){
        var optionArray = ["ITIB2063|ITIB2063"];
        }
         else if(c1.value == "Operating Systems"){
        var optionArray = ["ITIB2063|ITIB2063"];
        }
        else if(c1.value == "Knowledge Management"){
        var optionArray = ["ITIB2064|ITIB2064"];
        }
         else if(c1.value == "Object-Oriented Programming"){
        var optionArray = ["ITIB2064|ITIB2064"];
        }
         else if(c1.value == "Requirements Engineering"){
        var optionArray = ["ITWB4184|ITWB4184"];
        } 
         else if(c1.value == "Principles of Accounting"){
        var optionArray = ["BAPB418|BAPB418"];
         }
         else if(c1.value == "Human Resource Management"){
        var optionArray = ["BAHRM419|BAHRM419"];
         }
         else if(c1.value == "Principles of Performing Arts"){
        var optionArray = ["DAPPA422|DAPPA422"];
         }
         else if(c1.value == "Voice and Speech"){
        var optionArray = ["DAPVS430|DAPVS430"];
         }
          else if(c1.value == "News Writing"){
        var optionArray = ["BCNW233|BCNW233"];
         }
        else if(c1.value == "Online Journalism"){
        var optionArray = ["BCOJ234|BCOJ234"];
         }
         else if(c1.value == "Counselling in Education"){
        var optionArray = ["BECE134|BECE134"];
         }
        else if(c1.value == "Statistics in Education"){
        var optionArray = ["BESE135|BESE135"];
         }
         else if(c1.value == "Critical Thinking"){
        var optionArray = ["DCPACT35|DCPACT35"];
         } 
          else if(c1.value == "Voice and Speech"){
        var optionArray = ["DCPVS36|DCPVS36"];
         }
    for(var option in optionArray){
        var pair = optionArray[option].split("|");
        var newOption = document.createElement("option");
        newOption.value = pair[0];
        newOption.innerHTML = pair[1];
        d1.options.add(newOption);

    }
}
</script>
  <!--=====================Create the Faculty of Exam Paper===============================-->
<div class="form-group has-success">

         <label for="default" class="col-sm-2 control-label">Faculty</label>
         <div class="col-sm-10">
 <select name="faculty" class="form-control" id="faculty" required="required" onchange="Selectfaculty(this.id, 'programme');">
         <option value="" disabled  selected hidden>  Select Faculty </option>
         <option value="Faculty of Business Technology and Accounting">Faculty of Business Technology and Accounting</option>
         <option value="Faculty of Education and Humanities">Faculty of Education and Humanities</option>
</select> 
</div>
     </div>

      <!--=====================Create the Programme of Exam Paper===============================-->
<div class="form-group has-success">
         <label for="primary" class="col-sm-2 control-label">Programme</label>
         <div class="col-sm-10">
  <select name="programme" class="form-control" id="programme" required="required" onchange="SelectProgramme(this.id, 'coursename');" > 
      <option value="" disabled  selected hidden>  Select Faculty first </option>
  </select>
</div>
     </div>
<!--=====================Create the Course Name of Exam Paper===============================-->
<div class="form-group has-success">
         <label for="default" class="col-sm-2 control-label">Course Name</label>
         <div class="col-sm-10">
  <select name="coursename" onBlur="checkCoursenameAvailability()" class="form-control" id="coursename" onchange="SelectCourseName(this.id, 'coursecode');" required="required" > 
      <option value="" disabled  selected hidden>  Select Programme first </option>
  </select>
  <span id="coursename-availability-status" style="font-size:12px;"></span>
</div>
     </div>
   
 <!--=====================Create the Course Code of Exam Paper===============================-->
<div class="form-group has-success">
         <label for="success" class="col-sm-2 control-label">Course Code</label>
         <div class="col-sm-10">
  <select name="coursecode" class="form-control" id="coursecode" required="required" onchange="SelectProgramme(this.id, 'coursename');" > 
      <option value="" disabled  selected hidden>  Select Coure Name first </option>
  </select>
</div>
     </div>

<!--=====================Create the Section of the Course===============================-->
<div class="form-group has-success">
        <label for="success" class="col-sm-2 control-label">Section</label>
        <div class="col-sm-10">
<select name="section" class="form-control" id="success" required="required">
         <option value="" disabled  selected hidden>  Select the Section of the course</option>
         <option value="S1">S1</option>
         <option value="S2">S2</option>
         <option value="S3">S3</option>
         <option value="S4">S4</option>
         <option value="S5">S5</option>
 </select>
                                                        </div>
                                                    </div>
 <!--=====================Create the Exam date of the Course===============================-->
<div class="form-group has-success">
         <label for="default" class="col-sm-2 control-label">Exam Date</label>
         <div class="col-sm-10">
 <input type="date" data-date-format="DD-MM-YYYY" name="examdate" class="form-control" id="date" required="required" >
                                                        </div>
                                                    </div>
<!--=====================Create the Start time of the Course===============================-->
<div class="form-group has-success">
         <label for="default" class="col-sm-2 control-label">Start Time</label>
         <div class="col-sm-10">
 <input type="time"  name="starttime" class="form-control" id="time" required="required" >
                                                        </div>
                                                    </div>
 <!--=====================Create the End time of the Course===============================-->
<div class="form-group has-success">
         <label for="default" class="col-sm-2 control-label">End Time</label>
         <div class="col-sm-10">
 <input type="time"  name="endtime" class="form-control" id="time" required="required">
                                                        </div>
                                                    </div>

  <!--=====================Create the Submit for Exam Paper info===============================-->
 <div class="form-group has-success">
    <div class="col-sm-offset-2 col-sm-10">

                <!--================ Back Button=================-->
      <a href="dashboard.php" class="btn btn-danger btn-labeled pull-left"><font face="Trebuchet MS" ><b>Back</font><span class="btn-label btn-label-right"><i class="fa fa-close"></i></span></a>&nbsp;&nbsp;&nbsp;

                 <!--================ Sumbit Button=================-->
      <button type="submit" name="submit" class="btn btn-primary btn-labeled pull-left">Submit<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
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
<?php }?>
