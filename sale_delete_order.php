<?php
	session_start();
	$line = $_GET["line"];
	$_SESSION["strpro_id"][$line] = null;
	$_SESSION["strqty"][$line] = null;
	if($_GET['ty'] == 1)
		header("location:sale_pro_reserve.php");
	else
		header("location:sale_pro_sell.php");
?>
