<html>
<body>
 <?php
$con = oci_connect("ARMANTIE", "armantie", "localhost/XE");//connection string 
if (!$con) {
$m = oci_error();
echo $m['message'], "\n";
//error fuction returns an oracle message.
exit; }
$query = "SELECT *  FROM STAFF WHERE STAFFID =
 :user_bv and STAFFPASS=:pwd"; 
//query is sent to the db to fetch row id.
 $stid = oci_parse($con, $query);

 if (isset($_POST['user'])||isset($_POST['pwd'])||isset($_POST['position'])){           
$user = $_POST['user'];
$pass=$_POST['pwd'];
$position=$_POST['position'];
}
oci_bind_by_name($stid, ':user_bv', $user);
oci_bind_by_name($stid, ':pwd', $pass);
oci_execute($stid);

$row = oci_fetch_array($stid, OCI_ASSOC);

//oci_fetch_array returns a row from the db.

 if ($row && ($position == $row['STAFFPOSITION'])) {
 	session_start();
 $_SESSION['user']=$_POST['user'];
  $_SESSION['id']=$row['STAFFID'];
echo "<script>alert('WELCOME ".$_SESSION['user']."')</script>";
  }
 else {
echo "<script>alert('INVALID USERNAME OR PASSWORD')</script>";
echo"<script>location.replace('staffLogin.php')</script>";

exit;
}
$id = $row['STAFFID']; 
oci_free_statement($stid);
oci_close($con);

if ($row['STAFFPOSITION'] == "MANAGER"){
echo"<script>location.replace('projects.php')</script>";
}
else{
	echo"<script>location.replace('sales.php')</script>";
}
//header function locates you to a welcome page saved s wel.php
 ?>
 </body>
 </html>