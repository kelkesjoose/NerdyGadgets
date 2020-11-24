<?php
include __DIR__ . "/header.php";
?>
<form method="get" action="reviewform.php">
Naam: <input type="text" name="OnderwerpReview" placeholder="Onderwerp" class="TextVeldReview" > <br><br>
    <div class="PaddingToelichtingReview">
Toelichting:<br><textarea rows="5" cols="70" placeholder="Vul hier uw toelichting in" class="ToelichtingReview"> </textarea>
    </div>
<input type="submit" value="Verstuur" name="Verstuur!" class="betaalbutton">
</form>
