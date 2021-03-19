<?php
    $id = $_GET['id'];
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    require_once('Korisnik.php');
    require_once('Poljoprivreda.php');
    require_once('Poljoprivreda.php');
    $poljop = new Poljoprivrednik($konekcija);

    list($idProiz, $idSad) = explode('/', $id);

    $upit = "SELECT vrijeme FROM proizvod WHERE idProiz=".$idProiz;
    $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                or die("Neuspjesan upit: ".$upit);
    $red = mysqli_fetch_array($rezultat);

    $vrijeme = $red['vrijeme']; // Vrijeme koje preparat ubrzava(broj dana)
    $upit1 = "SELECT datumVadjenja FROM zasadjene WHERE idSadnica=".$idSad;
    $rezultat1 = mysqli_query($konekcija->getVeza(), $upit1)
                or die("Neuspjesan upit: ".$upit1);
    $red1 = mysqli_fetch_array($rezultat1);
    $krajnjiDatum = date('Y-m-d', strtotime($red1['datumVadjenja']."-".$vrijeme."days"));
    
    $upit2 = "UPDATE zasadjene SET datumVadjenja ='".$krajnjiDatum."' WHERE idSadnica =".$idSad;
    $rezultat2 = mysqli_query($konekcija->getVeza(), $upit2)
                or die("Neuspjesan upit: ".$upit2);
     $upit3 = "UPDATE magacin SET kolicina = kolicina - 1  WHERE idProizvoda =".$idProiz;
     $rezultat3 = mysqli_query($konekcija->getVeza(), $upit3)
                 or die("Neuspjesan upit: ".$upit3);

    header("Location: pom.php");
?>