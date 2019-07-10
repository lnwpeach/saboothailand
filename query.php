<?php
	include "connect.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<title>Query</title>
</head>

<body>
<div class="content">
<?php
	include "menu_sale.php";

	$qsql[1] = "select s.sale_id, e.emp_name, e.emp_lname from sale s join employee e on(s.emp_id = e.emp_id) where sale_date = '9 may 2018'";
	$qsql[2] = "select distinct cust_name, cust_lname from customer c join reserve r on(c.cust_id = r.cust_id) where r.status = 'รอชำระเงิน'";
	$qsql[3] = "select p.pro_id, p.pro_name from \"6006021410172\".product p join sale_detail sd on(sd.pro_id = p.pro_id)
join sale s on(s.sale_id = sd.sale_id) where s.sale_date between '1 jan 2018' and '31 jan 2018'";
	$qsql[4] = "select distinct e.emp_name, p.pro_name from employee e join sale s on(e.emp_id = s.emp_id) join sale_detail sd on(s.sale_id = sd.sale_id)
join \"6006021410172\".product p on(sd.pro_id = p.pro_id) where s.sale_date > '1 april 2018'";
	$qsql[5] = "select sd.pro_id, sum(sd.pro_sell_qty) as qty from sale_detail sd join sale s on sd.sale_id = s.sale_id group by sd.pro_id order by sd.pro_id";
	$qsql[6] = "select count(sale_id) from sale";
	$qsql[7] = "select avg(pro_price) as avg from \"6006021410172\".product";
	$qsql[8] = "select pro_name from \"6006021410172\".product where pro_id in(select pro_id from sale_detail having(sum(pro_sell_qty) >
(select avg(pro_sell_qty) from sale_detail)) group by pro_id)";
	$qsql[9] = "select reserve_id, status from reserve where status = (select status from reserve where reserve_id = '0000010')";
	$qsql[10] = "select emp_name from employee where emp_id in(select emp_id from sale having count(emp_id) >
(select avg(count(emp_id)) from sale group by emp_id) group by emp_id)";
	$qsql[11] = "select pro_name from \"6006021410172\".product where pro_id in(select pro_id from sale_detail having(sum(pro_sell_qty) > 10) group by pro_id)";
	$qsql[12] = "select type_id, max(pro_qty) as max_pro_qty from \"6006021410172\".product group by type_id";
	$qsql[13] = "select * from emp_view";
	$qsql[14] = "select * from sumpro_view";
	$qsql[15] = "select emp_name from employee where emp_name like 'อ%'";
	$qsql[16] = "select distinct sale_id from sale_detail order by sale_id desc";
	$qsql[17] = "select pro_name from \"6006021410172\".product where pro_name like '%นม'";
	$qsql[18] = "select p.type_id, count(sd.pro_id) as qty from sale_detail sd join \"6006021410172\".product p on sd.pro_id = p.pro_id group by p.type_id order by p.type_id";
	$qsql[19] = "select count(cust_id) as Number_of_customer from reserve where status = 'รอชำระเงิน'";
	$qsql[20] = "select emp_name from employee where emp_id = (select emp_id from sale having(count(emp_id) =
(select max(count(emp_id)) from sale group by emp_id)) group by emp_id)";
?>
<div class="main">
  <h2>รายการ Query</h2>
	<form name="form1" method="get" action="">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    เลือก Query &nbsp;&nbsp;&nbsp;
    <select name='query' onchange="document.form1.submit()">
			<option value="">เลือก query</option>
      <option value="1" <?php echo @$_GET['query'] == 1 ? "selected" : ""; ?>>1. แสดงรหัสการขาย ชื่อพนักงาน และนามสกุลพนักงานที่ขายสินค้าวันที่ 9 พ.ค. 2018</option>
      <option value="2" <?php echo @$_GET['query'] == 2 ? "selected" : ""; ?>>2. แสดงชื่อลูกค้า และนามสกุลลูกค้าที่จองสินค้าและยังไม่ชำระเงิน</option>
      <option value="3" <?php echo @$_GET['query'] == 3 ? "selected" : ""; ?>>3. แสดงรหัสสินค้า และชื่อสินค้าที่ถูกขายในเดือนมกราคม ปี 2018</option>
      <option value="4" <?php echo @$_GET['query'] == 4 ? "selected" : ""; ?>>4. แสดงชื่อพนักงาน และชื่อสินค้ที่มีการขายสินค้าหลังวันที่ 1 เมษายน 2018</option>
      <option value="5" <?php echo @$_GET['query'] == 5 ? "selected" : ""; ?>>5. แสดงยอดขายของสินค้าแต่ละชิ้นว่าขายไปกี่ชิ้น</option>
      <option value="6" <?php echo @$_GET['query'] == 6 ? "selected" : ""; ?>>6. แสดงจำนวนการขายสินค้าท้้งหมด</option>
      <option value="7" <?php echo @$_GET['query'] == 7 ? "selected" : ""; ?>>7. แสดงราคาเฉลี่ยของสินค้าทั้งหมด</option>
      <option value="8" <?php echo @$_GET['query'] == 8 ? "selected" : ""; ?>>8. แสดงชื่อสินค้าที่ถูกจองที่มีจำนวนมากกว่าค่าเฉลี่ยของสินค้าที่ถูกจองทั้งหมด</option>
      <option value="9" <?php echo @$_GET['query'] == 9 ? "selected" : ""; ?>>9. แสดงรหัสการจอง และสถานะที่มีสถานะเดียวกับการจองรหัส 0000010</option>
      <option value="10" <?php echo @$_GET['query'] == 10 ? "selected" : ""; ?>>10. แสดงชื่อพนักงานที่มีจำนวนการขายสินค้าได้มากกว่าจำนวนการขายเฉลี่ยของพนักงานทั้งหมด</option>
			<option value="11" <?php echo @$_GET['query'] == 11 ? "selected" : ""; ?>>11. แสดงชื่อสินค้าที่ขายได้มากกว่า 10 ชิ้นขึ้นไป</option>
			<option value="12" <?php echo @$_GET['query'] == 12 ? "selected" : ""; ?>>12. แสดงรหัสประเภท และจำนวนสินค้าคงเหลือที่มากที่สุด (Max_Pro_Qty) ในแต่ละประเภท</option>
			<option value="13" <?php echo @$_GET['query'] == 13 ? "selected" : ""; ?>>13. แสดง view ที่เก็บรหัสพนักงานและชื่อพนักงาน</option>
			<option value="14" <?php echo @$_GET['query'] == 14 ? "selected" : ""; ?>>14. แสดง view ที่เก็บยอดขายของสินค้าแต่ละชิ้น</option>
			<option value="15" <?php echo @$_GET['query'] == 15 ? "selected" : ""; ?>>15. แสดงชื่อพนักงานที่มีตัวอักษรขึ้นต้นด้วย 'อ'</option>
			<option value="16" <?php echo @$_GET['query'] == 16 ? "selected" : ""; ?>>16. แสดงรหัสการขายในรายละเอียดการขายที่ไม่ซ้ากัน โดยเรียงลำดับจากมากไปน้อย</option>
			<option value="17" <?php echo @$_GET['query'] == 17 ? "selected" : ""; ?>>17. แสดงชื่อสินค้าที่ลงท้ายด้วยคำว่า 'นม'</option>
			<option value="18" <?php echo @$_GET['query'] == 18 ? "selected" : ""; ?>>18. แสดงรหัสประเภทสินค้าและจำนวนการขายสินค้าในแต่ละประเภท</option>
			<option value="19" <?php echo @$_GET['query'] == 19 ? "selected" : ""; ?>>19. แสดงจำนวนลูกค้าที่จองสินค้าและยังไม่ชำระเงิน</option>
			<option value="20" <?php echo @$_GET['query'] == 20 ? "selected" : ""; ?>>20. แสดงชื่อพนักงานที่มีการขายสินค้ามากที่สุด</option>
    </select>
  </form>
	<?php

	if(@$_GET['query'] != "") {
		for($i=1;$i<=20;$i++) {
			if($_GET['query'] == $i)
				$sql = $qsql[$i];
		}
		$parse = oci_parse($conn, $sql);
		oci_execute($parse, OCI_DEFAULT);
		$rs = oci_fetch_array($parse, OCI_BOTH);

	if($rs[0] == null) {
		echo "<h3 style='margin-left: 10%;color: red'>ไม่มีข้อมูล</h3>";
	}
	?>

	<form name='edit' action="sale_edit_cust.php" method="post">
  <table width="" border="1" align="center" cellpadding="2" cellspacing="0" id="table">
  <?php
  $numfield = oci_num_fields($parse);
  echo "<tr>";
  for($i=1;$i<=$numfield;$i++) {
    echo "<th height='35'>".oci_field_name($parse, $i)."</th>";
  }
  echo "</tr>";
	oci_execute($parse, OCI_DEFAULT);
	while($rs = oci_fetch_array($parse, OCI_BOTH)) {
		echo "<tr>";
    for($i=0;$i<$numfield;$i++) {
      echo "<td height='25' align='center'>".@$rs[$i]."</td>";
    }
		echo "</tr>";
	}
	echo "</table>";
	echo "</form>";
}
	?>
</div>
<?php
	include "footer.php";
?>
</div>
</body>
</html>
