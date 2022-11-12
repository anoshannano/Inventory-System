<?php
session_start();
include('config.php');

$purchaseNo = $_POST['invoice'];
$qty = $_POST['qty'];
$prodcode = $_POST['product'];

$sql = "SELECT PRODPRICE FROM PRODUCT WHERE PRODCODE = $prodcode";
         if ($result = $link->query($sql)) {
                if($result->fetchColumn()>0){
             foreach ($link->query($sql) as $row) {
                                  $total = $total+ $row['PRODPRICE'];
                              }
                          }
                        }
                      else { ;}

 ?>