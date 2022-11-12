<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name =  $phone = $email = $address =$member="";
$name_err =$phone_err= $email_err =  $address_err=$member_err="";
 
// Processing form data when form is submitted
if(isset($_POST["CUSTID"]) && !empty($_POST["CUSTID"])){
    // Get hidden input value
    $id = $_POST["CUSTID"];
    
    // Validate name
    $input_name = trim($_POST["CUSTNAME"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate position
    $input_phone = trim($_POST["CUSTPHONE"]);
    if(empty($input_phone)){
        $phone_err = "Please enter a phone number.";     
    } else{
        $phone = $input_phone;
    }
    
    // Validate salary
    $input_email = trim($_POST["CUSTEMAIL"]);
    if(empty($input_email)){
        $phone_err = "Please enter an email.";     
    } else{
        $email = $input_email;
    }
     $input_address = trim($_POST["CUSTADDRESS"]);
    if(empty($input_address)){
        $address_err = "Please enter address.";     
    } else{
        $address = $input_address;
    }
    
 $input_member = trim($_POST["CUSTMEMBER"]);
    if(empty($input_member)){
        $member_err = "Please enter membership.";     
    } else{
        $member = $input_member;
    }
    // Check input errors before inserting in database
    if(empty($name_err) && empty($phone_err) && empty($email_err) && empty($address_err)){
        // Prepare an update statement
        $sql = "UPDATE CUSTOMER SET CUSTNAME=?, CUSTPHONE=?, CUSTEMAIL=? ,CUSTADDRESS=?,CUSTMEMBER=? WHERE CUSTID=?";
         //nanti tambah hire date
        //if($stmt = mysqli_prepare($link, $sql)){
        if($stmt = $link->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_address, $param_salary, $param_id);
            $stmt->bindParam(1, $param_name, PDO::PARAM_STR);
            $stmt->bindParam(2, $param_phone, PDO::PARAM_INT);
            $stmt->bindParam(3, $param_email, PDO::PARAM_STR);
            $stmt->bindParam(4, $param_address, PDO::PARAM_STR);
            $stmt->bindParam(5, $param_member, PDO::PARAM_STR);
            $stmt->bindParam(6, $param_id, PDO::PARAM_INT);
            
            // Set parameters
            $param_name = $name;
            $param_phone= $phone;
            $param_email = $email;
            $param_address = $address;
            $param_member = $member;
            $param_id = $id;
         //   $param_hiredate = $hiredate;
            
            // Attempt to execute the prepared statement
            //if(mysqli_stmt_execute($stmt)){
            if($stmt->execute()){                               
                // Records updated successfully. Redirect to landing page
                header("location: viewCust.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        //mysqli_stmt_close($stmt);
        $stmt->closeCursor(); //PDO close
    }
    
    // Close connection
    //mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM CUSTOMER WHERE CUSTID = ?";
        //if($stmt = mysqli_prepare($link, $sql)){
        if($stmt = $link->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "i", $param_id);
            $stmt->bindParam(1, $param_id, PDO::PARAM_INT);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            //if(mysqli_stmt_execute($stmt)){
            if($stmt->execute()){ 
                //$result = mysqli_stmt_get_result($stmt);
                $result = $stmt->fetchAll();
    
                //if(mysqli_num_rows($result) == 1){
                if(count($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    //$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $row = $result[0];
                    
                    // Retrieve individual field value
                    $name = $row["CUSTNAME"];
                    $phone = $row["CUSTPHONE"];
                    $email = $row["CUSTEMAIL"];
                    $address = $row["CUSTADDRESS"];
                    $member = $row["CUSTMEMBER"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        //mysqli_stmt_close($stmt);
        $stmt->closeCursor(); //PDO close
        
        // Close connection
        //mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="CUSTNAME" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                            <label>Phone Number</label>
                            <textarea name="CUSTPHONE" class="form-control"><?php echo $phone; ?></textarea>
                            <span class="help-block"><?php echo $phone_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="text" name="CUSTEMAIL" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <input type="text" name="CUSTADDRESS" class="form-control" value="<?php echo $address; ?>">
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                          <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Membership</label>
                            <select name="CUSTMEMBER">
                                <option value="Elite"> ELITE (RM5)</option>
                                <option value="Average"> AVERAGE (RM3) </option>
                            </select>
                            <span class="help-block"><?php echo $member_err;?></span>
                        </div>
                        <input type="hidden" name="CUSTID" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="viewCust.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>