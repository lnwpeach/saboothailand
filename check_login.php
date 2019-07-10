<?php
	include('connect.php');
	$sql = "select * from employee where emp_id = '".$_POST['username']."' and password = '".$_POST['password']."'";
	$query = mysqli_query($conn, $sql);
	$rs = mysqli_fetch_array($query);

	if(!$rs)
	{
		$_SESSION["chklogin"] = 1;
		header("location:index.php");
	}
	else
	{
		unset($_SESSION["chklogin"]);
		$_SESSION["emp_id"] = $rs["emp_id"];
		$_SESSION["emp_name"] = $rs["emp_name"];
		$_SESSION["emp_lname"] = $rs["emp_lname"];

		header("location:sale_pro_sell.php");
	}
?>
