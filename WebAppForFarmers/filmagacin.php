<?php
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    list($tip, $tekst) = explode("-", $_GET['tip']);
    if($tip!='kolicina')
        {
            $upit = "SELECT m.kolicina, p.naziv, p.proizvodjac FROM magacin m, proizvod p WHERE m.idRas =".$_SESSION['idRas']." AND m.idProizvoda = p.idProiz AND p.".$tip." LIKE '".$tekst."%' ORDER BY p.".$tip;
            $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                    or die("Neuspjesan upit: ".$upit);              
             while($red = mysqli_fetch_array($rezultat))
                    {
                        echo "
                            <tr>
                                <td>".$red['naziv']."</td>
                                <td>".$red['proizvodjac']."</td>
                                <td>".$red['kolicina']."</td>
                            </tr>
                        ";
                    }
        }
        else
        {
            $upit = "SELECT m.kolicina, p.naziv, p.proizvodjac FROM magacin m, proizvod p WHERE m.idRas =".$_SESSION['idRas']." AND m.idProizvoda = p.idProiz AND m.".$tip." LIKE '".$tekst."%' ORDER BY m.".$tip;
            $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                    or die("Neuspjesan upit: ".$upit);              
             while($red = mysqli_fetch_array($rezultat))
                    {
                        echo "
                            <tr>
                                <td>".$red['naziv']."</td>
                                <td>".$red['proizvodjac']."</td>
                                <td>".$red['kolicina']."</td>
                            </tr>
                        ";
                    }
        }


?>