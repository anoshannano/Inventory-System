
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<title>ArmanTie Trade</title>

  <link rel="shortcut icon" href="logo.jpeg">
  <!-- Bootstrap Core CSS -->
  <link href="vendor2/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- MetisMenu CSS -->
  <link href="vendor2/metisMenu/metisMenu.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="dist2/css/sb-admin-2.css" rel="stylesheet">

  <!-- Custom Fonts -->
  <link href="vendor2/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


  
        <link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
        <script src="lib/jquery.js" type="text/javascript"></script>
        <script src="src/facebox.js" type="text/javascript"></script>
        <script type="text/javascript">
        	jQuery(document).ready(function($) {
        		$('a[rel*=facebox]').facebox({
        			loadingImage : 'src/loading.gif',
        			closeImage   : 'src/closelabel.png'
        		})
        	})
        </script>


      </head>

      <body>
 <?php include('navfixed.php');?>

       <div id="page-wrapper">
        <div class="row">
         <div class="col-lg-12">
          <h1 class="page-header">Purchase No : <?php echo $finalcode ?></h1>
        </div>
<div class="form-group">

  <form action = "comfirmPurchase.php" method="post">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


<table>
 
  <tr style="background-color: silver;">
    <th>Check it</th>
    <th>Product Name</th>
    <th>Quantity</th>
    <th>Price</th>
  </tr>
  <tr>
    <label>Purchase Number</label>
    <input type="text" name="purchaseNo" value="<?php echo $finalcode ?>"><br>
    <label>Customer ID</label>
    <input type="text" name="custID" value="0"> <br><br> 
      <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM PRODUCT";
                    //if($result = mysqli_query($link, $sql)){
                    if ($result = $link->query($sql)) {
                        //if(mysqli_num_rows($result) > 0){
                            if($result->fetchColumn()>0){
                                //while($row = mysqli_fetch_array($result)){
                                foreach ($link->query($sql) as $row) { ?>

    <td><input type="checkbox" name="<?php echo $row['PRODNAME'] ?>" value="<?php echo $row['PRODPRICE']?>" /></td>
    <td><?php echo $row['PRODNAME'] ?></td>
    <td><input type="text" name="qty" value="1"></td>
    <td>RM<?php echo $row['PRODPRICE'] ?></td>
  </tr>
 <?php echo"</td>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                             $result->closeCursor(); //PDO close
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . oci_error($link);
                    }?>
  </table>
  <p>Calculated Price: RM <input type="text" name="price" id="price" /></p>
  <input type="submit" class="btn btn-primary" value="Submit">
</form>
  <script type="text/javascript">
    $(document).ready(function() {

function calculateSum(){
 var sumTotal=0;
    $('table tbody tr').each(function() {
      var $tr = $(this);

      if ($tr.find('input[type="checkbox"]').is(':checked')) {
          
        var $columns = $tr.find('td').next('td').next('td');
         var $Qnty=parseInt($tr.find('input[type="text"]').val());

 var $Cost=parseInt($columns.next('td').html().split('RM')[1]);
         sumTotal+=$Qnty*$Cost;
      }
    });

       $("#price").val(sumTotal);
       
}

  $('#sum').on('click', function() {
     
    calculateSum();
  });

  $("input[type='text']").keyup(function() {
     calculateSum();

  });
  
   $("input[type='checkbox']").change(function() {
     calculateSum();

  });



})

    ;
  </script>
   <?php
        if(array_key_exists('button1', $_POST)) { 
            button1(); 
        } 
       
        function button1() { 
             echo 'haha';
        } 
       
    ?> 
  
<div class="clearfix"></div>
</div>

</div>
</div>
<script src="vendor2/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="vendor2/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="vendor2/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="dist2/js/sb-admin-2.js"></script>

<link href="vendors2/chosen.min.css" rel="stylesheet" media="screen">
<script src="vendors2/chosen.jquery.min.js"></script>
<script>
 $(function() {
  $(".chzn-select").chosen();

});

</script>

</body>

</html>
