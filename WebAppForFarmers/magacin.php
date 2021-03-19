<?php
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);
   
     // echo "
      //<table border=1> 
      //<tr> 
        //<td>Naziv:</td>
        //<td>Proizvodjac:</td>
        //<td>Kolicina:</td> 
      //</tr>
      //";
    if(isset($_GET['tip']))
    {
        if($_GET['tip']!='kolicina')
        {
            $upit = "SELECT m.kolicina, p.naziv, p.proizvodjac FROM magacin m, proizvod p WHERE m.idRas =".$_SESSION['idRas']." AND m.idProizvoda = p.idProiz ORDER BY p.".$_GET['tip'];
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
            $upit = "SELECT m.kolicina, p.naziv, p.proizvodjac FROM magacin m, proizvod p WHERE m.idRas =".$_SESSION['idRas']." AND m.idProizvoda = p.idProiz ORDER BY m.".$_GET['tip'];
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
    }else
    {
        $upit = "SELECT * FROM magacin  WHERE idRas =".$_SESSION['idRas'];
        $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                    or die("Neuspjesan upit: ".$upit);

                
        while($red = mysqli_fetch_array($rezultat))
        {
            $upit1 = "SELECT * FROM proizvod WHERE idProiz =".$red['idProizvoda'];
            $rezultat1 = mysqli_query($konekcija->getVeza(), $upit1)
                        or die("Neuspjesan upit: ".$upit1);
            $red1 = mysqli_fetch_array($rezultat1);
            echo "
                <tr>
                    <td>".$red1['naziv']."</td>
                    <td>".$red1['proizvodjac']."</td>
                    <td>".$red['kolicina']."</td>
                </tr>
            ";
        }
}
    echo "</tbody></table>";

?>