<?php
	ob_start();
	include "connect.php";

	if(isset($_GET['ty']) && $_GET['ty'] == 1)
		$h = "location:sale_pro_reserve.php";
	else
		$h = "location:sale_pro_sell.php";

	if($_GET["txtkeyword"] == "")
	{
		header($h);
	}
	else
	{
		$sql = "select * from product where pro_id = '".$_GET["txtkeyword"]."'";
		$query = mysqli_query($conn, $sql);
		$rs = mysqli_fetch_array($query);
		if($_GET["txtkeyword"] == $rs["pro_id"])
		{
			if(!isset($_SESSION["intline"]))
			{
				$_SESSION["intline"] = 0;
				$_SESSION["strpro_id"][0] = $rs["pro_id"];
				$_SESSION["strqty"][0] = 1;
				$_SESSION["total"][0] = 0;
				header($h);
			}
			else
			{
				$key = array_search($_GET["txtkeyword"], $_SESSION["strpro_id"]);
				if((string)$key != "")
				{
					$_SESSION["strqty"][$key] += 1;
					header($h);
				}
				else
				{
					$_SESSION["intline"] += 1;
					$intnewline = $_SESSION["intline"];
					$_SESSION["strpro_id"][$intnewline] = $rs["pro_id"];
					$_SESSION["strqty"][$intnewline] = 1;
					header($h);
				}
			}
		}
		else
		{
			header($h);
		}
	}
	ob_end_flush();
?>
