<?php
include "CartFunctions.php";
include "header.php";



if (empty($_SESSION["cart"])) {
  print ("Het winkelwagentje is leeg!");
}

else {
  print_r($_SESSION["cart"]);
  print('<body>
    <h2>Bestelgegevens</h2>
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
