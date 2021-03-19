<html>
<head>
    <link rel="stylesheet" type = 'text/css' href="stil.css">
</head>
<body>
    <div id='header'>
        Dobrodošli u online prodavnicu
    </div>
    <div id='menu'>
<?php
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $upit = "SELECT * FROM proizvod";
    $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                 or die("Neuspjesan upit: ".$upit);
    
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
                    echo "<div class = 'prikazi'>Uspjesno ste izvrsili porudzbinu!</div>";
                   // header("Location: onlineProdavnica.php");
                }else
                {
                    echo "<div class ='prikazi'>Nije moguce poruciti proizvod ".$red1['naziv']." jer ga nema na stanju!</div> ";
                }
            }
        
        }

    }
    echo "
    
        <p class='naslov'>Ponuda proizvoda:</p>
    ";
    if(mysqli_num_rows($rezultat) > 0)
    {
        echo "<center>
            <form name = 'prodavnica' method = 'GET' action = '#'>
                <table class='tabela'>
                <thead>
                    <tr>
                    <th>Naziv:</th>
                    <th>Proizvodjac:</th>
                    <th>Ima na stanju:</th>
                    <th>Prosjecna ocijena:</th>
                    <th>Detaljan prikaz proizvoda:</th>
                    <th>Porucivanje:</th>
                    </tr>
                    </thead><tbody>";
    }
    $n = 0;
    while($red = mysqli_fetch_array($rezultat))
    {
        if($red['kolicina'] > 0)
        {
            $pom = "Da";
        }else
        {
            $pom = "Ne";
        }
    $upit1 = "SELECT AVG(ocijena) AS avg FROM komentari WHERE idProizv=".$red['idProiz'];
    $rezultat1 = mysqli_query($konekcija->getVeza(), $upit1)
                or die("Neuspjesan upit: ".$upit1);
    
        echo "
            <tr>
                <th>".$red['naziv']."</th>
                <th>".$red['proizvodjac']."</th>
                <th>".$pom."</th>";
                if(mysqli_num_rows($rezultat1) > 0)
                {
                    $red1 = mysqli_fetch_assoc($rezultat1);
                    echo "<th>".$red1['avg']."</th>";
                }else
                {
                    echo "<th></th>";
                }
                echo "
                <th><input type='button' onclick='Detalji(".$red['idProiz'].");' value ='Prikazi detalje'></th>
                <th><input type = 'checkbox' name = ".$red['idProiz']."></th>    
            </tr>
        ";
        $n = $n + 1;
    }
    if(mysqli_num_rows($rezultat) > 0)
    {
        echo "</tbody>
            </table><br/>
            <input type = 'submit' class='button' name='potvrdi' value='Potvrda porudzbine'>
            </form>
            </center>
        ";
    }          
   
?>

<div id='kom' class = 'skriveno'>
</div>

<div id = 'poruka' class = 'skriveno'>
</div>
<br/><br/><br/>
<a href = 'Poljoprivrednik.php' class='linkovi'>Vrati se na pocetnu stranu</a><br/><br/>
<a href = 'Logout.php' class='linkovi'>Izloguj se</a>
</div>
<div id='footer'>
    COPYRIGHT
</div>
<script>
    var selektovan = false;
    var proizvod = null;
    function Detalji(idPro)
    {
        //window.open("Proizvod.php?id="+idPro, "Detalji", "menubar=1,resizable=1,width=350,height=250");
        if (!selektovan || proizvod != idPro) {
            selektovan = true;
            proizvod = idPro;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("kom").className = "prikazi";
                document.getElementById("kom").innerHTML = this.responseText;
            }
            };
            xhttp.open("GET", "Proizvod.php?id=" + idPro, true);
            xhttp.send();
        } else {
            document.getElementById("kom").className = "skriveno";
            selektovan = false;
            proizvod = null;
        }
    }
    function Detalji1(idPro)
    {       
        location.reload();
    }
    function ostaviKom(idPro)
    {
        var kome = document.getElementById('komentar').value;
        var ocijena = document.getElementById('ocijena').value;
        var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("kom").className = "prikazi";
                document.getElementById("kom").innerHTML = this.responseText;
            }
            };
            xhttp.open("GET", "dodajKom.php?id=" + idPro + "&kom=" + kome + "&ocijena=" + ocijena, true);
            xhttp.send();
    }
 

</script>
</body>
</html>