<?php
	include "connect.php";

	$sql = "insert into customer values('".$_POST['cust_id']."', '".$_POST['cust_name']."', '".$_POST['cust_lname']."', '".$_POST['phone']."')";
	$query = mysqli_query($conn, $sql);

	if($query) {
		mysqli_commit();
		header("location:sale_cust.php");
	}
	else {
		mysqli_rollback();
		$_SESSION['addchk'] = 1;
		header("location:sale_cust.php");
	}
?>
