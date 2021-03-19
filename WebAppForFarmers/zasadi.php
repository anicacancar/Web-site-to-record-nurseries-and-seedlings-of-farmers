<?php
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if(isset($_GET['id']))
    {
        $pod = $_GET['id'];
    }

    list($idSad, $pozicija) = explode('/', $pod);

    $upit = "SELECT vrijeme FROM proizvod WHERE idProiz=".$idSad;
    $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                or die("Neuspjesan upit: ".$upit);
    $red = mysqli_fetch_array($rezultat);
    $danas = date('Y-m-d');
    $novi = date('Y-m-d',strtotime($danas."+".$red['vrijeme']."days"));

    $upit1 = "INSERT INTO zasadjene(idRasadnik,idSadnica,pozicija,datumVadjenja) VALUES(".$_SESSION['idRas'].",".$idSad.",'".$pozicija."','".$novi."')";
    $rezultat1 = mysqli_query($konekcija->getVeza(), $upit1)
                or die("Neuspjesan upit: ".$upit1);
    $upit2 = "UPDATE magacin SET kolicina = kolicina - 1 WHERE idRas=".$_SESSION['idRas']." AND idProizvoda =".$idSad;
    $rezultat2 = mysqli_query($konekcija->getVeza(), $upit2)
                or die("Neuspjesan upit: ".$upit2);
    echo "<script type = 'text/javascript'>";
            echo "window.opener.location.reload();";
            echo "window.close()";    
    echo "</script>";

?>