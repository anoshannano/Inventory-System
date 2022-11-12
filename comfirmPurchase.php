<?php 

include('auth.php');

$purchaseNo = $_POST['purchaseNo'];
$staffid = $session_id;
$totalPrice = $_POST['price'];
$custid = $_POST['custID'];
$custmember="";

$sql0= "SELECT * FROM CUSTOMER WHERE CUSTID = $custid";

if($stmt3 = $link->prepare($sql0)){
	if ($result = $link->query($sql0)) {
                            if($result->fetchColumn()>0){
                                $custmember= $row['CUSTMEMBER'];
                            }
                        }
                    }

if($custmember == 'Elite')
{
	$totalPrice = $totalPrice - ($totalPrice*0.20);
}
elseif ($custmember == 'Average') {
	$totalPrice = $totalPrice - ($totalPrice*0.10);
}else{
	$totalPrice = $_POST['price'];
}

$sql = "INSERT INTO PURCHASE(PURCHASENO,TOTALPURCHASE) VALUES (?,?)";
         
        //if($stmt = mysqli_prepare($link, $sql)){
        if($stmt = $link->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_salary);
            $stmt->bindParam(1, $param_no, PDO::PARAM_STR);
            $stmt->bindParam(2, $param_total, PDO::PARAM_STR);
            // Set parameters
            $param_no = $purchaseNo;
            $param_total = $totalPrice;
            
            // Attempt to execute the prepared statement
            //if(mysqli_stmt_execute($stmt)){
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: sales.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
         $sql2 = "INSERT INTO PAYMENT(CUSTID,STAFFID,PURCHASENO) VALUES (?,?,?)";
         
        //if($stmt = mysqli_prepare($link, $sql)){
        if($stmt2 = $link->prepare($sql2)){
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_salary);
            $stmt2->bindParam(1, $param_cid, PDO::PARAM_STR);
            $stmt2->bindParam(2, $param_sid, PDO::PARAM_STR);
            $stmt2->bindParam(3, $param_no, PDO::PARAM_STR);
            // Set parameters
            $param_cid = $custid;
            $param_sid = $staffid;
            $param_no = $purchaseNo;
            
            // Attempt to execute the prepared statement
            //if(mysqli_stmt_execute($stmt)){
            if($stmt2->execute()){
                // Records created successfully. Redirect to landing page
                header("location: sales.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        // Close statement
        //mysqli_stmt_close($stmt);
        $stmt->closeCursor(); //PDO close
  $stmt2->closeCursor();
    
    // Close connection
    //mysqli_close($link);

?>
 
