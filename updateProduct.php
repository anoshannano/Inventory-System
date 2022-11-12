<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$prodName =  $prodDesc =  $prodPrice = $prodQty = $keyword ="";
$prodName_err =  $prodDesc_err =  $prodPrice_err = $prodQty_err = $keyword_err =""; 
// Processing form data when form is submitted
if(isset($_POST["PRODCODE"]) && !empty($_POST["PRODCODE"])){
    // Get hidden input value
    $id = $_POST["PRODCODE"];
    
    // Validate name
    $input_name = trim($_POST["PRODNAME"]);
    if(empty($input_name)){
        $prodName_err = "Please enter a product name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $prodName_err = "Please enter a valid name.";
    } else{
        $prodName = $input_name;
    }
    $input_desc = trim($_POST["PRODDESC"]);
    if(empty($input_desc)){
        $prodDesc_err = "Please enter a product description.";
    } else{
        $prodDesc = $input_desc;
    }

    $input_prodPrice = trim($_POST["PRODPRICE"]);
    if(empty($input_prodPrice)){
        $prodPrice_err = "Please enter the Product Price.";     
    }elseif(!is_numeric($input_prodPrice)){
        $prodPrice_err = "Please enter a positive integer value.";}
    else{
        $prodPrice = $input_prodPrice;
    }

    $input_prodQty = trim($_POST["PRODQTY"]);
    if(empty($input_prodQty)){
        $prodPrice_err = "Please enter the Product Quantity."; 
    }elseif(!is_numeric($input_prodQty)){
        $prodPrice_err = "Please enter a positive integer value.";}
    else{
        $prodQty = $input_prodQty;
    }

 $input_keyword = trim($_POST["KEYWORD"]);
    if(empty($input_keyword)){
        $keyword_err = "Please enter the keyword";     
    }
    else{
        $keyword = $input_keyword;
    }
    // Check input errors before inserting in database
    if(empty($prodName_err) && empty($prodPrice_err)&& empty($prodQty_err) && empty($keyword_err) ){
        // Prepare an update statement
        $sql = "UPDATE PRODUCT SET PRODNAME=?,PRODDESC =?, PRODPRICE=? ,PRODQTY=?, KEYWORD=? WHERE PRODCODE=?";
         //nanti tambah hire date
        //if($stmt = mysqli_prepare($link, $sql)){
        if($stmt = $link->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_address, $param_salary, $param_id);
            $stmt->bindParam(1, $param_name, PDO::PARAM_STR);
            $stmt->bindParam(2, $param_desc, PDO::PARAM_STR);
            $stmt->bindParam(3, $param_price, PDO::PARAM_INT);
            $stmt->bindParam(4, $param_qty, PDO::PARAM_INT);
            $stmt->bindParam(5, $param_keyword, PDO::PARAM_STR);
            $stmt->bindParam(6, $param_id, PDO::PARAM_INT);
            
            // Set parameters
            $param_name = $prodName;
            $param_desc = $prodDesc;
            $param_price =$prodPrice;
            $param_qty = $prodQty;
            $param_keyword = $keyword;
            $param_id = $id;

            
            // Attempt to execute the prepared statement
            //if(mysqli_stmt_execute($stmt)){
            if($stmt->execute()){                               
                // Records updated successfully. Redirect to landing page
                header("location: products.php");
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
        $sql = "SELECT * FROM PRODUCT WHERE PRODCODE = ?";
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
                    $prodName = $row["PRODNAME"];
                    $prodDesc = $row["PRODDESC"];
                    $prodPrice = $row["PRODPRICE"];
                    $prodQty = $row["PRODQTY"];
                    $keyword = $row["KEYWORD"];
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
                        <div class="form-group <?php echo (!empty($prodName_err)) ? 'has-error' : ''; ?>">
                            <label>Product Name</label>
                            <input type="text" name="PRODNAME" class="form-control" value="<?php echo $prodName; ?>">
                            <span class="help-block"><?php echo $prodName_err;?></span>
                        </div>
                         <div class="form-group <?php echo (!empty($prodDesc_err)) ? 'has-error' : ''; ?>">
                            <label>Descripton</label>
                            <textarea name="PRODDESC" class="form-control"><?php echo $prodDesc; ?></textarea>
                            <span class="help-block"><?php echo $prodDesc_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($prodPrice_err)) ? 'has-error' : ''; ?>">
                            <label>Product Price (RM)</label>
                            <textarea name="PRODPRICE" class="form-control"><?php echo $prodPrice; ?></textarea>
                            <span class="help-block"><?php echo $prodPrice_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($prodQty_err)) ? 'has-error' : ''; ?>">
                         <label>Product Quantity</label>
                            <input type="text" name="PRODQTY" class="form-control" value="<?php echo $prodQty; ?>">
                            <span class="help-block"><?php echo $prodQty_err;?></span>
                        </div>
                       <div class="form-group <?php echo (!empty($keyword_err)) ? 'has-error' : ''; ?>">
                            <label>Keyword</label>
                            <textarea name="KEYWORD" class="form-control"><?php echo $keyword; ?></textarea>
                            <span class="help-block"><?php echo $keyword_err;?></span>
                        </div>

                        <input type="hidden" name="PRODCODE" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="products.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>