<?php
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $id = $_GET['pom'];
    $up5 = "SELECT brojSlobodnihKurira FROM kuriri WHERE userPred='".$_SESSION['username']."'";
    $rez5 = mysqli_query($konekcija->getVeza(), $up5)
            or die("Neuspjesan upit: ".$up5);
    $br = mysqli_fetch_array($rez5)['brojSlobodnihKurira'];
    if($br == 0)
    {
        $up6 = "UPDATE narudzbine SET status = 'NA CEKANJU' WHERE idNarudzbine=".$id;
        $rez6 = mysqli_query($konekcija->getVeza(), $up6)
                or die("Neuspjesan upit:".$up6);

        echo "Nema slobodnih kurira, porudzbina je na cekanju<br/>
        <button onclick='NE();'>OK</button>";
    }else
    {
        $up6 = "UPDATE narudzbine SET status = 'DOSTAVA U TOKU' WHERE idNarudzbine=".$id;
        $rez6 = mysqli_query($konekcija->getVeza(), $up6)
                or die("Neuspjesan upit:".$up6);
        $up7 = "UPDATE kuriri SET brojSlobodnihKurira = brojSlobodnihKurira - 1 WHERE userPred='".$_SESSION['username']."'";
        $rez7 = mysqli_query($konekcija->getVeza(), $up7)
                or die("Neuspjesan upit:".$up7);
        $up8 = "SELECT idPro FROM sadrzajNar WHERE idNar=".$id;
        $rez8 = mysqli_query($konekcija->getVeza(), $up8)
                or die("Neuspjesan upit:".$up8);
        while($red8 = mysqli_fetch_array($rez8))
        {
            $up9 = "UPDATE proizvod SET kolicina = kolicina - 1 WHERE idProiz=".$red8['idPro'];
            $rez9 = mysqli_query($konekcija->getVeza(), $up9)
                or die("Neuspjesan upit:".$up9);
        }

        
    }
?>