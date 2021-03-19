<?php
session_start();
require_once('config.inc.php');
require_once('Konekcija.php');
$konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);


?>

<html>
  <head>
  <link rel="stylesheet" type = "text/css" href="stil.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Datum', 'Broj naruzbina'],
          <?php
          $danas = date("Y-m-d");
          for ($i = 30; $i >= 1; $i--) {
              $j = 1;
              $datum = date('Y-m-d', strtotime($danas . " - " . $i . " days"));
              $upit = "SELECT COUNT(idNarudzbine) as brojNar FROM narudzbine WHERE preduzece='" . $_SESSION['username'] . "' AND datum='" . $datum . "'";
              $rez = mysqli_query($konekcija->getVeza(), $upit)
                      or die("Greska u upitu: ".$upit);
              $red = mysqli_fetch_array($rez);
              $brojNar = $red['brojNar'];
              $datumPom = date('d.M', strtotime($danas . " - " . $i . " days"));
            echo "['".$datumPom."',".$brojNar."],";
          }
          ?>

        ]);


        var options = {
          chart: {
            title: 'Rezultati poslovanja firme u poslednjih 30 dana',
            color: 'black'
          },
          backgroundColor: '#c09292'
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
  </head>
  <body>
  <div id='header'>
      Poslovanje preduzeća
  </div>
  <div id = 'menu'>
  <br/><br/><br/>
    <center><div id="columnchart_material" style="width: 800px; height: 500px;"></div></center><br/><br/><br/>
    <a href = 'Preduzece.php' class='linkovi'>Vrati se na pocetni ekran</a><br/><br/>
    <a href = 'Logout.php' class='linkovi'>Izloguj se</a>
  </div>
  <div id='footer'>
      COPYRIGHT
  </div>
  </body>
</html>