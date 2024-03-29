<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{
        if (isset($_GET['del'])) {            
        $hid = $_GET['del'];
        $sql = "delete from examhall  WHERE HallId=:hid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':hid', $hid, PDO::PARAM_STR);
        $query->execute();
        $msg = " Hall deleted successfully";
        }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Admin Manage Exam Halls</title>
        
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" > <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
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
    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
   <?php include('includes/topbar.php');?> 
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">
<?php include('includes/leftbar.php');?>  

                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Manage Halls</h2>
                                
                                </div>
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
            							<li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Assign Exam Halls</li>
            							<li class="active">Manage Halls</li>
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
                                                    <h5>View Halls Info</h5>
                                                </div>
                                            </div>
<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
  <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php } 

else if($error){?>
 <div class="alert alert-danger left-icon-alert" role="alert">
    <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
 </div> <?php } ?>
                                            <div class="panel-body p-20">

                                                <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Capacity</th>
                                                            <th>Level</th>
                                                            <th>Wing</th>
                                                            <th>Region</th>
                                                            <th>Course Name</th>
                                                            <th>Creation Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                          <th>#</th>
                                                            <th>Name</th>
                                                            <th>Capacity</th>
                                                            <th>Level</th>
                                                            <th>Wing</th>
                                                            <th>Region</th>
                                                            <th>Course Name</th>
                                                            <th>Creation Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>

<?php $sql = "SELECT examhall.HallName,examhall.HallCapacity,examhall.LevelNumber,examhall.Wing,examhall.Region,examhall.CreationDate,examhall.HallId,exampaper.CourseName,exampaper.CourseCode from examhall join exampaper on exampaper.Paper_id=examhall.PaperId";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
<tr>
 <td align="center"><?php echo htmlentities($cnt);?></td>
                                                            <td align="center"><?php echo htmlentities($result->HallName);?></td>
                                                            <td align="center"><?php echo htmlentities($result->HallCapacity);?></td>
                                                            <td align="center"><?php echo htmlentities($result->LevelNumber);?></td>
                                                            <td align="center"><?php echo htmlentities($result->Wing);?></td>
                                                            <td><?php echo htmlentities($result->Region);?></td>
                                                            <td><?php echo htmlentities
                                                            ($result->CourseName);?> &nbsp; / <?php echo htmlentities($result->CourseCode); ?></td>
                                                            <td><?php echo htmlentities($result->CreationDate);?></td>

<!-- Links to the Edit-hall.php for updating the exam hall-->
<td align="center">
<a href="edit-hall.php?hallid=<?php echo htmlentities($result->HallId);?>"><i class="fa fa-edit fa-2x" title="Edit Record" style="color:DodgerBlue ;" ></i> </a> &nbsp;&nbsp;

<a href="manage-halls.php?del=<?php echo $result->HallId; ?>"><i class="fa fa-trash-o fa-2x" title= "Delete row" style="color:red;" onClick="return confirm('Do you really want to delete the Hall from the Exam Halls?');"> </i> </a>

</td>
</tr>
<?php $cnt=$cnt+1;}} ?>
                                                       
                                                    
                                                    </tbody>
                                                </table>

                                         
                                                <!-- /.col-md-12 -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-6 -->

                                                               
                                                </div>
                                                <!-- /.col-md-12 -->
                                            </div>
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                    <!-- /.col-md-6 -->

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
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>
        <script src="js/DataTables/datatables.min.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $('#example').DataTable();

                $('#example2').DataTable( {
                    "scrollY":        "300px",
                    "scrollCollapse": true,
                    "paging":         false
                } );

                $('#example3').DataTable();
            });
        </script>
    </body>
</html>
<?php } ?>