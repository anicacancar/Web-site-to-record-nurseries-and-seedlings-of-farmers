<?php
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if(isset($_GET['tip']))
    {
        $tip = $_GET['tip'];
    }
    list($prom, $vr) = explode("/",$tip);
    if($prom == 'temp')
    {
        if($vr == 'p')
        {
            $up1 = "UPDATE rasadnik SET temperatura=temperatura+1 WHERE id=".$_SESSION['idRas'];
            $rez1 = mysqli_query($konekcija->getVeza(), $up1)
                        or die("Neuspjesan upit: ".$up1);

        }else
        {
            $up2 = "UPDATE rasadnik SET temperatura=temperatura-1 WHERE id=".$_SESSION['idRas'];
            $rez2 = mysqli_query($konekcija->getVeza(), $up2)
                        or die("Neuspjesan upit: ".$up2);
        }
        $upit1 = "SELECT temperatura FROM rasadnik WHERE id=".$_SESSION['idRas'];
        $rezultat1 = mysqli_query($konekcija->getVeza(), $upit1)
                    or die("Neuspjesan upit: ".$upit1);
        $red1 = mysqli_fetch_array($rezultat1);
        echo $red1['temperatura'];
    }else
    {
        if($vr == 'p')
        {
            $up3 = "UPDATE rasadnik SET nivo=nivo+1 WHERE id=".$_SESSION['idRas'];
            $rez3 = mysqli_query($konekcija->getVeza(), $up3)
                        or die("Neuspjesan upit: ".$up3);
        }else
        {
            $up4 = "UPDATE rasadnik SET nivo=nivo-1 WHERE id=".$_SESSION['idRas'];
            $rez4 = mysqli_query($konekcija->getVeza(), $up4)
                        or die("Neuspjesan upit: ".$up4);
        }
        $upit2 = "SELECT nivo FROM rasadnik WHERE id=".$_SESSION['idRas'];
        $rezultat2 = mysqli_query($konekcija->getVeza(), $upit2)
                    or die("Neuspjesan upit: ".$upit2);
        $red2 = mysqli_fetch_array($rezultat2);
        echo $red2['nivo'];
    }

?>