<?php
	include "connect.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<title>สรุปยอดขายย้อนหลัง</title>
</head>

<body>
<div class="content">
<?php
	include "menu_sale.php";

	$mthai[1] = "มกราคม";
	$mthai[2] = "กุมภาพันธ์";
	$mthai[3] = "มีนาคม";
	$mthai[4] = "เมษายน";
	$mthai[5] = "พฤษภาคม";
	$mthai[6] = "มิถุนายน";
	$mthai[7] = "กรกฎาคม";
	$mthai[8] = "สิงหาคม";
	$mthai[9] = "กันยายน";
	$mthai[10] = "ตุลาคม";
	$mthai[11] = "พฤศจิกายน";
	$mthai[12] = "ธันวาคม";
?>
<div class="main">
	<h2>สรุปยอดขายย้อนหลัง</h2>
<form name="form1" method="post" action="">
<table width="420" border="0" align="center" cellpadding='7'>
  <tr align='center'>
    <td>
    เดือน &nbsp;&nbsp;<select name="month">
<option value="">ทั้งหมด</option>
<?php
	$m = 1;
	for($i=1;$i<=12;$i++)
	{
		$sel = "";
		if($_POST['month'] == $i)
			$sel = "selected";
		else if(!isset($_POST['month']) && date('n') == $i)
			$sel = "selected";
		echo "<option value=\"{$i}\" $sel>{$mthai[$m]}</option>";
		$m += 1;
	}
?>
</select>
&nbsp;&nbsp;
ปี &nbsp;&nbsp;<select name="year">
<?php
	echo "<option value='".date('Y')."'>".date('Y')."</option>";
	for($i=date('Y')-1;$i>=date('Y')-5;$i--)
	{
		$sel = "";
		if($_POST['year'] == $i)
			$sel = "selected";
		echo "<option value='$i' $sel>$i</option>";
	}
?>
</select>
    </td>
  </tr>
	<tr align='center'>
		<td>
			พนักงาน &nbsp;&nbsp; <select name="emp_id">
				<option value="">ทั้งหมด</option>
				<?php
					$sql = "select emp_id, emp_name, emp_lname from employee order by emp_id";
					$query = mysqli_query($conn, $sql);
					while($rs = mysqli_fetch_array($query)) {
						$sel = "";
						if($_POST['emp_id'] == $rs[0])
							$sel = "selected";
						echo "<option value='$rs[0]' $sel>".$rs[1]." ".$rs[2]."</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr align='center'>
		<td>
			<input type="submit" value="ค้นหา" class="btn btn-success" />
			<input name="search" type="hidden" value="1" />
		</td>
	</tr>
</table>
</form>

<?php
	$m = @$_POST["month"];
	$y = @$_POST["year"];
	if($m == 4 || $m == 6 || $m == 9 || $m == 11)
		$day = 30;
	else if($m == 2)
		$day = 28;
	else
		$day = 31;
	$qemp = "";

	if(isset($_POST['search'])) {
		$emp_id = $_POST['emp_id'];

		if($m) {
			$stdate = "1 ".$meng[$m]." ".$y;
			$eddate = $day." ".$meng[$m]." ".$y;
			$message = "สรุปยอดขาย เดือน ".$mthai[sprintf("%0d",$m)]." ปี ".$y;
		}
		else {
			$stdate = "1 ".$meng[1]." ".$y;
			$eddate = $day." ".$meng[12]." ".$y;
			$message = "สรุปยอดขาย ปี ".$y;
		}

		if($emp_id) {
			$qemp = "and emp_id = '$emp_id'";
			$message .= " รหัสพนักงาน ".$emp_id;
		}
	}
	else {
		$stdate = "1 ".$meng[date('n')]." ".date('Y');
		$eddate = $day." ".$meng[date('n')]." ".date('Y');
		$message = "สรุปยอดขาย เดือน ".$mthai[date('n')]." ปี ".date('Y');
	}

		$sql = "select sd.pro_id, sum(sd.pro_sell_qty) as qty, sum(sd.pro_sell_qty * p.pro_price) as sum from sale_detail sd join ";
		$sql .= "product p on sd.pro_id = p.pro_id join sale s on sd.sale_id = s.sale_id where s.sale_date between '$stdate' and '$eddate' $qemp group by sd.pro_id order by sd.pro_id";
		$query = mysqli_query($conn, $sql);
		$rs = mysqli_fetch_array($query);
		if($rs[0] == null)
		{
			echo "<h3 style='margin-left: 10%;color: red'>ไม่มีข้อมูล</h3>";
		}
		else
		{
?>
<table width="900" border="1" align="center" cellpadding="2" cellspacing="0" id="table">
<tr>
<th height="40" colspan = "6" align="center"><strong><?=$message?></strong></th>
</tr>
<tr>
<th width="60" align="center">ลำดับ</th>
<th width="120" align="center">รหัสสินค้า</th>
<th width="350" align="center">ชื่อสินค้า</th>
<th width="120" align="center">ราคา (บาท)</th>
<th width="80" align="center">จำนวน (หน่วย)</th>
<th width="120" align="center">รวม (บาท)</th>
</tr>
<?php
			$num2 = 0;
			$sumtotal = 0;
			while($rs = mysqli_fetch_array($query))
			{
				$sql2 = "select p.pro_name, p.pro_price from sale_detail sd join product p on sd.pro_id = p.pro_id where sd.pro_id = '".$rs["PRO_ID"]."'";
				$query2 = mysqli_query($conn, $sql2);
				$rs2 = mysqli_fetch_array($query2);
				$num2 += 1;
				$sumtotal += $rs["SUM"];
?>
<tr>
	<td align="center"><?php echo $num2;?></td>
	<td align="center"><?php echo $rs["PRO_ID"];?></td>
	<td align="left">&nbsp;<?php echo $rs2["PRO_NAME"];?></td>
	<td align="right"><?php echo number_format($rs2["PRO_PRICE"],2);?></td>
	<td align="center"><?php echo $rs["QTY"];?></td>
	<td align="right"><?php echo number_format($rs["SUM"],2);?></td>
</tr>
<?php
			}
?>
<tr align="right">
	<th height="40" colspan = "6">ยอดรวม <?php echo number_format($sumtotal,2);?> บาท</th>
</tr>

</table>
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
