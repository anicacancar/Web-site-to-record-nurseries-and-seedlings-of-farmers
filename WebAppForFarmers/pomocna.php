<?php
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $upit2 = "SELECT * FROM proizvod";
    $rezultat2 = mysqli_query($konekcija->getVeza(), $upit2)
                 or die("Neuspjesan upit1: ".$upit2);
                   
    if(isset($_GET['potvrdi']))
    {
        while($red1 = mysqli_fetch_array($rezultat2))
       {      
           $pom = "".$red1['idProiz'];
            if(isset($_GET["".$pom]))
            {
                if($red1['kolicina'] > 0)
                { 
                    echo "".$red1['idProiz'];
                    $dat = date('Y-m-d');
                    $upit4 = "SELECT idNarudzbine FROM narudzbine WHERE preduzece ='".$red1['usernameProiz']."' AND status='NIJE ISPORUCENA' AND porucio='".$_SESSION['username']."' AND datum = '".$dat."'";
                    $rezultat4 = mysqli_query($konekcija->getVeza(), $upit4)
                                or die("Neuspjesan upit: ".$upit4);
                    
                    if(mysqli_num_rows($rezultat4) == 0)
                    {
                    $dat = date('Y-m-d');
                    $upit3 = "INSERT INTO narudzbine(idRasNar, porucio, preduzece, status, datum) VALUES (".$_SESSION['idRas'].",'".$_SESSION['username']."','".$red1['usernameProiz']."', 'NIJE ISPORUCENA', '".$dat."')";
                    $rez3 = mysqli_query($konekcija->getVeza(), $upit3)
                                or die("Neuspjesan upit: ".$upit3);
                    }

                    $upit5 = "SELECT idNarudzbine FROM narudzbine WHERE preduzece ='".$red1['usernameProiz']."' AND status='NIJE ISPORUCENA' AND porucio='".$_SESSION['username']."' AND datum = '".$dat."'";
                    $rezultat5 = mysqli_query($konekcija->getVeza(), $upit5)
                                or die("Neuspjesan upit: ".$upit5);
                    $red5 = mysqli_fetch_array($rezultat5);
                    
                    $upit6 = "INSERT INTO sadrzajNar(idNar,idPro) VALUES (".$red5['idNarudzbine'].",".$red1['idProiz'].")";
                    $rezultat6 = mysqli_query($konekcija->getVeza(), $upit6)
                    or die("Neuspjesan upit: ".$upit6);
                }else
                {
                    echo "Nije moguce poruciti proizvod".$red1['naziv']." jer ga nema na stanju!";
                }
            }
        
        }
        header("Location: onlineProdavnica.php");
    }
?>