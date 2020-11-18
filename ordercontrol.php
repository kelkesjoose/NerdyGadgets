<?php
if (empty($_GET['fname'])){
  echo "<script>location.href='order.php';</script>";
}
elseif (empty($_GET['lname'])){
  echo "<script>location.href='order.php';</script>";
}
elseif (empty($_GET['pcode'])){
  echo "<script>location.href='order.php';</script>";
}
elseif (empty($_GET['huisnr'])){
  echo "<script>location.href='order.php';</script>";
}
elseif (empty($_GET['email'])){
  echo "<script>location.href='order.php';</script>";
}
elseif (empty($_GET['betwijze'])){
  echo "<script>location.href='order.php';</script>";
} else {
  echo "<script>location.href='checkout.php';</script>";
}

?>
