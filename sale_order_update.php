<?php
  include("connect.php");

  $money = $_POST["money"];
  $change = $_POST["change"];
  $sale_id = $_POST['sale_id'];

  $sale_date = date("Y-m-d");

  $sql = "insert into sale values ('".$_POST['sale_id']."','$sale_date','".date("H:i")."','".$_SESSION['emp_id']."')";
  $query = mysqli_query($conn, $sql) or die("Can't insert sale = ".$sql);
  for($i=0;$i<=(int)$_SESSION["intline"];$i++)
  {
    if($_SESSION["strpro_id"][$i] != "")
    {

      $sql2 = "insert into sale_detail values ('".$_POST['sale_id']."','".$_SESSION["strpro_id"][$i]."','".$_SESSION["strqty"][$i]."')";
      $query2 = mysqli_query($conn, $sql2) or die("Can't insert sale");;

      $sql3 = "update product set pro_qty = pro_qty - '".$_SESSION["strqty"][$i]."' where pro_id = '".$_SESSION["strpro_id"][$i]."'";
      $query = mysqli_query($conn, $sql3);
    }
  }
  if($query && $query2) {
    mysqli_commit();
    $_SESSION["intline"] = null;
    $_SESSION["strpro_id"] = null;
    $_SESSION["strqty"] = null;
    $_SESSION["total"] = null;
    header("location:sale_checkout_bill.php?money=$money&change=$change&sale_id=$sale_id");
  }
  else {
    mysqli_rollback();
    echo "Can't insert";
  }
?>
