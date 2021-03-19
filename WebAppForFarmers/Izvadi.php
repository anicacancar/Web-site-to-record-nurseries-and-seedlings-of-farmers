<?php
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if(isset($_GET['string']))
    {
        $_SESSION['idSad'] = $_GET['string'];
    }

    $upit = "DELETE FROM zasadjene WHERE idSadnje=".$_SESSION['idSad'];
    $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                or die("Greska u upitu:".$upit);
    echo "<script type = 'text/javascript'>";
    echo "window.opener.location.reload();";
    echo "window.close()";    
    echo "</script>";
?>