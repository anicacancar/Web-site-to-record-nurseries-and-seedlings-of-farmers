<?php
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $up = "SELECT ime FROM korisnik WHERE username = '".$_SESSION['username']."' AND password = '".$_GET['old']."'";
    if($konekcija->getRed($up) == 0)
    {
        echo 'Stara lozinka nije ispravna!';
    }else
    {
        if($_GET['nova1'] != $_GET['old'])
        {
            if($_GET['skriveno'] == 'true')
            {
                if($_GET['nova1'] != $_GET['nova2'])
                {
                    echo "Lozinka i potvrda lozinke se ne podudaraju.";
                }else
                {
                    $upit = "UPDATE korisnik SET password = '".$_GET['nova1']."' WHERE username = '".$_SESSION['username']."'";
                    $rez = mysqli_query($konekcija->getVeza(), $upit)
                            or die("Neuspjesan upit: ".$upit);
                    if($rez)
                    {
                        echo '';
                    }
                }
            }else
            {
                echo "Neispravan format lozinke";
            }
        }else
        {
            echo "Unijeli ste istu lozinku kao prethodnu!";
        }
      
    }
?>