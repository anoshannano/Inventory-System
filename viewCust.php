
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

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


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
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
          <h1 class="page-header">Customer List</h1>
        </div>

        <div id="maintable"><div style="margin-top: -19px; margin-bottom: 21px;">
        </div>
    <table class="table table-bordered text-center">
 <button onclick="location.href='createCust.php'"type="button" class="btn btn-block btn-primary" style="width:150px">Add member</button>
</table>
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 20%">
                          Customer ID
                      </th>
                      <th style="width: 20%">
                          Name
                      </th>
                      <th style="width: 20%">
                           Phone
                      </th>
                      <th>
                          Address
                      </th>
                      <th style="width: 20%">
                          Membership
                      </th>
                      <th style="width: 20%">
                         Email
                      </th>
                      <th style="width: 8%">
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                  <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM CUSTOMER";
                    //if($result = mysqli_query($link, $sql)){
                    if ($result = $link->query($sql)) {
                        //if(mysqli_num_rows($result) > 0){
                            if($result->fetchColumn()>0){
                                //while($row = mysqli_fetch_array($result)){
                                foreach ($link->query($sql) as $row) {
                                    echo "<tr>";
                                        echo "<td>" . $row['CUSTID'] . "</td>";
                                        echo "<td>" . $row['CUSTNAME'] . "</td>";
                                        echo "<td>" . $row['CUSTPHONE'] . "</td>";
                                        echo "<td>" . $row['CUSTADDRESS'] . "</td>";
                                        echo "<td>" . $row['CUSTMEMBER'] . "</td>";
                                         echo "<td>" . $row['CUSTEMAIL'] . "</td>";

                          echo "<td><a href='updateCust.php?id=". $row['CUSTID'] ."' title='Update Record' data-toggle='tooltip'>
                              <i class='fas fa-pencil-alt'>
                              </i>
                              Update
                          </a>";
                           echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            //mysqli_free_result($result);
                            $result->closeCursor(); //PDO close
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    //mysqli_close($link);
                         ?>
  
          </table>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </section>

<div class="clearfix"></div>
</div>

</div>
</div>
<!-- /#page-wrapper -->






<!-- jQuery -->
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
