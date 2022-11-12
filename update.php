<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name =  $position = $salary = $hiredate ="";
$name_err =$position_err= $salary_err =  $hiredate_err="";
 
// Processing form data when form is submitted
if(isset($_POST["STAFFID"]) && !empty($_POST["STAFFID"])){
    // Get hidden input value
    $id = $_POST["STAFFID"];
    
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
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $salary = $input_salary;
    }
    
  /*   $input_hiredate = trim($_POST["STAFFHIREDATE"]);
    if(empty($input_hiredate)){
        $hiredate_err = "Please enter a hire date.";     
    } else{
        $hiredate = $input_hiredate;
    }*/

    // Check input errors before inserting in database
    if(empty($name_err) && empty($position_err) && empty($salary_err) && empty($hiredate_err)){
        // Prepare an update statement
        $sql = "UPDATE STAFF SET STAFFNAME=?, STAFFPOSITION=?, STAFFSALARY=? WHERE STAFFID=?";
         //nanti tambah hire date
        //if($stmt = mysqli_prepare($link, $sql)){
        if($stmt = $link->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_address, $param_salary, $param_id);
            $stmt->bindParam(1, $param_name, PDO::PARAM_STR);
            $stmt->bindParam(2, $param_position, PDO::PARAM_STR);
            $stmt->bindParam(3, $param_salary, PDO::PARAM_STR);
            $stmt->bindParam(4, $param_id, PDO::PARAM_INT);
         //   $stmt->bindParam(5, $param_hiredate, PDO::PARAM_INT);
            
            // Set parameters
            $param_name = $name;
            $param_position= $position;
            $param_salary = $salary;
            $param_id = $id;
         //   $param_hiredate = $hiredate;
            
            // Attempt to execute the prepared statement
            //if(mysqli_stmt_execute($stmt)){
            if($stmt->execute()){                               
                // Records updated successfully. Redirect to landing page
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM STAFF WHERE STAFFID = ?";
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
                    $name = $row["STAFFNAME"];
                    $position = $row["STAFFPOSITION"];
                    $salary = $row["STAFFSALARY"];
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
                            <input type="text" name="STAFFNAME" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                            <label>Position</label>
                            <textarea name="STAFFPOSITION" class="form-control"><?php echo $position; ?></textarea>
                            <span class="help-block"><?php echo $position_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                            <label>Salary (RM)</label>
                            <input type="text" name="STAFFSALARY" class="form-control" value="<?php echo $salary; ?>">
                            <span class="help-block"><?php echo $salary_err;?></span>
                        </div>
                        <input type="hidden" name="STAFFID" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="projects.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>