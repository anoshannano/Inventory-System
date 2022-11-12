<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$id=$name =  $position = $salary = $password="";
$id_err = $name_err =$position_err= $salary_err =  $password_err="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
     $input_id = trim($_POST["STAFFID"]);
    if(empty($input_id)){
        $id_err = "Please enter a id.";
    } 
     else{
        $id = $input_id;
    }
    // Validate name
    $input_name = trim($_POST["STAFFNAME"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    // Validate position
    $input_position = trim($_POST["STAFFPOSITION"]);
    if(empty($input_position)){
        $position_err = "Please enter a positon.";     
    } else{
        $position = $input_position;
    }
    
    // Validate salary
    $input_salary = trim($_POST["STAFFSALARY"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the salary amount.";     
    } elseif(!is_numeric($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }

     $input_pass = trim($_POST["STAFFPASS"]);
    if(empty($input_pass)){
        $password_err = "Please enter a password.";     
    } else{
        $password = $input_pass;
    }

    // Check input errors before inserting in database
    if(empty($name_err) && empty($position_err) && empty($salary_err) && empty($password_err) ){
        // Prepare an insert statement

        $sql = "INSERT INTO STAFF (STAFFID,STAFFNAME, STAFFPOSITION, STAFFSALARY,STAFFPASS) VALUES (?, ? ,?,?,?)";
         
        //if($stmt = mysqli_prepare($link, $sql)){
        if($stmt = $link->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_salary);
            $stmt->bindParam(1, $param_id, PDO::PARAM_STR);
            $stmt->bindParam(2, $param_name, PDO::PARAM_STR);
            $stmt->bindParam(3, $param_position, PDO::PARAM_STR);
            $stmt->bindParam(4, $param_salary, PDO::PARAM_STR);
            $stmt->bindParam(5, $param_pass, PDO::PARAM_STR);
            
            // Set parameters
            $param_id = $id;
            $param_name = $name;
            $param_position = $position;
            $param_salary = $salary;
            $param_pass = $password;
            
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
                            <label>Staff ID</label>
                            <?php 
                        require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT max(STAFFID) AS oldid FROM STAFF";
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
                            <input type="text" name="STAFFID" class="form-control" value="<?php echo $id; ?>" >
                            <span class="help-block"><?php echo $id_err;?></span>
                        </div>

                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="STAFFNAME" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($position_err)) ? 'has-error' : ''; ?>">
                            <label>Position</label>
                            <textarea name="STAFFPOSITION" class="form-control"><?php echo $position; ?></textarea>
                            <span class="help-block"><?php echo $position_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label>Salary</label>
                            <input type="text" name="STAFFSALARY" class="form-control" value="<?php echo $salary; ?>">
                            <span class="help-block"><?php echo $salary_err;?></span>
                        </div>
                          <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Password</label>
                            <input type="text" name="STAFFPASS" class="form-control" value="<?php echo $password; ?>">
                            <span class="help-block"><?php echo $password_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="projects.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>