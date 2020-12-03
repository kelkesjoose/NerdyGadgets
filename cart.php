<?php
include __DIR__ . "/header.php";
include __DIR__ . "/connect.php";
include "CartFunctions.php";


$totaalPrijs = 0;
$teller = 0;

$subtotaal = 0;
$btwWaarde = 0;
?>
<div class="container">
    <div class="row">
        <div class="col-6 cart">
            <?php
            if (isset($_SESSION["cart"])) {
                print '<table class="table table-dark" style="text-align: center"><tr>
           <th>Productnaam</th>
           <th>Aantal</th>
           <th>Prijs</th>
           <th></th>
           </tr>';


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
                    echo "<td style='text-align: left'><form method='post' action='cart.php'>
                            <button onclick='window.location.reload()' type='submit' name='verwijder" . $productnummer . "' class='btn btn-danger actionBtn'><i class='far fa-trash-alt'></i></button>
                      </form></td></tr>";
                    if (isset($_POST["verwijder$productnummer"])) {
                        unset($_SESSION["cart"][$productnummer]);
                    }

                    $totaalPrijs = $totaalPrijs + (($R[0]["SellPrice"]) * $aantal);
                    $subtotaal = $subtotaal + ($R[0]["RecommendedRetailPrice"]);
                    $btwWaarde = ($R[0]["TaxRate"]) / 100 * $totaalPrijs;
                }
                $subtotalen = '';

                $subtotalen .= "<tr><td>";


                print $subtotalen;
                if ($totaalPrijs >= 25.00){
                    print"De verzendkosten zijn gratis";
                    print"<td>";
                    print"<td>";
                    print"Totaal prijs: <br>" . round(($totaalPrijs), 2);
                } else {
                    print"De verzendkosten zijn 4.95 <br>";
                    print"<td>";
                    print"<td>";
                    print "Totaal prijs: " . round(($subtotalen = $totaalPrijs + 4.95), 2);
                    $subtotalen .= "<p class='subtotalen'>Totaalprijs: €" . round(($totaalPrijs), 2) . "</p></td></tr>";
                }
                print '</td>';

                echo "<tr><td></td><td></td><td></td><td><a href='order.php'><input type=button name='bestellen' value='Bestellen' class='btn btn-primary'></a></tr>";


            } else {
                print 'Er zit niks in de winkelmand!';
            }
            ?>
        </div>
    </div>
</div>
