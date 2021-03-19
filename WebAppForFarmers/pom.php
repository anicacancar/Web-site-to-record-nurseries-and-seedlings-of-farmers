<?php
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if(isset($_GET['str']))
    {
        $_SESSION['pozicija'] = $_GET['str'];
    }
    $upit = "SELECT * FROM zasadjene WHERE pozicija = ".$_SESSION['pozicija'];
    $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                or die("Neuspjesan upit: ".$upit);
    $red = mysqli_fetch_array($rezultat);

    $idSad = $red['idSadnica'];

    $upit1 = "SELECT * FROM proizvod WHERE idProiz = ".$idSad;
    $rezultat1 = mysqli_query($konekcija->getVeza(), $upit1)
                or die("Neuspjesan upit: ".$upit1);
    $red1 = mysqli_fetch_array($rezultat1);

    $upit2 = "SELECT datumVadjenja FROM zasadjene WHERE pozicija = ".$_SESSION['pozicija'];
    $rezultat2 = mysqli_query($konekcija->getVeza(), $upit2)
                or die("Neuspjesan upit: ".$upit2);
    $red2 = mysqli_fetch_array($rezultat2);
    $potrebno = $red1['vrijeme'];
    $danas = date("Y-m-d");
    $vadjenje =strtotime($red2['datumVadjenja']);
    $ostalo = ceil(($vadjenje - (time()))/60/60/24);
    $proslo = $potrebno - $ostalo;
    $procenti = $proslo/$potrebno * 100;
?>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="stil.css">
    </head>
    <body>
        <div id = 'menu'>
        <?php
        echo 
        "       <center>
            <div id='info'>
                Naziv: ".$red1['naziv']."<br/>
                Proizvodjac: ".$red1['proizvodjac']."<br/>
                Napredak: <progress id='napredak' value=".$procenti." max='100'> ".$procenti." </progress><br/>
        ";
        if($procenti>=100)
        {
                echo "
                <h3>Sadnica je izrasla</h3>
                <a href = 'Izvadi.php?string=".$red['idSadnje']."' class='linkovi'>Izvadi sadnicu iz rasadnika</a>
                </div>
                </center>";
        }else
        {
        echo "</div><form name = 'preparati' method = 'GET' action = '#'>";
                 $upit4= "SELECT * FROM magacin WHERE tip = 'P' AND idRas=".$_SESSION['idRas'];
                 $rezultat4 = mysqli_query($konekcija->getVeza(), $upit4)
                             or die("Neuspjesan upit: ".$upit4);
                 
                 echo "
                    <center>
                        <p>Tabela svih dostupnih preparata:</p>
                        <table class='tabela'><tr><thead><td>Naziv preparata:</td>
                        <td>Proizvodjac:</td>
                        <td>Kolicina:</td>
                        <td>Dodaj preparat</td>
                        </tr></thead><tbody>";
                 while($red4  = mysqli_fetch_array($rezultat4))
                 {
                     if($red4['kolicina'] > 0)
                     {
                        $upit5= "SELECT * FROM proizvod WHERE idProiz =".$red4['idProizvoda'];
                        $rezultat5 = mysqli_query($konekcija->getVeza(), $upit5)
                                    or die("Neuspjesan upit: ".$upit5);
                        
                        $niz = mysqli_fetch_array($rezultat5);
                                echo "<tr>
                                    <td>".$niz['naziv']."</td>
                                    <td>".$niz['proizvodjac']."</td>
                                    <td>".$red4['kolicina']."</td>
                                    <td><a href ='dodajPrep.php?id=".$niz['idProiz']."/".$idSad."'>Dodaj preparat</a></td>
                                </tr>";
                    }
                }
                            echo "</tbody></table>
                        </center> </form>
                    ";
                }
            ?>
</div>       
    </body>
</html>
