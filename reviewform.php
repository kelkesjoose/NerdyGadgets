<?php
include __DIR__ . "/header.php";
?>

<!DOCTYPE html>
<html lang="en" style="background-color: rgb(35,35,47);">
<head>
    <meta charset="UTF-8">
    <title> Review pagina </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
<h1>Plaats review:</h1>

</form>
<br>
<form method="get" action="reviewform.php">
    Naam: <input type="text" name="OnderwerpReview" placeholder="Onderwerp" class="TextVeldReview" > <br><br>

    <div class="rating">
        <input type="radio" name="star" id="star1"><label for="star1">
        </label>
        <input type="radio" name="star" id="star2"><label for="star2">
        </label>
        <input type="radio" name="star" id="star3"><label for="star3">
        </label>
        <input type="radio" name="star" id="star4"><label for="star4">
        </label>
        <input type="radio" name="star" id="star5"><label for="star5">
        </label>
    </div>
<br>
<br>
<br>

    <div class="PaddingToelichtingReview">
        Toelichting:<br><textarea rows="5" cols="70" placeholder="Vul hier uw toelichting in" class="ToelichtingReview"> </textarea>
    </div>
    <input type="submit" value="Verstuur" name="Verstuur!" class="betaalbutton">
</body>
