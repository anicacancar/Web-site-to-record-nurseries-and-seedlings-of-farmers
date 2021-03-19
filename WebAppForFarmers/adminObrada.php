<?php
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    require_once('Korisnik.php');
    require_once('Administrator.php');
    $admin = new Administrator($konekcija);
    $admin->logovanjeAdmin($_SESSION['username']);

    if(isset($_SESSION['n']))
    {
        $n = $_SESSION['n'];
    }
    if(isset($_SESSION['n1']))
    {
        $n1 = $_SESSION['n1'];
    }
    if(isset($_SESSION['korisnici']))
    {
        $korisnici = $_SESSION['korisnici'];
    }
    if(isset($_SESSION['korisnici1']))
    {
        $korisnici1 = $_SESSION['korisnici1'];
    }
    if(isset($_GET['potvrdi']))
    {
        for($i=0; $i<$n; $i++)
            if(isset($_GET["zahtjev".$i])) 
            {
                    if($_GET["zahtjev".$i]== 'odobri')
                    {
                        $admin->odobri($korisnici[$i],$konekcija);
                    }else
                    if($_GET["zahtjev".$i]=='obrisi')
                    {
                        $admin->obrisi($korisnici[$i],$konekcija);
                    }   
            }
        header('Location: Admin.php');
    }

    // Obrada brisanja korisnika
    if(isset($_GET['potvrdi1']))
    {
        for($i1=0; $i1<$n1; $i1++)
        {
            if(isset($_GET["brisi".$i1])) 
            {
                $admin->obrisi($korisnici1[$i1],$konekcija);
            }
        }
        header('Location: Admin.php');
    }

?>