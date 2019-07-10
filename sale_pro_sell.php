<?php
	include "connect.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<title>ขายสินค้า</title>
</head>
<script>
function setFocus() {
	frmsearch.txtkeyword.focus();
}
</script>
<body onload="setFocus()">
<div class="content">
<?php
	include "menu_sale.php";
?>
<div class="main">
	<h2>ขายสินค้า</h2>
<form name="frmsearch" method="get" action="sale_order.php">
<table width="500" border="0" align="center">
  <tr>
    <td width="238">
    กรอกรหัสสินค้า &nbsp;&nbsp;<input name="txtkeyword" type="text" autocomplete="off" maxlength="6"/>
&nbsp;&nbsp;<input type="submit" value="ค้นหาสินค้า" />
    </td>
  </tr>
</table>
</form>
<br />

<form name="frmupdate" method="post" action="sale_update_qty.php">
<table width="80%" border="1" align="center" cellpadding="2" cellspacing="0" id="table">
<tr>
<th width="150" align="center">รหัสสินค้า</th>
<th width="420" align="center">ชื่อสินค้า</th>
<th width="110" align="center">ราคา (บาท)</th>
<th width="60" align="center">จำนวน (หน่วย)</th>
<th width="110" align="center">รวม (บาท)</th>
<th align="center">ยกเลิก</th>
</tr>
<?php
	$sumtotal = 0;
	for($i=0;$i<=(int)@$_SESSION["intline"];$i++)
	{
		if(isset($_SESSION["strpro_id"][$i]))
		{
			$sql = "select * from product where PRO_ID = '".$_SESSION["strpro_id"][$i]."'";
			$query = mysqli_query($conn, $sql);
			$rs = mysqli_fetch_array($query);
			$_SESSION["total"][$i] = $rs["PRO_PRICE"] * $_SESSION["strqty"][$i];
			$sumtotal += $_SESSION["total"][$i];

			echo "<tr>";
			echo "<td align='center'>".$_SESSION['strpro_id'][$i]."</td>";
			echo "<td align='left'> ".$rs['PRO_NAME']."</td>";
			echo "<td align='right'>".number_format($rs['PRO_PRICE'],2)."</td>";
			echo "<td align='center'>";
			echo "<input name='txtqty$i' type='text' value='".$_SESSION['strqty'][$i]."' size='4' style='text-align: center;' autocomplete='off'/>";
			echo "<input type='submit' hidden /></td>";
			echo "<td align='right'>".number_format($_SESSION['total'][$i],2)."</td>";
			echo "<td align='center'><a href='sale_delete_order.php?line=$i'>ยกเลิก</a></td>";
			echo "</tr>";
		}
	}
?>
</table>
</form>

<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
ยอดรวม <?php echo number_format($sumtotal,2);?> บาท
<br /><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="sale_clear.php">ยกเลิกทั้งหมด</a>
<br /><br />

<?php
	$sql = "select max(sale_id)+1 as max from sale";
	$query = mysqli_query($conn, $sql);
	$new_sale_id = mysqli_fetch_array($query);
	if(@$new_sale_id["MAX"] == null)
	{
		$sale_id = "0000001";
	}
	else
	{
		$sale_id = sprintf("%07d", $new_sale_id["MAX"]);
	}
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

<form name="form1" method="post" action="sale_order_update.php" onsubmit="fncCal()">
<input name="sale_id" type="hidden" value="<?php echo $sale_id;?>" />
<input name="bill_total" type="hidden" value="<?php echo $sumtotal?>">
<br />

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
</div>
<?php
	include "footer.php";
?>
</div>
</body>
</html>
