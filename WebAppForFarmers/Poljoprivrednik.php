<html>
    <head>
      <link rel="stylesheet" type="text/css" href="stil.css">
    </head>
    <body>
        <div id='header'>
            Dobrodošli na stranicu poljoprivrednik
        </div>
        <div id = 'menu'>
        <center>
            <?php
                session_start();
                require_once('config.inc.php');
                require_once('Konekcija.php');
                $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                
                require_once('Korisnik.php');
                require_once('Poljoprivreda.php');
                $poljop = new Poljoprivrednik($konekcija);
                $poljop->logovanjePolj($_SESSION['username']);
                $upit = "SELECT * FROM rasadnik WHERE vlasnik = '".$_SESSION['username']."'";
                $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                            or die("Neuspjesan upit: ".$upit);
                $upit1 = "SELECT p.naziv, p.proizvodjac, s.idPro, n.idNarudzbine FROM narudzbine n, sadrzajnar s, proizvod p WHERE n.idNarudzbine=s.idNar AND n.porucio='".$_SESSION['username']."' AND p.idProiz=s.IdPro AND n.status = 'NIJE ISPORUCENA'";
                $rezultat1 = mysqli_query($konekcija->getVeza(), $upit1)
                        or die("Greska u upitu: ".$upit1);
                $n = 0;
                if(isset($_GET['potv']))
                {
                    $upit2 = "INSERT INTO rasadnik(naziv,mjesto,duzina,sirina,vlasnik) VALUES ('".$_GET['naziv']."','".$_GET['mjesto']."','".$_GET['duz']."','".$_GET['sir']."','".$_SESSION['username']."')";
                    $rez2 = mysqli_query($konekcija->getVeza(), $upit2)
                            or die("Neuspjesan upit: ".$upit2);
                    header("Location: Poljoprivrednik.php");
                }
                if(mysqli_num_rows($rezultat) > 0)
                {
                    echo 
                    "<center>
                        <p class ='naslov'>Vasi rasadnici:</h1>
                    </center>
                    <form name = 'rasadnici' method = 'GET' action = '#' >
                        <table class = 'tabela'>
                            <thead>
                            <tr>
                                <th>Naziv:</th>
                                <th>Mjesto: </th>
                                <th>Broj sadnica:</th>
                                <th>Broj slobodnih mjesta:</th>
                                <th>Kolicina vode:</th>
                                <th>Temperatura:</th>
                                <th>Prikaz rasadnika:</th>
                            </tr>
                            </thead><tbody>
                    ";
                }

                while($niz = mysqli_fetch_array($rezultat))
                {
                    echo "<tr>
                            <td>".$niz['naziv']."</td>
                            <td>".$niz['mjesto']."</td>
                            <td>".$poljop->brojSadnica($konekcija, $niz['id'])."</td>
                            <td>".$poljop->brojSlobodnih($konekcija, $niz['id'])."</td>
                            <td>".$niz['nivo']."</td>
                            <td>".$niz['temperatura']."</td>
                            <td><a href = 'Rasadnik.php?idRas=".$niz['id']."'><center>Prikazi</center></a></td>
                        </tr>";
                }

                if(mysqli_num_rows($rezultat) > 0)
                {
                    echo "</tbody>
                            </table>
                                </form>";
                }
                


            if(mysqli_num_rows($rezultat1) > 0)
            {
                echo 
                "<center>
                    <p class = 'naslov'>Vase porudzbine:</p>
                </center>
                <form name = 'porudzbine' method = 'GET' action = '#' >
                    <table class='tabela'>
                    <thead>
                        <tr>
                            <th>Naziv:</th>
                            <th>Proizvodjac:</th>
                            <th>Otkazi porudzbinu:</th>
                        </tr>
                    </thead>
                    <tbody>
                ";
            }

            while($niz1 = mysqli_fetch_array($rezultat1))
            {
                echo "<tr>
                        <td>".$niz1['naziv']."</td>
                        <td>".$niz1['proizvodjac']."</td>
                        <td><a href = 'otkazi.php?id=".$niz1['idPro']."/".$niz1['idNarudzbine']."'><center>Otkazi</center></a></td>
                    </tr>";
            }

            if(mysqli_num_rows($rezultat1) > 0)
            {
                echo "
                </tbody></table>
                    </form>";
            }
            echo "<p class='naslov'>Dodaj novi rasadnik:</p>
            <table>
            <form name='noviRas' method='GET' action='#'>
                <tr><td>Naziv:</td><td><input type = 'text' name='naziv'></td></tr>
                <tr><td>Mjesto:</td><td><input type = 'text' name='mjesto'></td></tr>
                <tr><td>Dimenzije:</td><td><input type = 'text' name='duz' size='1'> <input type = 'text' name='sir' size='1'></td></tr>
                <tr><td colspan='2'>                <br/>
                <center><input type = 'submit' class='button' name='potv' value='Unesi rasadnik'></center></td></tr>
                </form>
            </table>
        ";

?>    
            <script>
            var selektovan = false;
            function provjeraStareLoz()
            {
                var stara = document.getElementById('old').value; 
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) 
                {  
                    if((this.responseText).trim()!='')
                    {
                        document.getElementById('por').className = 'prikazi';
                        document.getElementById("por").innerHTML = this.responseText;
                    }else
                    {
                        document.getElementById('por').className = 'skriveno';
                    }
                }
                    };
                    xmlhttp.open("GET","provjeraStare.php?old="+stara,true);
                    xmlhttp.send();
            }                
        
            function PromjeniLozinku()
            {
                if(selektovan == false)
                {
                    selektovan = true;
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) 
                    {  
                        document.getElementById('prom').className = 'prikazi';
                        document.getElementById('prom').innerHTML = this.responseText;
                    }
                    };
                        xmlhttp.open("GET","promjeniLozinku.php",true);
                        xmlhttp.send();
                }else
                {
                    document.getElementById('por').className = 'skriveno';
                    document.getElementById('prom').className = 'skriveno';
                    selektovan = false;
                }
            
           }

           function potvrda()
           {
               var stara = document.getElementById('old').value;
               var nova1 = document.getElementById('pass').value;
               var nova2 = document.getElementById('potvpass').value;
               var skr = document.getElementById('skriv').value;
               var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) 
                {  
                    if((this.responseText).trim()!='')
                    {
                        document.getElementById('por').className = 'prikazi';
                        document.getElementById("por").innerHTML = this.responseText;
                    }else
                    {
                        document.getElementById('por').className = 'skriveno';
                        window.location="Logout.php";

                    }
                }
                    };
                    xmlhttp.open("GET","promjenaLozinke.php?old=" + stara + "&nova1=" + nova1 + "&nova2="+nova2 + "&skriveno=" + skr,true);
                    xmlhttp.send();
           }
         
         function provjeraIzraza()
         {
            var polje = document.getElementById("pass");
            var pocetno = false;
            var specijalan = false;
            var broj = false;
            var duzina = false;
            var veliko = false;

            // Provjera da li pocinje slovom
            var vrijed = polje.value.charAt(0);
            
            if (vrijed.toLowerCase() != vrijed.toUpperCase())
            {
                pocetno = true;
            } else {
                pocetno = false;
            }
        
            // Provjera da li ima specijalan znak
            var znak = /\W/g;
            if(polje.value.match(znak)) {  
                specijalan = true;
            } else {
                specijalan = false;
            }

            // Veliko slovo
            var veli = /[A-Z]/g
            if(polje.value.match(veli))
            {
                veliko = true;
            }else
            {
                veliko = false;
            }

            // Provjera ima li broj
            var numbers = /[0-9]/g;
            if(polje.value.match(numbers)) {  
                broj = true;
            } else {
                broj = false;
            }
            
            // Duzina
            if(polje.value.length >= 7) {
                duzina = true;
            } else {
                duzina = false;
            }
        
            if(pocetno && duzina && broj && specijalan && veliko)
            {
                document.getElementById('por').className = 'skriveno'; 
                document.getElementById('skriv').value = 'true';
            }else
            {
                document.getElementById('por').className = 'prikazi';
                document.getElementById('por').innerHTML = 'Molimo vas unesite ispravan format lozinke';
                document.getElementById('skriv').value = 'false';

            }
         }
        </script>
        <br/><br/>
        <button onclick = 'PromjeniLozinku()' class = 'button' id='promLoz'>Promjeni lozinku</button><br/>
        <div id='prom' class = 'skriveno'>
        </div><br/>
        <div id='por' class = 'skriveno'>
        </div>
            
            <a href = 'Logout.php' class='linkovi'>Izloguj se</a>
        </div>
        <div id = 'footer'>
            COPYRIGHT
        </div>
     </body>
</html>      
     




