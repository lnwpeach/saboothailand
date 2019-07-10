<?php
	include "connect.php";

	$sql = "update customer set cust_id = '".$_POST['ncust_id']."', cust_name = '".$_POST['cust_name']."', ";
	$sql .= "cust_lname = '".$_POST['cust_lname']."', phone = '".$_POST['phone']."' where cust_id = '".$_POST['v1']."'";
	$query = mysqli_query($conn, $sql);

	if($query) {
		oci_commit();
		header("location:sale_cust.php");
	}
	else {
		mysqli_rollback();
		$_SESSION['editchk'] = 1;
		header("location:sale_cust.php");
	}
?>
