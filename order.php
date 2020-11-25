<?php
include "CartFunctions.php";
include "header.php";
include __DIR__ . "/connect.php";
$totaalPrijs = 0;
$teller = 0;

$subtotaal = 0;
$btwWaarde = 0;




if (empty($_SESSION["cart"])) {
  print ("Het winkelwagentje is leeg!");
}

else {
    print('<h2>Bestelgegevens</h2><h5>');
  foreach ($_SESSION["cart"] as $productnummer => $aantal) {
      $teller++;

      $query = "SELECT StockItemName, TaxRate, RecommendedRetailPrice, (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice
       FROM StockItems
       WHERE StockItemID = ?";

      $Statement = mysqli_prepare($Connection, $query);
      mysqli_stmt_bind_param($Statement, "i", $productnummer);
      mysqli_stmt_execute($Statement);
      $R = mysqli_stmt_get_result($Statement);
      $R = mysqli_fetch_all($R, MYSQLI_ASSOC);

      print '<td style="text-align: left">';
      print ($R[0]["StockItemName"]);
      print '</td>';
      print '<td>';
      print "$aantal";
      print '</td>';
      print '<td>';
      print round(($R[0]["SellPrice"]), 2) * $aantal;
      print '</td>';
      print '<br>';
      echo "<td style='text-align: left'></td></tr>";

      $totaalPrijs = $totaalPrijs + (($R[0]["SellPrice"]) * $aantal);
      $subtotaal = $subtotaal + ($R[0]["RecommendedRetailPrice"]);
      $btwWaarde = ($R[0]["TaxRate"]) / 100 * $totaalPrijs;
  }
  print '<br>';
  print '<br>';
  $subtotalen = '';


  $subtotalen .= "<p class='subtotalen'>Totaalprijs: €" . round(($totaalPrijs), 2) . "</p></td></tr>";

  print $subtotalen;
  print('</h5>');
  print('<body>
    <br>
    <h3>Alle velden zijn verplicht!</h3><br>
    <form method="get" action="ordercontrol.php">
      <h3>Bezorggegevens</h3><br>
      <h5>Naam</h5>
        Voornaam: <input type="text" id="fname" name="fname"><br>
        Achternaam: <input type="text" id="lname" name="lname"><br><br><br><br>
      <h5>Adresgegevens</h5>
        Postcode: <input type="text" id="pcode" name="pcode"><br>
        Huisnummer: <input type="text" id="huisnr" name="huisnr"><br><br><br><br>
      e-mail: <input type="text" id="email" name="email"><br><br><br><br><br>

      <h3>Betaalwijze</h3>
      <input type="radio" id="ideal" name="betwijze" value="ideal">
      <label for="male">Ideal</label><br>
      <input type="radio" id="cc" name="betwijze" value="cc">
      <label for="female">Creditcard</label><br>
      <input type="radio" id="overschr" name="betwijze" value="overschr">
      <label for="male">Bankoverschrijving</label><br>
      <input type="submit" value="Naar betaalpagina" name="submit" class="bestelbutton"><br>');
}


?>
