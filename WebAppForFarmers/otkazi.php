<?php
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);


    if(isset($_GET['id']))
    {
       list($idPro, $idNar) =explode("/",$_GET['id']);
    }

    $upit = "DELETE FROM sadrzajnar WHERE idPro =".$idPro." AND idNar = ".$idNar;
    $rez = mysqli_query($konekcija->getVeza(), $upit)
                        or die("Neuspjesan upit".$upit);
    $upit1 = "SELECT idPro FROM sadrzajnar WHERE idNar =".$idNar;
    $rez1 = mysqli_query($konekcija->getVeza(), $upit1)
                    or die("Neuspjesan upit".$upit1);
    if(mysqli_num_rows($rez1) == 0)
    {
        $upit2 = "DELETE FROM narudzbine WHERE idNarudzbine =".$idNar;
        $rez2 = mysqli_query($konekcija->getVeza(), $upit2)
                        or die("Neuspjesan upit".$upit2);
    }

    header("Location: Poljoprivrednik.php");


?>