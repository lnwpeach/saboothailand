<?php
	include "connect.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<title>ใบเสร็จ</title>
</head>

<body>
<div class="content">
<?php
	include "menu_sale.php";

	$sql = "select * from sale where sale_id = '".$_GET["sale_id"]."'";
	$query = mysqli_query($conn, $sql);
	$rs = mysqli_fetch_array($query);
?>
<div class="main">
	<h2>ข้อมูลการขายสินค้า</h2>
	<br>
<table width="700" border="1" align="center" cellpadding="2" cellspacing="0">
<tr>
<th colspan="5" align="center">เลขที่ใบเสร็จ <?php echo $rs["sale_id"];?></th>
</tr>
<tr>
<th colspan="5" align="center">วันที่ <?php echo $rs["sale_date"]?>&nbsp;&nbsp; เวลา <?php echo $rs["sale_time"];?></th>
</tr>
<tr>
<th align="center">รหัสสินค้า</th>
<th align="center">ชื่อสินค้า</th>
<th align="center">ราคา (บาท)</th>
<th align="center">จำนวน (หน่วย)</th>
<th align="center">รวม (บาท)</th>
</tr>
<?php
	$sql2 = "select p.pro_id, p.pro_name, p.pro_price, sd.pro_sell_qty, (sd.pro_sell_qty * p.pro_price) as total from sale_detail sd join ";
	$sql2 .= "product p on sd.pro_id = p.pro_id where sd.sale_id = '".$_GET["sale_id"]."'";
	$query2 = mysqli_query($conn, $sql2);
	$total = 0;
	while($rs2 = mysqli_fetch_array($query2))
	{
		echo "<tr>";
		echo "<td align='center'>".$rs2['pro_id']."</td>";
		echo "<td align='left'> ".$rs2['pro_name']."</td>";
		echo "<td align='right'>".number_format($rs2['pro_price'],2)."</td>";
		echo "<td align='center'>".$rs2['pro_sell_qty']."</td>";
		echo "<td align='right'>".number_format($rs2['total'],2)."</td>";
		echo "</tr>";
		$total += $rs2['pro_price'] * $rs2['pro_sell_qty'];
	}
?>
<tr>
<th colspan="5" align="center">ยอดรวม <?php echo number_format($total,2);?> บาท
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
เงินสด <?php echo number_format($_GET["money"],2);?> บาท
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
เงินทอน <?php echo number_format($_GET['change'],2);?> บาท</th>
</tr>
</table>
<br /><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="sale_pro_sell.php">กลับไปหน้าขายสินค้า</a>
</div>
<?php
	include "footer.php";
?>
</div>
</body>
</html>
