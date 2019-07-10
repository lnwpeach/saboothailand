<?php
	include "connect.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<title>ข้อมูลลูกค้า</title>
</head>
<script type="text/javascript">
	function editCust(n) {
		var chk = document.edit.chk.value;

		if(n != chk) {
			if(chk != "") {
				var p1 = "p1" + chk;
				var p2 = "p2" + chk;
				var p3 = "p3" + chk;
				var p4 = "p4" + chk;
				document.getElementById(p1).innerHTML = document.edit.v1.value;
				document.getElementById(p2).innerHTML = document.edit.v2.value;
				document.getElementById(p3).innerHTML = document.edit.v3.value;
				document.getElementById(p4).innerHTML = document.edit.v4.value;
			}
			var p1 = "p1" + n;
			var p2 = "p2" + n;
			var p3 = "p3" + n;
			var p4 = "p4" + n;
			var cust_id = document.getElementById(p1).innerHTML;
			var cust_name = document.getElementById(p2).innerHTML;
			var cust_lname = document.getElementById(p3).innerHTML;
			var phone = document.getElementById(p4).innerHTML;
			document.getElementById(p1).innerHTML = "<input name='ncust_id' type='text' size='12' value='"+cust_id.trim()+"' maxlength='6' required>";
			document.getElementById(p2).innerHTML = "<input name='cust_name' type='text' size='20' value='"+cust_name.trim()+"' required>";
			document.getElementById(p3).innerHTML = "<input name='cust_lname' type='text' size='22' value='"+cust_lname.trim()+"' required>";
			document.getElementById(p4).innerHTML = "<input name='phone' type='text' size='15' value='"+phone.trim()+"' maxlength='10' required>";
			document.edit.chk.value = n;
			document.edit.v1.value = cust_id;
			document.edit.v2.value = cust_name;
			document.edit.v3.value = cust_lname;
			document.edit.v4.value = phone;
		}
		else {
			if(chk != "") {
				var p1 = "p1" + chk;
				var p2 = "p2" + chk;
				var p3 = "p3" + chk;
				var p4 = "p4" + chk;
				document.getElementById(p1).innerHTML = document.edit.v1.value;
				document.getElementById(p2).innerHTML = document.edit.v2.value;
				document.getElementById(p3).innerHTML = document.edit.v3.value;
				document.getElementById(p4).innerHTML = document.edit.v4.value;
				document.edit.chk.value = "";
			}
		}
	}
</script>

<body>
<div class="content">
<?php
	include "menu_sale.php";
?>
<div class="main">
	<?php
	$sql = "select * from customer";
	$query = mysqli_query($conn, $sql);
	$rs = mysqli_fetch_array($query);

	if($rs[0] == null) {
		echo "<h3 style='margin-left: 10%;color: red'>ไม่มีข้อมูล</h3>";
	}
	?>
  <h2>ข้อมูลลูกค้า</h2>
	<form action="sale_add_cust.php" method="post">
		<table width="700" border="1" align="center" cellpadding="2" cellspacing="0" id="table">
	  <tr>
	  <th width="100" height="35">รหัสลูกค้า</th>
		<th width="190" height="35">ชื่อลูกค้า</th>
		<th width="210" height="35">นามสกุล</th>
	  <th width="130" height="35">เบอร์โทร</th>
	  </tr>
	  <tr>
	  	<td height='30'><input name='cust_id' type='text' size='15' maxlength="6" required></td>
			<td height='30'><input name='cust_name' type='text' size='25' required></td>
			<td height='30'><input name='cust_lname' type='text' size='25' required></td>
			<td height='30'><input name='phone' type='text' maxlength='10' required></td>
	  </tr>
	  </table>
		<br>
	<input class="btn btn-primary" style='margin-left: 25%;margin-bottom: 10px' type='submit' value='เพิ่มลูกค้า'>
	&nbsp;&nbsp;
	<?php
	if(@$_SESSION['addchk'] == 1) {
		echo "<span style='color: red'>รหัสลูกค้าซ้ำ ไม่สามารถเพิ่มลูกค้าได้</span>";
		unset($_SESSION['addchk']);
	}
	?>
	</form>

	<form name='edit' action="sale_edit_cust.php" method="post">
		<?php
		if(@$_SESSION['editchk'] == 1) {
			echo "<span style='color: red;margin-left: 23%;'>รหัสลูกค้าซ้ำ ไม่สามารถแก้ไขข้อมูลลูกค้าได้</span><br>";
			unset($_SESSION['editchk']);
		}
		?>
  <table width="800" border="1" align="center" cellpadding="2" cellspacing="0" id="table">
  <tr>
  <th width="60" height="35">ลำดับ</th>
  <th width="120" height="35">รหัสลูกค้า</th>
	<th width="130" height="35">ชื่อลูกค้า</th>
	<th width="150" height="35">นามสกุล</th>
  <th width="130" height="35">เบอร์โทร</th>
	<th width="70" height="35">แก้ไข</th>
  </tr>
  <?php
	$num = 1;
	$sel = 0;
	while($rs = mysqli_fetch_array($query)) {
		echo "<tr>";
		echo "<td height='25' align='center'>$num</td>";
		echo "<td height='25' align='center' id='p1$num'>$rs[0]</td>";
		echo "<td height='25' align='left' id='p2$num'> $rs[1]</td>";
		echo "<td height='25' align='left' id='p3$num'> $rs[2]</td>";
		echo "<td height='25' align='center' id='p4$num'>$rs[3]</td>";
		echo "<td height='25' align='center'><a style='cursor: pointer' onclick='editCust($num)'><img src='images/edit-icon.png' width='25'></a>";
		echo "</td>";
		echo "</tr>";
		$num++;
	}
  ?>
  </table>
	<input type="submit" readonly hidden>
	<input type="hidden" name='chk' readonly>
	<input type="hidden" name='v1' readonly>
	<input type="hidden" name='v2' readonly>
	<input type="hidden" name='v3' readonly>
	<input type="hidden" name='v4' readonly>
</form>
  <br /><br />
</div>
<?php
	include "footer.php";
?>
</div>
</body>
</html>
