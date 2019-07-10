<?php
	session_start();
	ob_start();
	date_default_timezone_set("asia/bangkok");
	//$db = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 202.44.47.56)(PORT = 1521)))(CONNECT_DATA=(SID=oraclesv0)))";
	//$conn = @oci_connect("6006021410148","6006021410148",$db,"AL32UTF8") or die("Failed to connect Oracle Database");
	$conn = mysqli_connect("localhost","root","12345678","saboothailand");
	mysqli_query($conn, "set character set utf8");

	$meng[1] = "january";
	$meng[2] = "february";
	$meng[3] = "march";
	$meng[4] = "april";
	$meng[5] = "may";
	$meng[6] = "june";
	$meng[7] = "july";
	$meng[8] = "august";
	$meng[9] = "september";
	$meng[10] = "october";
	$meng[11] = "november";
	$meng[12] = "december";

	if(!isset($_SESSION['emp_id'])) {
		$_SESSION['chklogin'] = 2;
		header("location:index.php");
	}
?>

<div class="connect">
<div id="home">
<a href="sale_pro_sell.php"><img src="pictures/home_connect1.gif" width="170" /></a>
</div>
<div id="info-mem">
<ul>
<li>สวัสดีคุณ <?php echo $_SESSION['emp_name']." ".$_SESSION['emp_lname'] ?></li>
<li><a href="logout.php">Logout</a></li>
</ul>
</div>
</div>

<br><br>
