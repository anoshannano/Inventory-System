<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ADMIN</title>
<?php session_start();
?>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
         <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="logout.php" class="nav-link">Log Out</a>
      </li>
    </ul>
  
  </nav>
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
       <div class="user-panel mt-3 pb-3 mb-3 d-flex">


      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="projects.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Home
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="products.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Product
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="supplier.php" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Supplier
              </p>
            </a>
            
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Chart
              </p>
            </a>
          </li> 
</ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 >Supplier List</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
      <table class="table table-bordered text-center">
 <button onclick="location.href='createSupp.php'"type="button" class="btn btn-block btn-primary" style="width:150px">Add Supplier</button>
</table>
    </section>
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
                          Supplier ID
                      </th>
                      <th style="width: 20%">
                          Name
                      </th>
                      <th style="width: 20%">
                           Phone Number
                      </th>
                      <th>
                          Email
                      </th>
                      <th style="width: 20%">
                          Address
                      </th>
            
                  </tr>
              </thead>
              <tbody>
                  <tr>
                  <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM SUPPLIER";
                    //if($result = mysqli_query($link, $sql)){
                    if ($result = $link->query($sql)) {
                        //if(mysqli_num_rows($result) > 0){
                            if($result->fetchColumn()>0){
                                //while($row = mysqli_fetch_array($result)){
                                foreach ($link->query($sql) as $row) {
                                    echo "<tr>";
                                        echo "<td>" . $row['SUPPID'] . "</td>";
                                        echo "<td>" . $row['SUPPNAME'] . "</td>";
                                        echo "<td>" . $row['SUPPPHONE'] . "</td>";
                                        echo "<td>" . $row['SUPPEMAIL'] . "</td>";
                                        echo "<td>" . $row['SUPPADDRESS'] . "</td>";
                        echo "<td><a href='updateSupplier.php?id=". $row['SUPPID']."' title='Update Record' data-toggle='tooltip'>
                              <i class='fas fa-pencil-alt'>
                              </i>
                              Update
                          </a>";
                         echo "<a href='deleteSupp.php?id=". $row['SUPPID'] ."' title='Delete Record' data-toggle='tooltip'>
                              <i class='fas fa-trash'>
                              </i>
                              Delete
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0-rc
    </div>
    <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
