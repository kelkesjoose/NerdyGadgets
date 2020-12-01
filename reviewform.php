<?php
include __DIR__ . "/header.php";

$star = 0;
$date = getdate();
$ReviewID = "";

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
print $ReviewDatum;

?>

<!DOCTYPE html>
<html lang="en" style="background-color: rgb(35,35,47);">
<head>
    <meta charset="UTF-8">
    <title> Review pagina </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="Public/CSS/Style.css" type="text/css">
</head>

<?php
// foreach ($_POST as $key => $value) {
//     if ($key == "star1") {
//         $star = $star+1;
//         print $star;
//     }
//     if ($key == "star2") {
//         $star = $star+1;
//         print $star;
//     }
//     if ($key == "star3") {
//         $star = $star+1;
//         print $star;
//     }
//     if ($key == "star4") {
//         $star = $star+1;
//         print $star;
//     }
//     if ($key == "star5") {
//         $star = $star+1;
//         print $star;
//     }
// } 

$Query = "
INSERT INTO reviewproduct
VALUES (?, ?, ?, ?, ?)";

// $Statement = mysqli_prepare($Connection, $Query);
// mysqli_stmt_bind_param($Statement, "issis", $ReviewID, $_POST[OnderwerpReview],$_POST[ToelichtingReview],$star,$ReviewDatum);
// mysqli_stmt_execute($Statement);
// $R = mysqli_stmt_get_result($Statement);
// ?>

<body>
<h1>Plaats review:</h1>
<form method="post" action="reviewform.php">
Naam: <input type="text" name="OnderwerpReview" placeholder="Onderwerp" class="TextVeldReview" > <br><br>
    <div class="PaddingToelichtingReview">
Toelichting:<br><textarea rows="5" cols="70" placeholder="Vul hier uw toelichting in" name="ToelichtingReview" class="ToelichtingReview"> </textarea>
    </div>
    <!-- <div class="rating">
        <input type="radio" name="star1" id="star1"><label for="star1">
        </label>
        <input type="radio" name="star2" id="star2"><label for="star2">
        </label>
        <input type="radio" name="star3" id="star3"><label for="star3">
        </label>
        <input type="radio" name="star4" id="star4"><label for="star4">
        </label>
        <input type="radio" name="star5" id="star5"><label for="star5">
        </label>
    </div> -->
    
    <div class="slider">
        <input type="range" min="1" max="5" id="star" name="star" value="3">
        <div id="Selector">
            <div class="SelectBtn"></div>
            <div id="SelectValue"></div>
        </div>
        <div id="ProgressBar"></div>
    </div>

    <script>
        var slider = document.getElementById("star");
        var selector = document.getElementById("selector");
        var SelectValue = document.getElementById("SelectValue");
        var ProgressBar = document.getElementById("ProgressBar");

        SelectValue.innerHTML = slider.value;

        slider.oninput = function(){
            SelectValue.innerHTML = this.value;
            selector.style.left = this.value + "%";
            ProgressBar.style.width = this.value + "%";
        }
    </script>

<input type="submit" value="Verstuur!" name="Verstuur" class="betaalbutton">
</form>

</body>