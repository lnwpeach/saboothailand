<?php
	session_start();
	$_SESSION["intline"] = null;
	$_SESSION["strpro_id"] = null;
	$_SESSION["strqty"] = null;
	$_SESSION["total"] = null;
	if($_GET['ty'] == 1)
		header("location:sale_pro_reserve.php");
	else
		header("location:sale_pro_sell.php");
?>
