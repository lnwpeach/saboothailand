<?php
  include("connect.php");

  $sale_id = $_POST['sale_id'];
  $sale_date = date("j ").$meng[date("n")].date(" Y");

  $sql = "select rd.reserve_id, rd.pro_id, rd.pro_reserve_qty from reserve_detail rd ";
  $sql .= "join reserve r on rd.reserve_id = r.reserve_id where rd.reserve_id = '".$_POST["reserve_id"]."'";
	$query = mysqli_query($conn, $sql);
  $n = 0;
	while($rs = mysqli_fetch_array($query)) {
    for($i=0;$i<3;$i++) {
      $reserve[$n][$i] = $rs[$i];
    }
    $n++;
  }

  $sql = "insert into sale values ('".$sale_id."','$sale_date','".date("H:i")."','".$_SESSION['emp_id']."')";
  $query = mysqli_query($conn, $sql) or die("Can't insert sale = ".$sql);
  for($i=0;$i<$n;$i++)
  {
    $sql2 = "insert into sale_detail values ('".$sale_id."','".$reserve[$i][1]."','".$reserve[$i][2]."')";
    $query2 = mysqli_query($conn, $sql2) or die("Can't insert sale");

  }
  $sql3 = "update reserve set status = 'ชำระเงินแล้ว' where reserve_id = '".$reserve[0][0]."'";
  $query3 = mysqli_query($conn, $sql3);

  if($query && $query2 && $query3) {
    mysqli_commit();
    $r = $reserve[0][0];
    header("location:sale_info_reserve.php?reserve_id=$r");
  }
  else {
    mysqli_rollback();
    echo "Can't insert";
  }

?>
