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

        </h5>
        <br>
<div class="order">
        <h3>Vul hier uw bestelgegevens in!</h3>
</div>
    <div class="besthead"></div>
            <div class="order">
        <br>
        <form method="get" action="ordercontrol.php">
<!--        Bezorggegevens    -->
      <h3>Bezorggegevens</h3><br>
      <h5>Bezorging</h5>
        <h6>Waar wilt u het bezorgd hebben?</h6>
                  <input type="radio" id="thuis" name="bezwijze" value="Thuis" required> Thuis <br>
          <input type="radio" id="afhpunt" name="bezwijze" value="afhpunt" required> Afhaalpunt <br><br>
        <h6>Op welke dag wil u het bezorgd hebben?</h6>
          <input type="radio" id="vandaag" name="tijd" value="vandaag" required > Zelfde dag <br>
          <input type="radio" id="morgen" name="tijd" value="morgen" required > Morgen <br><br>
<!--        Naam             -->
      <h5>Naam</h5>
        Voornaam:&#160;&#160;&#160;&#160;   <input type="text" id="fname" name="fname" required><br>
        Achternaam: &#160;<input type="text" id="lname" name="lname" required><br><br>
<!--        Adresgegevens     -->
      <h5>Adresgegevens</h5>
        Postcode:&#160;&#160;&#160;&#160;&#160;&#160;&#160;<input type="text" id="pcode" name="pcode" required><br>
        Huisnummer: <input type="text" id="huisnr" name="huisnr" required><br>
        e-mail:&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;<input type="text" id="email" name="email" required><br><br><br>
<!--        Betaalwijze    -->
      <h5>Betaalwijze</h5>
      <div class="betgeg">
      <input type="radio" id="ideal" name="betwijze" value="ideal"> Ideal<br>
       <input type="radio" id="cc" name="betwijze" value="cc"> Creditcard<br>
       <input type="radio" id="overschr" name="betwijze" value="overschr"> Overschrijving<br><br></div></div>
<!--      Bestelgegevens   -->
            <div class="besthead"></div>
<?php
}
print("<div class='overzichtBestelling'><br>");
print('<h4>Een overzicht van uw bestelling:<br></h4><h5>');
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
    print("<h6>");
    print ($R[0]["StockItemName"]);
    print ' | Aantal:';
    print " $aantal";
    print ' | Prijs: €';
    print round(($R[0]["SellPrice"]), 2) * $aantal;




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
print("<br><input type='submit' value='Naar betaalpagina' name='submit' class='bestelbutton'><br>");
print("</div>");

print("</h6></div>");

?>

