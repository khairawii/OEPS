<?php
include 'includes/config.php';
error_reporting(0);
if (!empty($_POST["courseid"])) 
  {
    $pid = intval($_POST['courseid']);
    if (!is_numeric($pid)) {

        echo htmlentities("invalid Hall");exit;
    } else {
        $stmt = $dbh->prepare("SELECT HallName,HallId FROM examhall WHERE PaperId= :Paper_id order by HallName");
        $stmt->execute(array(':Paper_id' => $pid));
        ?>
        <option value="" disabled  selected hidden>Select Hall Name</option> <?php
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
          {
              ?>
  <option value="<?php echo htmlentities($row['HallId']); ?>"><?php echo htmlentities($row['HallName']); ?></option>
  <?php
}
    }

}
// Code for Students
if (!empty($_POST["courseid1"])) 
{
    $pid1 = intval($_POST['courseid1']);
    if (!is_numeric($pid1)) {

        echo htmlentities("invalid Course");exit;
    } else {
        $status = 0;
        $stmt = $dbh->prepare("SELECT unistudents.StudentName,unistudents.Student_id FROM combinecourse join  unistudents on  unistudents.Student_id=combinecourse.StudentId WHERE combinecourse.PaperId=:pid and combinecourse.status!=:stts order by unistudents.StudentName");
        $stmt->execute(array(':pid' => $pid1, ':stts' => $status));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {?>
           
           <?php $cnt+=1; 
             if ($stmt->rowCount() > 0) {
                     ?>


        
  <p> <?php echo htmlentities($row['StudentName']); ?><input type="text"  name="seats[]" value= "<?php echo htmlentities($cnt);
 ?>" class="form-control" required="" placeholder="Enter seating number according Hall Capacity" autocomplete="off"></p>
<?php }

    }
}
    }

?>
<!--========= For checking if the seating number already exist==========-->
<?php

if (!empty($_POST["studpaper"])) {
    $Seat_id = $_POST['studpaper'];
    $dta = explode("$", $Seat_id);
    $Seat_id = $dta[0];
    $Seat_id1 = $dta[1];
    $query = $dbh->prepare("SELECT PaperId,StudentId FROM seatnumber WHERE PaperId=:Seat_id  and StudentId=:Seat_id1 ");
//$query= $dbh -> prepare($sql);
        $query->bindParam(':Seat_id', $Seat_id, PDO::PARAM_STR);
    $query->bindParam(':Seat_id1', $Seat_id1, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
    if ($query->rowCount() > 0) {?>
<p>
<?php
echo "<span style='color:red'> Seats Already Declared .</span>";
        echo "<script>$('#submit').prop('disabled',true);</script>";
        ?></p>
<?php }

}?>
