<?php
  include("connect.php");

  if($_POST['cust'] == null) {
    $_SESSION['chkcust'] = 1;
    header("location:sale_pro_reserve.php");
  }

  $reserve_id = $_POST['reserve_id'];
  $cust_id = $_POST['cust'];

  $reserve_date = date("j ").$meng[date("n")].date(" Y");

  $sql = "insert into reserve values ('".$reserve_id."','$reserve_date','".date("H:i")."','$cust_id','รอชำระเงิน')";
  $query = mysqli_query($conn, $sql) or die("Can't insert reserve = ".$sql);
  for($i=0;$i<=(int)$_SESSION["intline"];$i++)
  {
    if($_SESSION["strpro_id"][$i] != "")
    {
      $sql2 = "insert into reserve_detail values ('".$_POST['reserve_id']."','".$_SESSION["strpro_id"][$i]."','".$_SESSION["strqty"][$i]."')";
      $query2 = mysqli_query($conn, $sql2) or die("Can't insert reserve");;

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
    header("location:sale_checkout_reserve.php?reserve_id=$reserve_id");
  }
  else {
    mysqli_rollback();
    echo "Can't insert";
  }
?>
