<?php
	include "connect.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<title>ข้อมูลใบจองสินค้า</title>
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
<th colspan="5" align="center">เลขที่ใบจองสินค้า <?php echo $_GET['reserve_id'];?></th>
</tr>
<tr>
<th colspan="5" align="center">วันที่ <?php echo $rs["RESERVE_DATE"]?>&nbsp;&nbsp; เวลา <?php echo $rs["RESERVE_TIME"];?></th>
</tr>
<tr>
<th colspan="5" align="center">ชื่อลูกค้า <?php echo $rs["CUST_NAME"]." ".$rs["CUST_LNAME"]?>
&nbsp;&nbsp;&nbsp; สถานะ <?php echo $rs['STATUS'];?></th>
</tr>
<tr>
<th align="center">รหัสสินค้า</th>
<th align="center">ชื่อสินค้า</th>
<th align="center">ราคา (บาท)</th>
<th align="center">จำนวน (หน่วย)</th>
<th align="center">รวม (บาท)</th>
</tr>
<?php
	$sql2 = "select p.pro_id, p.pro_name, p.pro_price, sd.pro_reserve_qty, (sd.pro_reserve_qty * p.pro_price) as total from reserve_detail sd join ";
	$sql2 .= "product p on sd.pro_id = p.pro_id where sd.reserve_id = '".$_GET["reserve_id"]."'";
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
<?php
	$sql = "select max(sale_id)+1 as max from sale";
	$query = mysqli_query($conn, $sql);

	$new_sale_id = mysqli_fetch_array($query);
	if($new_sale_id["MAX"] == "")
	{
		$sale_id = "0000001";
	}
	else
	{
		$sale_id = sprintf("%07d", $new_sale_id["MAX"]);
	}

	if($rs['STATUS'] == 'รอชำระเงิน') {
?>

<script>
function fncCal() {
	if(parseFloat(document.form1.money.value) < parseFloat(document.form1.bill_total.value))
	{
		alert("รับเงินมาไม่เพียงพอ");
		document.form1.money.value = "";
		event.preventDefault();
	}
	else if(document.form1.money.value == "")
	{
		alert("กรุณากรอกจำนวนเงิน");
		event.preventDefault();
	}
	else
	{
		document.form1.change.value = parseFloat(document.form1.money.value) - parseFloat(document.form1.bill_total.value)
	}
}
</script>

<form name="form1" method="post" action="sale_order_update_res.php" onsubmit="fncCal()">
<input name="sale_id" type="hidden" value="<?php echo $sale_id;?>" />
<input name="reserve_id" type="hidden" value="<?php echo $_GET['reserve_id'];?>" />
<input name="bill_total" type="hidden" value="<?php echo $total?>">
<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href='#' onclick="history.back()">ย้อนกลับ</a>
<br /><br />
<table width="400" border="0" cellpadding="7">
  <tr>
    <td width="79" align="right">เงินสด </td>
    <td width="311">&nbsp;&nbsp;&nbsp;<input name="money" type="text" autocomplete="off"  />
      <input name="change" type="hidden" readonly="readonly" /></td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="left">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="ชำระเงิน" class="btn btn-primary"/></td>
    </tr>
</table>
<br />
</form>
<?php
		}
?>
</div>
<?php
	include "footer.php";
?>
</div>
</body>
</html>
