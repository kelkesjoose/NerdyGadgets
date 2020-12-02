<?php
$Connection = mysqli_connect("localhost", "root", "", "nerdygadgets");
mysqli_set_charset($Connection, 'latin1');
include __DIR__ . "/header.php";
include "CartFunctions.php";


if(isset($_GET["id"])) {
    $stockItemID = $_GET["id"];
}else{
    $stockItemID = 0;
}
?>
<h3>Product <?php print($stockItemID)?></h3>

<form method="post">
    <input type="number" name="id" value="<?php print($stockItemID)?>" hidden >
    <input type="submit" name="submit" value="Voeg toe aan winkelmandje">
</form>

<?php
if(isset($_POST["submit"])){
    $stockItemID = $_POST["id"];
    AddProductToCart($stockItemID);
    print("Product is toegevoegd aan het <a href='cart.php'>winkelmandje</a>");
}

$Query = " 
           SELECT SI.StockItemID,
            (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice, 
            StockItemName,
            (CASE WHEN (SIH.QuantityOnHand) >= ? THEN 'Ruime voorraad beschikbaar.' ELSE CONCAT('Voorraad: ',QuantityOnHand) END) AS QuantityOnHand,
            SearchDetails, 
            (CASE WHEN (RecommendedRetailPrice*(1+(TaxRate/100))) > 50 THEN 0 ELSE 6.95 END) AS SendCosts, MarketingComments, CustomFields, SI.Video,
            (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath   
            FROM stockitems SI 
            JOIN stockitemholdings SIH USING(stockitemid)
            JOIN stockitemstockgroups ON SI.StockItemID = stockitemstockgroups.StockItemID
            JOIN stockgroups USING(StockGroupID)
            WHERE SI.stockitemid = ?
            GROUP BY StockItemID";

$ShowStockLevel = 1000;
$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "ii",$ShowStockLevel, $_GET['id']);
mysqli_stmt_execute($Statement);
$ReturnableResult = mysqli_stmt_get_result($Statement);
if ($ReturnableResult && mysqli_num_rows($ReturnableResult) == 1) {
    $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC)[0];
} else {
    $Result = null;
}
//Get Images
$Query = "
                SELECT ImagePath
                FROM stockitemimages 
                WHERE StockItemID = ?";

$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "i", $_GET['id']);
mysqli_stmt_execute($Statement);
$R = mysqli_stmt_get_result($Statement);
$R = mysqli_fetch_all($R, MYSQLI_ASSOC);

if ($R) {
    $Images = $R;
}
?>
<div id="CenteredContent">
    <?php
    if ($Result != null) {
        ?>
        <?php
        if (isset($Result['Video'])) {
            ?>
            <div id="VideoFrame">
                <?php print $Result['Video']; ?>
            </div>
        <?php }
        ?>


        <div id="ArticleHeader">
            <?php
            if (isset($Images)) {
                // print Single
                if (count($Images) == 1) {
                    ?>
                    <div id="ImageFrame"
                         style="background-image: url('Public/StockItemIMG/<?php print $Images[0]['ImagePath']; ?>'); background-size: 300px; background-repeat: no-repeat; background-position: center;"></div>
                    <?php
                } else if (count($Images) >= 2) { ?>
                    <div id="ImageFrame">
                        <div id="ImageCarousel" class="carousel slide" data-interval="false">
                            <!-- Indicators -->
                            <ul class="carousel-indicators">
                                <?php for ($i = 0; $i < count($Images); $i++) {
                                    ?>
                                    <li data-target="#ImageCarousel"
                                        data-slide-to="<?php print $i ?>" <?php print (($i == 0) ? 'class="active"' : ''); ?>></li>
                                    <?php
                                } ?>
                            </ul>

                            <!-- The slideshow -->
                            <div class="carousel-inner">
                                <?php for ($i = 0; $i < count($Images); $i++) {
                                    ?>
                                    <div class="carousel-item <?php print ($i == 0) ? 'active' : ''; ?>">
                                        <img src="Public/StockItemIMG/<?php print $Images[$i]['ImagePath'] ?>">
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- Left and right controls -->
                            <a class="carousel-control-prev" href="#ImageCarousel" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#ImageCarousel" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div id="ImageFrame"
                     style="background-image: url('Public/StockGroupIMG/<?php print $Result['BackupImagePath']; ?>'); background-size: cover;"></div>
                <?php
            }
            ?>


            <h1 class="StockItemID">Artikelnummer: <?php print $Result["StockItemID"]; ?></h1>
            <h2 class="StockItemNameViewSize StockItemName">
                <?php print $Result['StockItemName']; ?>
            </h2>
            <div class="QuantityText"><?php print $Result['QuantityOnHand']; ?></div>
            <div id="StockItemHeaderLeft">
                <div class="CenterPriceLeft">
                    <div class="CenterPriceLeftChild">
                        <p class="StockItemPriceText"><b><?php print sprintf("€ %.2f", $Result['SellPrice']); ?></b></p>
                        <h6> Inclusief BTW </h6>
                    </div>
                </div>
            </div>
        </div>

        <div id="StockItemDescription">
            <h3>Artikel beschrijving</h3>
            <p><?php print $Result['SearchDetails']; ?></p>
        </div>
        <div id="StockItemSpecifications">
            <h3>Artikel specificaties</h3>
            <?php
            $CustomFields = json_decode($Result['CustomFields'], true);
            if (is_array($CustomFields)) { ?>
                <table>
                <thead>
                <th>Naam</th>
                <th>Data</th>
                </thead>
                <?php
                foreach ($CustomFields as $SpecName => $SpecText) { ?>
                    <tr>
                        <td>
                            <?php print $SpecName; ?>
                        </td>
                        <td>
                            <?php
                            if (is_array($SpecText)) {
                                foreach ($SpecText as $SubText) {
                                    print $SubText . " ";
                                }
                            } else {
                                print $SpecText;
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                </table><?php
            } else { ?>

                <p><?php print $Result['CustomFields']; ?>.</p>
                <?php
            }
            ?>
        </div>
        <div>
            <div class="col-sm-12">
                <h1>Plaats review:</h1>
                <form method="post" action="reviewform.php">
                    Naam: <input type="text" name="OnderwerpReview" placeholder="Onderwerp" class="TextVeldReview" required> <br><br>
                    <div class="paddingstar">
                        <img src="public/img/Star3.png" width="40px" height="40px" id="paddingstar">
                    <img src="public/img/Star3.png" width="40px" height="40px" id="paddingstar">
                    <img src="public/img/Star3.png" width="40px" height="40px" id="paddingstar">
                    <img src="public/img/Star3.png" width="40px" height="40px" id="paddingstar">
                    <img src="public/img/Star3.png" width="40px" height="40px" id="paddingstar">
                    </div>
                    <div class="colorslider"></div>
                    <div class="slider">
                        <input type="range" min="1" max="5" name="star" >
                    </div>
                    <div class="PaddingToelichtingReview">
                        Toelichting:<br><textarea rows="5" cols="70" placeholder="Vul hier uw toelichting in" name="ToelichtingReview" class="ToelichtingReview" required> </textarea>
                    </div>
                    <?php
                    print_r($_POST); ?>
                    <input type="submit" value="Verstuur!" name="Verstuur" class="betaalbutton">
                </form>
            </div>
        </div>
        <?php
    } else {
        ?><h2 id="ProductNotFound">Het opgevraagde product is niet gevonden.</h2><?php
    } ?>
</div>
<br>
<?php
$date = getdate();
$ReviewID = "";
$ToelichtingReview = "";

foreach ($date as $time => $rv) {
if ($time == "mday") {
$day = $date["mday"];
}
if ($time == "mon") {
$month = $date["mon"];
}
if ($time == "year") {
$year = $date["year"];
break;
}
}

$ReviewDatum = "$year-$month-$day";
print($ReviewDatum);




?>

<?php
$Query = "
INSERT INTO reviewproduct
VALUES (?, ?, ?, ?, ?)";

$Statement = mysqli_prepare($Connection, $Query);
mysqli_stmt_bind_param($Statement, "issis", $ReviewID, $_POST['OnderwerpReview'],$_POST['ToelichtingReview'],$_POST['Star'],$ReviewDatum);
mysqli_stmt_execute($Statement);
$R = mysqli_stmt_get_result($Statement);
?>
<br>


