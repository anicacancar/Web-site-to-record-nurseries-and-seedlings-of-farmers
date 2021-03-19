<html>
<head>
<link rel="stylesheet" type = 'text/css' href="stil.css">

</head>
<body>
<div id='header'>
    Detaljan prikaz proizvoda
</div>
<div id='menu'>
<?php
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    $up1 = "SELECT * FROM proizvod WHERE idProiz = ".$_GET['id'];
    $rez1 = mysqli_query($konekcija->getVeza(), $up1)
            or die("Neuspjesan upit: ".$rez1);
    $re1 = mysqli_fetch_array($rez1);
    $upit1 = "SELECT AVG(ocijena) AS avg FROM komentari WHERE idProizv=".$_GET['id'];
    $rezultat1 = mysqli_query($konekcija->getVeza(), $upit1)
                or die("Neuspjesan upit: ".$upit1);
    $red1 = mysqli_fetch_assoc($rezultat1);
    $upit = "SELECT * FROM komentari WHERE idProizv = ".$_GET['id'];
    $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                or die("Neuspjesan upit: ".$upit);

    echo "<h3>Informacije o proizvodu:</h3>";        
    if(mysqli_num_rows($rez1) > 0)
    {
        echo "
                    Vrijeme: ".$re1['vrijeme']."<br/>
                    Kolicina: ".$re1['kolicina']."<br/>
                    Tip: ";
                    if($re1['tip'] == 'S')
                    {
                            echo "
                            Sadnica<br/>";    
                    }else
                    {
                        echo "Preparat<br/>";
                    } 
                   echo " Prosjecna ocijena: ".$red1['avg']."<br/><br/>
                            ";
    }
 
    if(mysqli_num_rows($rezultat) > 0)
    {
        echo "
            <center>
            <table class = 'tabela'>
            <thead>
                <tr>
                    <td>Korisnicko ime:</td>
                    <td>Komentar:</td>
                    <td>Ocijena:</td>
                </tr></thead><tbody>";
    }
    while($red = mysqli_fetch_array($rezultat))
    {
        echo "
            <tr>
                <td>".$red['komentarisao']."</td>
                <td>".$red['komentar']."</td>
                <td>".$red['ocijena']."</td>
            </tr>
        ";
    }

    if(mysqli_num_rows($rezultat) > 0)
    {
        echo "</tbody>
            </table>
            </center><br/>
        ";
    }

    echo "<a href='Preduzece.php' class='linkovi'>Vrati se nazad</a><br/><br/>
    <a href='Logout.php' class='linkovi'>Izloguj se</a>";
?>
</div>
<div id='footer'>
    Copyright
</div>
</body>
</html>