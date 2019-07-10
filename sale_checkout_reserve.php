<?php
	include "connect.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<title>ใบจองสินค้า</title>
</head>

<body>
<div class="content">
<?php
	include "menu_sale.php";

	$sql = "select r.reserve_id, r.reserve_date, r.reserve_time, c.cust_name, c.cust_lname, r.status from reserve r ";
	$sql .= "join customer c on r.cust_id = c.cust_id where reserve_id = '".$_GET["reserve_id"]."'";
	$query = mysqli_query($conn, $sql);
	$rs = mysqli_fetch_array($query);
?>
<div class="main">
	<h2>ข้อมูลการจองสินค้า</h2>
	<br>
<table width="700" border="1" align="center" cellpadding="2" cellspacing="0">
<tr>
<th colspan="5" align="center">เลขที่ใบจองสินค้า <?php echo $rs["RESERVE_ID"];?></th>
</tr>
<tr>
<th colspan="5" align="center">วันที่ <?php echo $rs["RESERVE_DATE"]?>&nbsp;&nbsp; เวลา <?php echo $rs["RESERVE_TIME"];?></th>
</tr>
<tr>
<th colspan="5" align="center">ชื่อลูกค้า <?php echo $rs["CUST_NAME"]." ".$rs["CUST_LNAME"]?>
&nbsp;&nbsp;&nbsp;&nbsp; สถานะ <?php echo $rs['STATUS'];?></th>
</tr>
<tr>
<th align="center">รหัสสินค้า</th>
<th align="center">ชื่อสินค้า</th>
<th align="center">ราคา (บาท)</th>
<th align="center">จำนวน (หน่วย)</th>
<th align="center">รวม (บาท)</th>
</tr>
<?php
	$sql2 = "select p.pro_id, p.pro_name, p.pro_price, rd.pro_reserve_qty, (rd.pro_reserve_qty * p.pro_price) as total from reserve_detail rd join ";
	$sql2 .= "product p on rd.pro_id = p.pro_id where rd.reserve_id = '".$_GET["reserve_id"]."'";
	$query2 = mysqli_query($conn, $sql2);
	$total = 0;
	while($rs2 = mysqli_fetch_array($query2))
	{
		echo "<tr>";
		echo "<td align='center'>".$rs2['PRO_ID']."</td>";
		echo "<td align='left'> ".$rs2['PRO_NAME']."</td>";
		echo "<td align='right'>".number_format($rs2['PRO_PRICE'],2)."</td>";
		echo "<td align='center'>".$rs2['PRO_RESERVE_QTY']."</td>";
		echo "<td align='right'>".number_format($rs2['TOTAL'],2)."</td>";
		echo "</tr>";
		$total += $rs2['PRO_PRICE'] * $rs2['PRO_RESERVE_QTY'];
	}
?>
<tr>
<th colspan="5" align="right">ยอดรวม <?php echo number_format($total,2);?> บาท</th>
</tr>
</table>
<br /><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="sale_pro_reserve.php">กลับไปหน้าจองสินค้า</a>
</div>
<?php
	include "footer.php";
?>
</div>
</body>
</html>
