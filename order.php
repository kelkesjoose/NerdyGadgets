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
?>
  <div class="order">
  </h5>
    <div class="order">
    <br>
    <div class="besthead">
    <h3>Vul hier uw bestelgegevens in!</h3>
    </div><br>
    <form method="get" action="ordercontrol.php">
      <h3>Bezorggegevens</h3><br>
      <h5>Bezorging</h5>
        <h6>Waar wilt u het bezorgd hebben?</h6>
        <div class="bezorg">
          Thuis <input type="radio" id="thuis" name="bezwijze" value="Thuis" required><br>
          Afhaalpunt <input type="radio" id="afhpunt" name="bezwijze" value="afhpunt" required><br><br>
        <h6>Op welke dag wil u het bezorgd hebben?</h6>
          Zelfde dag <input type="radio" id="vandaag" name="tijd" value="vandaag" required ><br>
          Morgen <input type="radio" id="morgen" name="tijd" value="morgen" required ><br><br>
        </div>
      <h5>Naam</h5>
        Voornaam:&#160;&#160;&#160;&#160;   <input type="text" id="fname" name="fname" required><br>
        Achternaam: &#160;<input type="text" id="lname" name="lname" required><br><br>
      <h5>Adresgegevens</h5>
        Postcode:&#160;&#160;&#160;&#160;&#160;&#160;&#160;<input type="text" id="pcode" name="pcode" required><br>
        Huisnummer: <input type="text" id="huisnr" name="huisnr" required><br>
        e-mail:&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;     <input type="text" id="email" name="email" required><br><br><br><br>

      <h3>Betaalwijze</h3>
      <div class="betgeg">
      Ideal <input type="radio" id="ideal" name="betwijze" value="ideal"><br>
      Creditcard <input type="radio" id="cc" name="betwijze" value="cc"><br>
      Overschrijving <input type="radio" id="overschr" name="betwijze" value="overschr"><br><br>
      <input type="submit" value="Naar betaalpagina" name="submit" class="bestelbutton"><br></div></div>
<?php
}

print('<h2><div class="besthead">Uw Bestelling</div><br></h2><h5>');
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

    print ($R[0]["StockItemName"]);
    print ' | Aantal:';
    print " $aantal";
    print ' | Prijs: €';
    print round(($R[0]["SellPrice"]), 2) * $aantal;
    print '<br>';



    $totaalPrijs = $totaalPrijs + (($R[0]["SellPrice"]) * $aantal);
    $subtotaal = $subtotaal + ($R[0]["RecommendedRetailPrice"]);
    $btwWaarde = ($R[0]["TaxRate"]) / 100 * $totaalPrijs;
}
print '<br>';
print '<br>';
$subtotalen = '';

if ($totaalPrijs >= 25.00) {
    $subtotalen .= "<p class='subtotalen'>Totaalprijs: €" . round(($totaalPrijs), 2) . "</p></td></tr>";
} else {
    $subtotalen .= "<p class='subtotalen'>Totaalprijs: €" . round(($totaalPrijs + 4.95), 2) . "</p></td></tr>";
}
print $subtotalen;
?>

</div>
