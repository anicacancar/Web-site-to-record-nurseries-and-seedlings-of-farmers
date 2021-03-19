<?php

session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);


   

   echo  "   
   <form name='dodaj' method = 'GET' action = '#'>
        Unesite naziv proizvoda: <input type = 'text' name = 'naziv' size='30'><br/>
        Vrijeme izrastanja/ubrzavanja: <input type = 'number' name = 'broj'><br/>
        Tip: <input type = 'radio' name = 'tip' value = 'S'>Sadnica
        <input type = 'radio' name = 'tip' value = 'P'>Proizvod<br/>
        Kolicina: <input type = 'number' name = 'kol'><br/>
        Cijena: <input type = 'number' name = 'cijena'><br/><br/><br/>
        <input type = 'submit' class='button' name='potvrdi' value = 'Unesi ovaj proizvod'>
   </form>";
  

   ?>