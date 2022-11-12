<?php
	require_once 'config.php';

	//Start session
	session_start();
	
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['user']) || (trim($_SESSION['user']) == '')) {
		header("location: staffLogin.php");
		exit();
	}

	$session_id  = $_SESSION['user'];

	$query = $link->prepare("SELECT * FROM STAFF WHERE STAFFID = ?");
	$query->execute(array($session_id));
	$row = $query->fetch();

	$session_cashier_name = $row['STAFFNAME'];

?>