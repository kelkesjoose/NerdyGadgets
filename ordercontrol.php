<?php
if (empty($_GET['fname'])) {
  $controle = 'Bezorggevens zijn verplicht';
  header("Location: order.php"); /* Redirect browser */
  exit();
}
 ?>
