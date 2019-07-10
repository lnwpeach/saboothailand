<?php
  include("connect.php");

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

  $sql = "select pro_id from \"6006021410172\".product";
  $query = mysqli_query($conn, $sql);
  $num = 0;
  while($rs = mysqli_fetch_array($query)) {
    $pro_id[] = $rs[0];
    $num++;
  }

  $sql = "select emp_id from employee where emp_id <= 'EM0020'";
  $query = mysqli_query($conn, $sql);
  $num2 = 0;
  while($rs = mysqli_fetch_array($query)) {
    $emp_id[] = $rs[0];
    $num2++;
  }

  $txtsql = "";
  $txtsql2 = "";
  $sale_id = "0000001";
  $year = 2015;
  $mmax = 12;
  while($year <= 2018) {
    $month = 1;
    if($year == 2018)
      $mmax = 5;
    while($month <= $mmax) {
      for($i=1;$i<=5;$i++) {
        $date = rand(1, 28)." ".$mthai[$month]." ".$year;
        $time = sprintf("%02d", rand(0, 23)).":".sprintf("%02d", rand(0, 59));
        $sql = "insert into sale values ('$sale_id','$date','$time','".$emp_id[rand(0,$num2-1)]."');";
        $txtsql .= $sql."<br>";
        //$query = @oci_parse($conn, $sql);
        //$execute = @oci_execute($query, OCI_DEFAULT);
        for($i=0;$i<=rand(1, 10);$i++) {
          $p = $pro_id[rand(0,$num-1)];
          $sql2 = "insert into sale_detail values ('$sale_id','".$p."','".rand(1, 5)."');";
          $txtsql2 .= $sql2."<br>";
          //$query2 = @oci_parse($conn, $sql2);
          //$execute2 = @oci_execute($query2, OCI_DEFAULT);
        }
        echo "<br>";
        $sale_id = sprintf("%07d", ((int)$sale_id+1));
        /*if($execute && $execute2) {
          oci_commit($conn);
          $sale_id = sprintf("%07d", ((int)$sale_id+1));
        }
        else {
          oci_rollback($conn);
          echo "Can't insert";
        }*/
      }
      echo "--------------<br>";
      $month++;
    }
    $year++;
  }
  echo $txtsql."<br>";
  echo $txtsql2;
  echo "Insert complete.";

?>
