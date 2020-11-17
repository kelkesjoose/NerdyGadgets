<?php
include "CartFunctions.php";
include "connect.php";
include "cart.php";
?>
<!DOCTYPE html>
<html lang="en" style="background-color: rgb(35,35,47);">
<head>
    <meta charset="ISO-8859-1">
    <title>NerdyGadgets</title>
    <link rel="stylesheet" href="Public/CSS/Style.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/nha3fuq.css">
    <link rel="apple-touch-icon" sizes="57x57" href="Public/Favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="Public/Favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="Public/Favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="Public/Favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="Public/Favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="Public/Favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="Public/Favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="Public/Favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="Public/Favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="Public/Favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="Public/Favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="Public/Favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="Public/Favicon/favicon-16x16.png">
    <link rel="manifest" href="Public/Favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="Public/Favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff"></head>
<body>

<h1 align="center" >
<br><br>

    <?php
    $aantal=0;
    $cart = GetCart();

if(isset($_GET["submit"])){
    print("Bedankt voor uw betaling!<br>");
    print("<a href='index.php'> <h4>Ga terug naar de hoofdpagina.</h4> </a>");
    foreach ($cart as $StockItemID => $aantal) {
        $Query = " UPDATE Stockitemholdings
            SET QuantityOnHand = QuantityOnHand - $aantal
            WHERE StockItemID = $StockItemID";
        $Statement = mysqli_prepare($Connection, $Query);
        mysqli_stmt_execute($Statement);
        $Result = mysqli_stmt_get_result($Statement);
        $Result = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    }
} else {
    print("Er is iets fout gegaan :( <br>");
    print("<a href='checkout.php'> <h4>Ga terug naar de vorige pagina.</h4> </a>");
}


?>

</h1>
</body>
</html>

