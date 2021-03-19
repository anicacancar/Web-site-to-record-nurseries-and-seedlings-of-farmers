<html>
    <head>
    <link rel="stylesheet" type="text/css" href="stil.css">
    </head>
    <body>
        <div id='menu'>
        <?php
  session_start();
  require_once('config.inc.php');
  require_once('Konekcija.php');
  $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  if(isset($_GET['str']))
  {
      $_SESSION['pozSadj'] = $_GET['str'];
  }
  $idRas = $_SESSION['idRas'];

  $upit = "SELECT * FROM magacin WHERE idRas =".$idRas." AND tip = 'S' and kolicina <> 0";
  $rezultat = mysqli_query($konekcija->getVeza(), $upit)
              or die("Neuspjesan upit: ". $upit);
  
   echo "<form name = 'sadnice' method = 'GET' action = '#'>
                  <center>
                      <p class='naslov'>Tabela svih dostupnih sadnica:</p>
                      <table class='tabela'><thead><tr><td>Naziv sadnice:</td>
                      <td>Proizvodjac:</td>
                      <td>Kolicina:</td>
                      <td>Zasadi</td>
                      </tr></thead><tbody>";
               while($red  = mysqli_fetch_array($rezultat))
               {
                  $upit5= "SELECT * FROM proizvod WHERE idProiz =".$red['idProizvoda'];
                  $rezultat5 = mysqli_query($konekcija->getVeza(), $upit5)
                              or die("Neuspjesan upit: ".$upit5);
                  
                  $niz = mysqli_fetch_array($rezultat5);
                          echo "<tr>
                              <td>".$niz['naziv']."</td>
                              <td>".$niz['proizvodjac']."</td>
                              <td>".$red['kolicina']."</td>
                              <td><a href ='zasadi.php?id=".$niz['idProiz']."/".$_SESSION['pozSadj']."' class='linkovi'>Zasadi</a></td>
                          </tr>";
                      
                  }
                          echo "</tbody></table>
                      </center> </form>
                  ";
?>
        </div>
    </body>
</html>
