<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$id =$name =  $phone = $email = $address= $img="";
$id_err =$name_err =  $phone_err = $email_err = $address_err= $img_err="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
     $input_id = trim($_POST["SUPPID"]);
    if(empty($input_id)){
        $id_err = "Please enter a id.";
    } 
     else{
        $id = $input_id;
    }
    // Validate name
    $input_name = trim($_POST["SUPPNAME"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate position
    $input_phone = trim($_POST["SUPPPHONE"]);
    if(empty($input_phone)){
        $phone_err = "Please enter a phone number.";     
    } elseif(!is_numeric($input_phone)){
        $phone_err = "Please enter a positive integer value.";
    } else{
        $phone = $input_phone;
    }
    
    // Validate salary
    $input_email = trim($_POST["SUPPEMAIL"]);
    if(empty($input_email)){
        $email_err = "Please enter an email.";
    }
    else{
        $email = $input_email;
    }

     $input_address = trim($_POST["SUPPADDRESS"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address= $input_address;
    }


    // Check input errors before inserting in database
    if(empty($name_err) && empty($phone_err) && empty($email_err) && empty($address_err) ){
        // Prepare an insert statement

        $sql = "INSERT INTO SUPPLIER (SUPPID,SUPPNAME,SUPPPHONE,SUPPEMAIL,SUPPADDRESS) VALUES (?, ? ,?,?,?)";
         
        //if($stmt = mysqli_prepare($link, $sql)){
        if($stmt = $link->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_salary);
            $stmt->bindParam(1, $param_id, PDO::PARAM_STR);
            $stmt->bindParam(2, $param_name, PDO::PARAM_STR);
            $stmt->bindParam(3, $param_phone, PDO::PARAM_INT);
            $stmt->bindParam(4, $param_email, PDO::PARAM_STR);
            $stmt->bindParam(5, $param_address, PDO::PARAM_STR);
            // Set parameters
            $param_id = $id;
            $param_name = $name;
            $param_phone = $phone;
            $param_email = $email;
            $param_address = $address;
            
            // Attempt to execute the prepared statement
            //if(mysqli_stmt_execute($stmt)){
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: projects.php");
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
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($id_err)) ? 'has-error' : ''; ?>">
                            <label>Supplier ID</label>
                            <?php 
                        require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT max(SUPPID) AS oldid FROM SUPPLIER";
                   if ($result = $link->query($sql)) {
                        //if(mysqli_num_rows($result) > 0){
                            if($result->fetchColumn()>0){
                                //while($row = mysqli_fetch_array($result)){
                                foreach ($link->query($sql) as $row) {
                                    $id = $row[0] +1;
                                }
                            }
                        }
                            $result->closeCursor();
                            ?>
                            <input type="text" name="SUPPID" class="form-control" value="<?php echo $id; ?>" >
                            <span class="help-block"><?php echo $id_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="SUPPNAME" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                            <label>Phone Number</label>
                            <textarea name="SUPPPHONE" class="form-control"><?php echo $phone; ?></textarea>
                            <span class="help-block"><?php echo $phone_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="input" name="SUPPEMAIL" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>
                          <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Address</label>
                            <textarea name="SUPPADDRESS" class="form-control"><?php echo $address; ?></textarea>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="supplier.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>