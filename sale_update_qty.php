<?php
	session_start();
	ob_start();
	for($i=0;$i<=(int)$_SESSION["intline"];$i++)
	{
		if($_SESSION["strpro_id"][$i] != "")
		{
			if($_POST["txtqty".$i] == 0 || $_POST["txtqty".$i] == "")
			{
				$_SESSION["strpro_id"][$i] = "";
				$_SESSION["strqty"][$i] = "";
			}
			$_SESSION["strqty"][$i] = $_POST["txtqty".$i];
		}
	}
	if($_POST['ty'] == 1)
		header("location:sale_pro_reserve.php");
	else
  	header("location:sale_pro_sell.php");
?>
