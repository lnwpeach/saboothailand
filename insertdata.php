<?php
session_start();
date_default_timezone_set("asia/bangkok");
$conn = mysqli_connect("localhost","lnwpeachln_root","School3","lnwpeachln_saboothailand");
mysqli_query($conn, "set character set utf8");
 ?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head><title>แสดงการฟังก์ชั่น fopen และ fgets</title></head>
<body>
<?

// open file
$fp = @fopen("insert product.txt" , "r");
if ($fp) {
  while ( !feof($fp) ) {
    $sql = @fgets($fp);
    echo $sql."-x<br>";
    //$query = mysqli_query($conn, $sql);
    //mysqli_commit();
  }
}
else {
  die ("ไม่สามารถเปิดไฟล์เพื่ออ่านได้ !</body></html>");
}
?>
</body>
</html>
