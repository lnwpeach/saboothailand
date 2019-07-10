<?php
	include "connect.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<title>รายการจองสินค้า</title>
</head>

<body>
<div class="content">
<?php
	include "menu_sale.php";
?>
<div class="main">
  <h2>รายการจองสินค้า</h2>
	<form name="form1" method="get" action="">
  	<table width="600" border="0" align="center" cellpadding='7'>
  	  <tr align='center'>
  	    <td>
					สถานะ &nbsp;&nbsp;&nbsp;<select name="status" onchange="document.form1.submit()">
						<option value="1" <?php if(@$_GET['status'] == 1) echo "selected";?>>รอชำระเงิน</option>
						<option value="2" <?php if(@$_GET['status'] == 2) echo "selected";?>>ชำระเงินแล้ว</option>
						<option value="3" <?php if(@$_GET['status'] == 3) echo "selected";?>>ทั้งหมด</option>
					</select>  &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
  	    	เลขที่ใบจองสินค้า &nbsp;&nbsp;&nbsp; <input name="reserve_id" type="search" value='<?php if(isset($_GET['reserve_id'])) echo $_GET['reserve_id'];?>' maxlength="7">
          &nbsp;&nbsp;&nbsp; <input type="submit" value="ค้นหา" class="btn btn-success" />
  				<input name="search" type="hidden" value="1" />
  	    </td>
  	  </tr>
    </table>
  </form>
	<?php
	$sql = "select r.reserve_id, c.cust_name, c.cust_lname, r.reserve_date, r.reserve_time, r.status from reserve r ";
	$sql .= "join customer c on r.cust_id = c.cust_id where r.status = 'รอชำระเงิน' order by r.reserve_id desc";
	if(@$_GET['reserve_id'] != "") {
		$sql = "select r.reserve_id, c.cust_name, c.cust_lname, r.reserve_date, r.reserve_time, r.status from reserve r ";
		$sql .= "join customer c on r.cust_id = c.cust_id where r.reserve_id = '".$_GET['reserve_id']."' order by r.reserve_id desc";
	}
	else if(@$_GET['status'] == 1) {
		$sql = "select r.reserve_id, c.cust_name, c.cust_lname, r.reserve_date, r.reserve_time, r.status from reserve r ";
		$sql .= "join customer c on r.cust_id = c.cust_id where r.status = 'รอชำระเงิน' order by r.reserve_id desc";
	}
	else if(@$_GET['status'] == 2) {
		$sql = "select r.reserve_id, c.cust_name, c.cust_lname, r.reserve_date, r.reserve_time, r.status from reserve r ";
		$sql .= "join customer c on r.cust_id = c.cust_id where r.status = 'ชำระเงินแล้ว' order by r.reserve_id desc";
	}
	else if(@$_GET['status'] == 3) {
		$sql = "select r.reserve_id, c.cust_name, c.cust_lname, r.reserve_date, r.reserve_time, r.status from reserve r ";
		$sql .= "join customer c on r.cust_id = c.cust_id order by r.reserve_id desc";
	}
	$query = mysqli_query($conn, $sql);
	$rs = mysqli_fetch_array($query);

  if($rs[0] == null) {
    echo "<h3 style='margin-left: 10%;color: red'>ไม่มีข้อมูล</h3>";
  }
  else {
  ?>
  <table width="800" border="1" align="center" cellpadding="2" cellspacing="0" id="table">
  <tr>
  <th width="60" height="35">ลำดับ</th>
  <th width="100" height="35">เลขที่ใบจองสินค้า</th>
	<th width="280" height="35">ชื่อลูกค้า</th>
  <th width="100" height="35">วันที่</th>
  <th width="80" height="35">เวลา</th>
  <th width="100" height="35">สถานะ</th>
  <th width="80" height="35">ดูข้อมูล</th>
  </tr>
  <?php
	$num = 1;
	while($rs = mysqli_fetch_array($query)) {
		echo "<tr>";
		echo "<td height='25' align='center'>$num</td>";
		echo "<td height='25' align='center'>$rs[0]</td>";
		echo "<td height='25' align='left'>$rs[1] $rs[2]</td>";
		echo "<td height='25' align='center'>$rs[3]</td>";
		echo "<td height='25' align='center'>$rs[4]</td>";
		echo "<td height='25' align='center'>$rs[5]</td>";
		echo "<td height='25' align='center'><a href='sale_info_reserve.php?reserve_id=$rs[0]'><img src='images/search1.png' width='25'></a></td>";
		echo "</tr>";
		$num++;
	}
  ?>


	<tr>
  </table>
	<?php
	}
	?>
  <br />
</div>
<?php
	include "footer.php";
?>
</div>
</body>
</html>
