<?php
session_start();
if(isset($_GET['idRas']))
    {
      $pom = false;
      $_SESSION['idRas'] = $_GET['idRas'];
    }
    
// Obrada rasadnika 
// Povezivanje na bazu i pravimo poljoprivrednika
require_once('config.inc.php');
require_once('Konekcija.php');
$konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);

require_once('Korisnik.php');
require_once('Poljoprivreda.php');
require_once('Poljoprivreda.php');
$poljop = new Poljoprivrednik($konekcija);

if(isset($_GET['potvrdi']))
{
  $poljop -> smanjiTemp($konekcija, $_SESSION['idRas'], 1);
  $poljop -> smanjiNivo($konekcija,  $_SESSION['idRas'], 12);
  //$promTemp = $_GET['tempProm'];
  //$promNivo = $_GET['nivoProm'];
  //$poljop -> smanjiTemp($konekcija, $_SESSION['idRas'], -$promTemp);
  //$poljop -> smanjiNivo($konekcija,  $_SESSION['idRas'], -$promNivo);
  header('Location: Poljoprivrednik.php');
}
    // Uzimamo sve iz rasadnika 
    $upit = "SELECT * FROM rasadnik WHERE id=".$_SESSION['idRas'];
    $rezultat = mysqli_query($konekcija->getVeza(), $upit) 
                or die("Neuspjesan upit: ".$upit);
    $red = mysqli_fetch_array($rezultat);

    // Uzimamo sve zasadjene sadnice u ovaj rasadnk
    $upit1 = "SELECT * FROM zasadjene WHERE idRasadnik=".$_SESSION['idRas'];
    $rezultat1 = mysqli_query($konekcija->getVeza(), $upit)
                or die("Neuspjesan upit".$upit);
    $red1 = mysqli_fetch_array($rezultat1);

    

    // Ispis
    // $poljop->ispis($konekcija,  $_SESSION['idRas'], $red['duzina'], $red['sirina']);
    $m = $red['duzina'];
    $n = $red['sirina'];
    $upit1 = "SELECT pozicija FROM zasadjene WHERE idRasadnik=".$_SESSION['idRas'];
    $rezultat1 = mysqli_query($konekcija->getVeza(), $upit1)
        or die("Neuspjesan upit".$upit1);
    $l = 0;
    while($red1 = mysqli_fetch_array($rezultat1))
    {
        $niz[$l] = "".$red1['0'];
        $l++;
    }
    
    // Sa prethodne stranice smo poslali idRas kome smo pristupili i to samo prvi put jer kada se poslije pozove nakon potvrde ovaj get je prazan
    
    ?>
    <html>
<head>
    <link rel="stylesheet" type="text/css" href="stil.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['2020','Temperatura', 'Nivo'],
          <?php
            $upit2 = "SELECT * FROM rasadnik WHERE id = ".$_SESSION['idRas'];
            $rezultat = mysqli_query($konekcija->getVeza(), $upit2)
                      or die("Nesupjesan upit: ".$upit2);
            $red = mysqli_fetch_array($rezultat);
            echo "[2020,'".$red['temperatura']."',".$red['nivo']."]";
          ?>
        ]);

        var options = {
          chart: {
            title: 'Temperatura i nivo vode u rasadniku'
          },
          backgroundColor: '#c09292'
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
      // Obrada dugmica
      
      function dodajTemp()
      {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
        {  
          document.getElementById("tempProm").innerHTML =  this.responseText;
          drawChart();
          }
        };
        xmlhttp.open("GET","updateRa.php?tip=temp/p",true);
        xmlhttp.send();
      }
      
      function oduzmiTemp()
      {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
      {  
        document.getElementById("tempProm").innerHTML =  this.responseText;
        drawChart();
          }
        };
        xmlhttp.open("GET","updateRa.php?tip=temp/m",true);
        xmlhttp.send();
      }
      
      function dodajNivo()
      {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
      {  
        document.getElementById("nivoProm").innerHTML = this.responseText;
        drawChart();
          }
        };
        xmlhttp.open("GET","updateRa.php?tip=nivo/p",true);
        xmlhttp.send();
      }

      function oduzmiNivo()
      {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
        {  
        document.getElementById("nivoProm").innerHTML =  this.responseText;
        drawChart();
          }
        };
        xmlhttp.open("GET","updateRa.php?tip=nivo/m",true);
        xmlhttp.send();
      }
      function createPopupWin(pageURL, pageTitle, 
                    popupWinWidth, popupWinHeight) { 
            var left = (screen.width - popupWinWidth) / 2; 
            var top = (screen.height - popupWinHeight) / 2; 
              
            var myWindow = window.open(pageURL, pageTitle,  
                    'resizable=yes, width=' + popupWinWidth 
                    + ', height=' + popupWinHeight + ', top=' 
                    + top + ', left=' + left); 
        }
      function Info(i, j)
            {
                str1 = "" + i + ""+ j;
               
                createPopupWin("pom.php?str=" + str1,"Informacije o sadnici",550,400);
            }
      function Posadi(i, j)
            {
              pozSadj = "" + i + ""+ j;
              createPopupWin("sadjenje.php?str="+pozSadj, "Sadjenje", 550, 400);
            }
    </script>

  </head>
  <body>
  <div id='glavni'>
  <div id='header'>
    <img src = 'rasadnik.jpg' width="50px" height="50px" style="vertical-align:middle;">
        Rasadnik: <?php echo "".$red['naziv'];?>
  </div>
  <div id='menu'>
    <?php 
    echo "
    <center>
    <p class='naslov'>Raspored rasadnika:</p><br/><br/><br/><br/>
    <form name = 'mojaforma'>
    <table style='width:400px; height:300px;'>";
    for($i=0;$i<$m;$i++)
        {
            echo "<tr>";
            for($j=0;$j<$n;$j++)
                {
                    $upisano = false;
                    echo "<td class=";
                    for($k=0;$k<$l;$k++)
                    {
                        if($niz[$k] === "".$i."".$j)
                        {
                            echo "'zasadjeno' onmouseover = 'Info(".$i.",".$j.")'>";

                            $upisano = true;
                        }
                    }
                    if($upisano == false)
                        {
                            echo "'prazno'  onclick = 'Posadi(".$i.",".$j.")'>";
                        }
                    echo "</td>";
                }
            echo "</tr>";
        }
    echo "</table></form></center>";
?>
<br/><div id='graficki'><p class = 'naslov'>Graficki meni:</p><div id="columnchart_material"></div><br/>
        Kontrola temperature: &nbsp&nbsp<input type = 'button' class='button' value = '+' onClick = 'dodajTemp()';>
        <input type = 'button' class='button' value = '-' onClick = 'oduzmiTemp()';><br/>
       <br>Trenutna temperatura: <span id = 'tempProm'><?php echo $red['temperatura'];?></span>
        <br/><br/>
        Kontrola nivoa vode: &nbsp&nbsp<input type = 'button' class='button'  value = '+' onClick = 'dodajNivo();'>
        <input type = 'button' class='button' value = '-'  onClick = 'oduzmiNivo()';><br/><br/>
        Trenutni nivo: <span id = 'nivoProm'><?php echo $red['nivo'];?></span></div>
<center>
<div id='prikmag'><h1>Magacin:</h1>
<table>
      <tr>
        <td colspan='3'><center><button id='maga' class = 'button' onClick = 'prikazMagacina();'>Prikazi magacin</button><br/><br/></center></td></tr>
        <tr>
        <td>Po cemu vrsite pretragu:</td>
        <td>Unesite sta trazite:</td>
      </tr>
      <tr>
        <td><br/>
        <center>
          <select id = 'list'>
                <option value = 'naziv'>Nazivu:</option>
                <option value = 'proizvodjac'>Proizvodjacu</option>
                <option value = 'kolicina'>Kolicini:</option>
          </select>
        </center>
        <br/>
        
        </td>
        <td>
        <br/>
          <center>
          <input type = 'text' id='pret' size = '20'>
          </center>
          <br/>
          </td>
        </td>
      </tr>
       <tr>
          <td colspan='3'><center><button  id='fil' class='button' onClick='filtriranjeMagacina();'>Pretrazi proizvode</button><br/></center></td>
        </tr>
    </table>


  <script>
  var selektovan = false;
  function prikazMagacina()
  {
      if(selektovan == false)
      { 
        selektovan = true;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
        {  
          document.getElementById("mag").innerHTML = "<table class='tabela'><thead><tr><td onclick='sortirajPoNazivu();'>Naziv:</td><td onclick='sortirajPoProiz();'>Proizvodjac:</td><td onclick='sortirajPoKol();'>Kolicina:</td></tr></thead><tbody>" + this.responseText;
          }
          };
          xmlhttp.open("GET","magacin.php",true);
          xmlhttp.send();
      }else
      {
        document.getElementById("mag").innerHTML = "";
        selektovan = false;
      }
  }

  function sortirajPoNazivu()
  {
    var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) 
      {  
        document.getElementById("mag").innerHTML = "<table class='tabela'><thead><tr><td onclick='sortirajPoNazivu();'>Naziv:</td><td onclick='sortirajPoProiz();'>Proizvodjac:</td><td onclick='sortirajPoKol();'>Kolicina:</td></tr></thead><tbody>" + this.responseText;
      }
        };
        xmlhttp.open("GET","magacin.php?tip=naziv",true);
        xmlhttp.send();
  }
  
  function sortirajPoProiz()
  {
    var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) 
      {  
        document.getElementById("mag").innerHTML = "<table class='tabela'><thead><tr><td onclick='sortirajPoNazivu();'>Naziv:</td><td onclick='sortirajPoProiz();'>Proizvodjac:</td><td onclick='sortirajPoKol();'>Kolicina:</td></tr></thead><tbody>" + this.responseText;
      }
        };
        xmlhttp.open("GET","magacin.php?tip=proizvodjac",true);
        xmlhttp.send();
  }
  
  function sortirajPoKol()
  {
    var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) 
      {  
        document.getElementById("mag").innerHTML = "<table class='tabela'><thead><tr><td onclick='sortirajPoNazivu();'>Naziv:</td><td onclick='sortirajPoProiz();'>Proizvodjac:</td><td onclick='sortirajPoKol();'>Kolicina:</td></tr></thead><tbody>" + this.responseText;
          }
        };
        xmlhttp.open("GET","magacin.php?tip=kolicina",true);
        xmlhttp.send();
  }

  function filtriranjeMagacina()
  {
    var pom1 =document.getElementById('list').value;
    var pom2 = document.getElementById('pret').value;
    var pom = pom1 + "-" + pom2;
    var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) 
      {  
        document.getElementById("mag").innerHTML = "<table class='tabela'><thead><tr><td>Naziv:</td><td>Proizvodjac:</td><td>Kolicina:</td></tr></thead><tbody>" + this.responseText;
          }
        };
        xmlhttp.open("GET","filmagacin.php?tip=" + pom,true);
        xmlhttp.send();
  }
  </script>
  <br/><br/>
  <div id = 'mag'>
  </div>
</div>
<br/><br/><br/><br/><span id='lijev'>Poruci nove proizvode u <a href = 'onlineProdavnica.php?ras=' class='linkovi'>Online prodavnica</a></span>
  
 
    <center>
      <form name = 'povecaj' method = 'GET' action = '#'>
        <br/><br/>
        <input type = 'submit' class='button' name='potvrdi' value = 'Zavrsi pregledanje rasadnika'><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
        <a href = 'Poljoprivrednik.php' class='linkovi'>Vrati se na početnu stranu</a><br/>
        <br/><a href='Logout.php' class='linkovi'>Izloguj se</a>
      </form>
    </center>
    </div>

    <div id = 'footer'>
      COPYRIGHT
    </div>
  </div>
  </body>
</html>
