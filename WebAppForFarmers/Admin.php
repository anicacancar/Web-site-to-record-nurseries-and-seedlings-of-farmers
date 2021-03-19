<html>
    <head>
      <link rel="stylesheet" type="text/css" href="stil.css">
    </head>
    <body>
        <div id='header'>
            Dobro dosli na administratorsku stranicu
        </div>
        <div id = 'menu'>
        <center>
            <?php
                    session_start();
                    require_once('config.inc.php');
                    require_once('Konekcija.php');
                    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    require_once('Korisnik.php');
                    require_once('Administrator.php');
                    $admin = new Administrator($konekcija);
                    $admin->logovanjeAdmin($_SESSION['username']);

                $upit = "SELECT * FROM korisnik WHERE odobren = 0";
                $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                        or die("Greska u upitu".$upit);
                        $n = 0;
                       
                        if(mysqli_num_rows($rezultat) > 0)
                        {
                            echo 
                                "
                                <center><h1>Zahtjevi za registraciju</h1></center>
                                <form name='zahtjevi' method='GET' action='adminObrada.php'>
                                <table class='tabela'><thead> <tr><th>Ime:</th> <th>Prezime:</th> <th>Korisnicko ime:</th>
                                <th>Datum:</th> <th>Mjesto:</th> <th>Telefon:</th>
                                <th>Email:</th> <th>Tip:</th> <th>Odobri/Odbaci:</th></tr></thead><tbody> ";
                        }
            
                        while($niz = mysqli_fetch_array($rezultat))
                        {
                            echo "<tr> <td>".$niz['ime']."</td>";
                            echo "<td>".$niz['prezime']."</td>";
                            echo "<td>".$niz['username']."</td>";
                            echo "<td>".$niz['datum']."</td>";
                            echo "<td>".$niz['mjesto']."</td>";
                            echo "<td>".$niz['telefon']."</td>";
                            echo "<td>".$niz['email']."</td>";
                            echo "<td>".$niz['tip']."</td>";
                            $korisnici[$n] = $niz['username']; //Krecu ti zahtjevi da se broje od 0 
                            echo
                                "<td>
                                    <input type='radio' name='zahtjev".$n."' value='odobri'>Odobri zahtjev<br/>
                                    <input type='radio' name='zahtjev".$n."' value='obrisi'>Odbaci zahtjev 
                                </td>
                            </tr>";
                            $n++;
                        }
                    
                        if(mysqli_num_rows($rezultat) > 0)
                        {
                            $_SESSION['n'] = $n;
                            $_SESSION['korisnici'] = $korisnici;
                            echo "</tbody></table>
                                    <center> 
                                    <br/>
                                        <input class='button' type='submit' name='potvrdi' value='Potvrdi'>
                                    </center>
                                </form>";
                        }
                        // Obrada zahtjeva od strane administratora 



            $upit1 = "SELECT * FROM korisnik WHERE odobren = 1";
            $rezultat1 = mysqli_query($konekcija->getVeza(), $upit1) or die(mysqli_connect_error());
            $n1 = 0;


            if(mysqli_num_rows($rezultat1) > 0)
            {
                echo "
                <center><h1>Svi korisnici:</h1></center>
                <form name='zahtjevi1' method='GET' action='adminObrada.php'>
                    <table class ='tabela'>
                    <thead>
                        <tr>
                            <th>Ime:</th> 
                            <th>Prezime:</th> 
                            <th>Korisnicko ime:</th>
                            <th>Datum:</th> 
                            <th>Mjesto :</th> 
                            <th>Telefon:</th>
                            <th>Email:</th> 
                            <th>Tip:</th> 
                            <th>Azuriraje:</th>
                            <th>Izbrisi korisnika:</th>
                        </tr>
                    </thead><tbody>";
            }

            while($niz1 = mysqli_fetch_array($rezultat1))
            {
                echo "<tr> <td>".$niz1['ime']."</td>";
                echo "<td>".$niz1['prezime']."</td>";
                echo "<td>".$niz1['username']."</td>";
                echo "<td>".$niz1['datum']."</td>";
                echo "<td>".$niz1['mjesto']."</td>";
                echo "<td>".$niz1['telefon']."</td>";
                echo "<td>".$niz1['email']."</td>";
                echo "<td>".$niz1['tip']."</td>";
                $korisnici1[$n1] = $niz1['username']; //Krecu  zahtjevi da se broje od 0 
                echo "
                    <td>
                        <a href='Azuriraj.php?kor=".$niz1['username']."'>Azuriraj korisnika</a>
                    </td>
                    <td>
                       <center> <input type='checkbox' name='brisi".$n1."'></center>
                    </td>
                </tr>";
                $n1++;
            }
        
            if(mysqli_num_rows($rezultat1) > 0)
            {
                $_SESSION['n1'] = $n1;
                $_SESSION['korisnici1'] = $korisnici1;
                echo 
                "</tbody></table>
                    <br/>
                    <input type='submit' class='button' name='potvrdi1' value='Potvrdi promjene'>
                    </form>";
            }

            

 ?>
        <button onclick = 'PromjeniLozinku()' id='promLoz' class='button'>Promjeni lozinku</button><br/>
            <div id='prom' class = 'skriveno'>
            </div><br/>
            <div id='por' class = 'skriveno'>
            </div><br/>
            <div id='dugmici'>
             <a href='dodajPolj.php' class ='linkovi'>Dodaj poljoprivrednika</a> &nbsp&nbsp
             <a href='dodajPred.php' class='linkovi'>Dodaj novo preduzeće</a>
             </div><br/>
             <a href='Logout.php' class='linkovi'>Izloguj se</a>
        
        </div>
        <div id = 'footer'>
            COPYRIGHT
        </div>
        </center>
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
                        window.location="index.php";
                    }
                }
                    };
                    xmlhttp.open("GET","promjenaLozinke.php?old=" + stara + "&nova1=" + nova1 + "&nova2="+nova2 +"&skriveno="+skr,true);
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
        <center>

    </body>
</html>


