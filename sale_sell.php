<?php
	include "connect.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<title>รายการขายสินค้า</title>
</head>

<body>
<div class="content">
<?php
	include "menu_sale.php";
?>
<div class="main">
  <h2>รายการขายสินค้า</h2>
	<form name="form1" method="get" action="">
  	<table width="600" border="0" align="center" cellpadding='7'>
			<tr align='center'>
  	    <td>
  	    	วันที่ &nbsp;&nbsp;&nbsp; <input name="stdate" type="date" value='<?php if(isset($_GET['stdate'])) echo $_GET['stdate']; else echo date('Y-m-d', strtotime("-1 week"));?>'>
					&nbsp;&nbsp;
					ถึง &nbsp;&nbsp;<input name="eddate" type="date" value='<?php if(isset($_GET['eddate'])) echo $_GET['eddate']; else echo date('Y-m-d');?>'>
  	    </td>
  	  </tr>
  	  <tr align='center'>
  	    <td>
  	    	เลขที่ใบเสร็จ &nbsp;&nbsp; <input name="sale_id" type="search" value='<?php if(isset($_GET['sale_id'])) echo $_GET['sale_id'];?>' maxlength='7'>
          &nbsp;&nbsp;&nbsp; <input type="submit" value="ค้นหา" class="btn btn-success" />
  				<input name="search" type="hidden" value="1" />
  	    </td>
  	  </tr>
    </table>
  </form>
	<?php
	$sql = "select * from sale where sale_date between '".date('Y-m-d', strtotime("-1 week"))."' and '".date('Y-m-d')."' order by sale_date desc, sale_time desc";
	if(@$_GET['sale_id'] != "") {
		$sql = "select * from sale where sale_id = '".$_GET['sale_id']."' order by sale_date desc, sale_time desc";
	}
	else if(isset($_GET['stdate']) && isset($_GET['eddate'])) {
		$sql = "select * from sale where sale_date between '".$_GET['stdate']."' and '".$_GET['eddate']."' order by sale_date desc, sale_time desc";
	}
	$query = mysqli_query($conn, $sql);

  if(mysqli_num_rows($query) == 0) {
    echo "<h3 style='margin-left: 10%;color: red'>ไม่มีข้อมูล</h3>";
  }
  else {
  ?>
  <table width="600" border="1" align="center" cellpadding="2" cellspacing="0" id="table">
  <tr>
  <th width="60" height="35">ลำดับ</th>
  <th width="100" height="35">เลขที่ใบเสร็จ</th>
	<th width="100" height="35">วันที่</th>
  <th width="80" height="35">เวลา</th>
	<th width="120" height="35">รหัสพนักงาน</th>
  <th width="50" height="35">ดูข้อมูล</th>
  </tr>
  <?php
	$num = 1;
	while($rs = mysqli_fetch_array($query)) {
		echo "<tr>";
		echo "<td height='25' align='center'>$num</td>";
		echo "<td height='25' align='center'>$rs[0]</td>";
		echo "<td height='25' align='center'>$rs[1]</td>";
		echo "<td height='25' align='center'>$rs[2]</td>";
		echo "<td height='25' align='center'>$rs[3]</td>";
		echo "<td height='25' align='center'><a href='sale_info_sell.php?sale_id=$rs[0]'><img src='images/search1.png' width='25'></a></td>";
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
