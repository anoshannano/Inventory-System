<?php
// Include config file
require_once "config.php";
 session_start();
// Define variables and initialize with empty values
    $prodcode=$prodName =  $prodDesc = $prodPrice = $prodQty = $keyword =$staffid =$suppid=$suppname="";
    $prodcode_err=$prodName_err =  $prodDesc_err = $prodPrice_err = $prodQty_err = $keyword_err =""; 
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
     $input_code = trim($_POST["PRODCODE"]);
    if(empty($input_code)){
        $prodcode_err = "Please enter a code.";
    } elseif(!is_numeric($input_code)){
        $prodcode_err = "Please enter a positive integer value.";}
     else{
        $prodcode = $input_code;
    }

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

    $staffid = trim($_POST["STAFFID"]);
    $suppid =trim($_POST["SUPPID"]);

    // Check input errors before inserting in database
    if(empty($prodcode_err) &&empty($prodName_err)&& empty($prodPrice_err)&& empty($prodQty_err) && empty($keyword_err) ){
        // Prepare an insert statement

        $sql = "INSERT INTO PRODUCT(PRODCODE,PRODNAME,PRODDESC , PRODPRICE ,PRODQTY, KEYWORD,STAFFID,SUPPID) VALUES (?,?,?,?,?,?,?,?)";
         
        //if($stmt = mysqli_prepare($link, $sql)){
        if($stmt = $link->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            //mysqli_stmt_bind_param($stmt, "sssi", $param_name, $param_address, $param_salary, $param_id);
            $stmt->bindParam(1, $param_code, PDO::PARAM_INT);
            $stmt->bindParam(2, $param_name, PDO::PARAM_STR);
            $stmt->bindParam(3, $param_desc, PDO::PARAM_STR);
            $stmt->bindParam(4, $param_price, PDO::PARAM_INT);
            $stmt->bindParam(5, $param_qty, PDO::PARAM_INT);
            $stmt->bindParam(6, $param_keyword, PDO::PARAM_STR);
            $stmt->bindParam(7, $param_id, PDO::PARAM_STR);
            $stmt->bindParam(8, $param_sid, PDO::PARAM_STR);

            $param_code = $prodcode;
            $param_name = $prodName;
            $param_desc = $prodDesc;
            $param_price =$prodPrice;
            $param_qty = $prodQty;
            $param_keyword = $keyword;
            $param_id= $staffid;
            $param_sid= $suppid;
            
            
              // Attempt to execute the prepared statement
            //if(mysqli_stmt_execute($stmt)){
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
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
                   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($prodcode_err)) ? 'has-error' : ''; ?>">
                            <label>Product Code</label>
                            <?php 
                        require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT max(PRODCODE) AS oldid FROM PRODUCT";
                   if ($result = $link->query($sql)) {
                        //if(mysqli_num_rows($result) > 0){
                            if($result->fetchColumn()>0){
                                //while($row = mysqli_fetch_array($result)){
                                foreach ($link->query($sql) as $row) {
                                    $prodcode = $row[0] +1;
                                }
                            }
                            else {
                                $prodcode =1;
                            }
                        }
                        if(isset($_SESSION['id'])) {
                        $staffid = $_SESSION['id'];
                        }
                            $result->closeCursor();
                            ?>

                           
                            <input type="text" name="PRODCODE" class="form-control" value="<?php echo $prodcode; ?>" >
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
                        <div class="form-group">
                  <label for="exampleSelectBorder">Supplier</label>
                         <select name="SUPPID" class="form-control">
                          <?php 
                              require_once "config.php";
                    
                                // Attempt select query execution
                            $sql = "SELECT * FROM SUPPLIER";
                               if ($result = $link->query($sql)) {
                                    //if(mysqli_num_rows($result) > 0){
                                        if($result->fetchColumn()>0){
                                            //while($row = mysqli_fetch_array($result)){
                                            foreach ($link->query($sql) as $row) {
                                  echo "<option value=". $row['SUPPID'] . ">" . $row['SUPPNAME'] . "</option>";
                              }
                          }
                      }
                      else {echo "<option value=''> No supplier. </option>";}
                          ?>
                      }
                      </select>
                  </div>
                        <div class="form-group ">
                            <label>STAFF ID</label>
                             <input type="text" name="STAFFID" class="form-control" value="<?php echo $staffid; ?>" >
                        </div>
                       

                        <input type="hidden" name="PRODCODE" value="<?php echo $prodcode; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="products.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>