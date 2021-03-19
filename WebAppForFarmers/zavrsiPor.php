<?php
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $upit3 = "SELECT idPro FROM sadrzajnar WHERE idNar = ".$_GET['id'];
    $rezultat3 = mysqli_query($konekcija->getVeza(), $upit3)
              or die("Neuspjesan upit: ".$upit3);
    // dodavanje prozivoda u magacin
    $upit4 = "SELECT idRasNar FROM narudzbine WHERE idNarudzbine = ".$_GET['id'];
    $rezultat4 = mysqli_query($konekcija->getVeza(), $upit4)
                 or die("Neuspjesan upit: ".$upit4);
    $re = mysqli_fetch_array($rezultat4);
    while($red = mysqli_fetch_array($rezultat3))
    {
        $up1 = "SELECT id FROM magacin WHERE idRas=".$re['idRasNar']." AND idProizvoda = ".$red['idPro'];
        if($konekcija->getRed($up1) == 0)
        {
            $up2 = "SELECT tip FROM proizvod WHERE idProiz = ".$red['idPro'];
            $r2 = $konekcija->getRed($up2);
            $up3 = "INSERT INTO magacin(idRas, idProizvoda, kolicina, tip) VALUES (".$re['idRasNar'].",".$red['idPro'].",1,'".$r2['tip']."')";
            $rez = mysqli_query($konekcija->getVeza(), $up3)
                              or die("Neuspjesan upit: ".$up3);
        }else
        {
        $up = "UPDATE magacin SET kolicina = kolicina + 1 WHERE idRas=".$re['idRasNar']." AND idProizvoda = ".$red['idPro'];
        $rez = mysqli_query($konekcija->getVeza(), $up)
                           or die("Neuspjesan upit: ".$up);
        }
    }

    $upit = "UPDATE narudzbine SET status = 'ISPORUCENA' WHERE idNarudzbine=".$_GET['id'];
    $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                or die("Neuspjesan upit: ".$upit);
    $upit2 = "UPDATE kuriri SET brojSlobodnihKurira = brojSlobodnihKurira + 1 WHERE  userPred='".$_SESSION['username']."'";
    $rezultat2 = mysqli_query($konekcija->getVeza(), $upit2)
                or die("Neuspjesan upit: ".$upit2);

?>