<?php
	include "connect.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<title>สรุปยอดขายรายวัน</title>
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
	$date = date('j ').$meng[date('n')].date(' Y');
?>
<div class="main">
	<h2>สรุปยอดขายรายวัน</h2>
	<form name="form1" method="post" action="">
	<table width="420" border="0" align="center" cellpadding='7'>
	  <tr align='center'>
	    <td>
	    	วันที่ &nbsp;&nbsp;&nbsp; <input name="date" type="date" value='<?php if(isset($_POST['date'])) echo $_POST['date']; else echo date('Y-m-d');?>'>
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
				<input type="submit" value="ค้นหา" class="btn btn-success"/>
				<input name="search" type="hidden" value="1" />
			</td>
		</tr>
	</table>
	</form>
<?php
	$message = "สรุปยอดขายวันที่ ".date('j ').$mthai[date('n')].date(' Y');
	$qemp = "";
	if(@$_POST['search'] == 1) {
		$d = intval(substr($_POST['date'], 8, 2));
		$m = intval(substr($_POST['date'], 5, 2));
		$y = intval(substr($_POST['date'], 0, 4));
		$date = $d." ".$meng[$m]." ".$y;
		$message = "สรุปยอดขายวันที่ ".$d." ".$mthai[$m]." ".$y;
		if($_POST['emp_id']) {
			$qemp = "and emp_id = '".$_POST['emp_id']."'";
			$message .= " รหัสพนักงาน ".$_POST['emp_id'];
		}
	}

	$sql = "select sd.pro_id, sum(sd.pro_sell_qty) as qty, sum(sd.pro_sell_qty * p.pro_price) as sum from sale_detail sd join ";
	$sql .= "product p on sd.pro_id = p.pro_id join sale s on sd.sale_id = s.sale_id where s.sale_date = '$date' $qemp group by sd.pro_id order by sd.pro_id";
	$query = mysqli_query($conn, $sql);
	$rs = mysqli_fetch_array($query);
	$total = 0;
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
<tr>
<th height="40" colspan="6" align="right">ยอดรวม <?php echo number_format($sumtotal,2);?> บาท</th>
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
