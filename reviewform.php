<?php
include __DIR__ . "/header.php";
?>
<!DOCTYPE html>
<html lang="en" style="background-color: rgb(35,35,47);">
<head>
    <meta charset="UTF-8">
    <title> Review pagina </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css
    /font-awesome.min.css">
</head>
<?php
$Onderwerp ="";
$Toelichting = "";
$AantalSter = 0;
IF(ISSET($_POST['Verstuur'])) {
    print("Bedankt voor uw review");
    $Onderwerp = $_POST['OnderwerpReview'];
    $Toelichting = $_POST['ToelichtingReview'];
}
if(ISSET($_POST['Star1'])){
    $AantalSter = 1;
}
if(ISSET($_POST['Star2'])){
    $AantalSter = 2;
}
if(ISSET($_POST['Star3'])){
    $AantalSter = 3;
}
if(ISSET($_POST['Star4'])){
    $AantalSter = 4;
}
if(ISSET($_POST['Star5'])){
    $AantalSter = 5;
}
print($Onderwerp . $Toelichting . $AantalSter);
?>
<h1>Plaats review:</h1>
<form method="POST" action="reviewform.php">
Naam: <input type="text" name="OnderwerpReview" placeholder="Onderwerp" class="TextVeldReview" > <br><br>
    <div class="PaddingToelichtingReview">
Toelichting:<br><textarea rows="5" cols="70" placeholder="Vul hier uw toelichting in" class="ToelichtingReview" name="ToelichtingReview"> </textarea>
    </div>
<input type="submit" value="Verstuur!" name="Verstuur" class="betaalbutton">
    <div class="rating">
        <input type="radio" name="star5" id="star1"><label for="star1">
        </label>
        <input type="radio" name="star4" id="star2"><label for="star2">
        </label>
        <input type="radio" name="star3" id="star3"><label for="star3">
        </label>
        <input type="radio" name="star2" id="star4"><label for="star4">
        </label>
        <input type="radio" name="star1" id="star5"><label for="star5">
        </label>
    </div>
</form>
<body>
</body>
</html>
