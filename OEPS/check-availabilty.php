<?php
include 'includes/config.php';


// Code for checking Course Name availabilty from exampaper table
if (!empty($_POST["coursename"])) {
    $cname = $_POST["coursename"];
    $sql ="SELECT CourseName FROM  exampaper WHERE CourseName=:cname";
    $query = $dbh->prepare($sql);
    $query->bindParam(':cname', $cname, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        echo "<span style='color:red'> Course name already exists.Use another one.</span>";
    } else {
        echo "<span style='color:green'> Course name available for Registration.</span>";
    }
}

// Code for checking Course Name availabilty from examhall table
if (!empty($_POST["coursename"])) {
    $cname = $_POST["coursename"];
    $sql = "SELECT 	PaperId FROM  examhall WHERE PaperId=:cname";
    $query = $dbh->prepare($sql);
    $query->bindParam(':cname', $cname, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        echo "<span style='color:red'> Course name already exists. Use another one.</span>";
    } else {
        echo "<span style='color:green'> Course name available for Registration.</span>";
    }
}
// Code for checking Hall Name availabilty from examhall table
if (!empty($_POST["hallname"])) {
    $hname = $_POST["hallname"];
    $sql = "SELECT HallName FROM  examhall WHERE HallName=:hname";
    $query = $dbh->prepare($sql);
    $query->bindParam(':hname', $hname, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        echo "<span style='color:red'> Hall name already exists.Use another one.</span>";
    } else {
        echo "<span style='color:green'> Hall name available for Registration.</span>";
    }
}

// Code for checking student name availabilty from unistudents table
if(!empty($_POST["studentname"])) {
$sname= $_POST["studentname"];
$sql ="SELECT StudentName FROM  unistudents WHERE StudentName=:sname";
$query= $dbh -> prepare($sql);
$query-> bindParam(':sname', $sname, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> Student name already exists.Use another one.</span>";
} else{	
echo "<span style='color:green'> Student name available for Registration.</span>";
}
}
 
// Code for checking Matric Number availabilty from unistudents table
if(!empty($_POST["matricnumber"])) {
$mnumber= $_POST["matricnumber"];
$sql ="SELECT MatricNumber FROM  unistudents WHERE MatricNumber=:mnumber";
$query= $dbh -> prepare($sql);
$query-> bindParam(':mnumber', $mnumber, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> Matric Number already exists. Use another one.</span>";
} else{	
echo "<span style='color:green'> Matric number available for Registration.</span>";
}
}
// Code for checking Combine Student name availabilty from combinecourse table
if (!empty($_POST["studentname"])) {
    $sname = $_POST["studentname"];
    $sql = "SELECT 	StudentId FROM  combinecourse WHERE StudentId=:sname";
    $query = $dbh->prepare($sql);
    $query->bindParam(':sname', $sname, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        echo "<span style='color:red'> Student name already exists. Use another one.</span>";
    } else {
        echo "<span style='color:green'> Student name available for Registration.</span>";
    }
}

// Code for checking Combine Course name availabilty from combinecourse table
if(!empty($_POST["coursename"])) {
$cname= $_POST["coursename"];
$sql ="SELECT PaperId FROM  combinecourse WHERE PaperId=:cname";
$query= $dbh -> prepare($sql);
$query-> bindParam(':cname', $cname, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> Course name already exists. Use another one.</span>";
} else{	
echo "<span style='color:green'> Course name available for Registration.</span>";
}
}


?>
  
        
      