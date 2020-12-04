<?php
include __DIR__ . "/header.php";

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
?>

<html>
    <body>
        <h1 align="center">
        <br>
        <?php
        if(ISSET($_POST["Verstuur"])) {
            print ("Bedankt voor uw review!");

            $Query = "
            INSERT INTO reviewproduct
            VALUES (?, ?, ?, ?, ?, ?)";

            $Statement = mysqli_prepare($Connection, $Query);
            mysqli_stmt_bind_param($Statement, "issisi", $ReviewID, $_POST['OnderwerpReview'],$_POST['ToelichtingReview'],$_POST['star'],$ReviewDatum,$_POST["id"]);
            mysqli_stmt_execute($Statement);
            $R = mysqli_stmt_get_result($Statement);
            $id = $_POST["id"];
            }
        ?>
        <br>
        <a href="view.php?id=<?php print $id; ?>"> Ga terug naar de vorige pagina </a>
        </h1>
    </body>
</html>
