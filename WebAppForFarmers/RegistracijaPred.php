<?php
     session_start();
     require_once('config.inc.php');
     require_once('Konekcija.php');
     $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);

?>

<html>
    <head>
    <link rel="stylesheet" type="text/css" href="stil.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
        function ispisi(poruka)
        {
            document.getElementById('poruka').className = 'prikazi';
            document.getElementById('poruka').innerHTML = poruka;
        }
        function provjera()
        {
         var loz1 = document.getElementById('pass').value;
         var loz2 = document.getElementById('potvpass').value;
         if(loz1 != loz2)
         {
             ispisi('Lozinke se razlikuju');
         }else
         {
            document.getElementById('poruka').className = 'skriveno';
         }

        }
        function sakrij()
        {
            document.getElementById('koris').className = 'skriveno';

        }
        function user()
        {
            var us = document.getElementById('use').value; 
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) 
            {  
                if((this.responseText).trim()!='')
                {
                    document.getElementById('poruka').className = 'prikazi';
                    document.getElementById("poruka").innerHTML = this.responseText;
                }else
                {
                    document.getElementById('poruka').className = 'skriveno';
                }
            }
                };
                xmlhttp.open("GET","ProvjeraReg.php?us="+us,true);
                xmlhttp.send();
        }
        function provjeraMejl()
        {
            var mail  = document.getElementById('mejl').value;
            var mejlTest = /^\w+@\w{3,}\.\w{2,}$/;
            if(mejlTest.test(mail) === true)
            {
                document.getElementById('poruka').className = 'skriveno';
            }else
            {
                document.getElementById('poruka').className = 'prikazi';
                document.getElementById('poruka').innerHTML = 'Molimo vas unesite mejl u ispravnom formatu: anica@gmail.com';
            }
        }
    </script>
    </head>
    <body>
        <div id='header'>
            Registracija vašeg preduzeća
        </div>
        <div id='menu'>
        <center>
            <p class = 'naslov'>Registracija preduzeća:</p>
            <form name = 'RegPred' method = 'POST' action = '<?php echo $_SERVER['PHP_SELF'];?>'>
            <table>
                <tr><td>Pun naziv preduzeća: </td><td><input type = 'text'  name = 'naziv' size = '30'></td></tr>
                <tr><td>Skraćeni naziv preduzeća(Username):</td> <td><input type = 'text' id = 'use' name = 'username' size = '16'  onchange = 'user();' ></td></tr>
                <tr><td>Lozinka:</td><td><input type = 'password' id = 'pass' name = 'password1' size = '16'></td></tr><div id='koris' class='skriveno'></div>
                
                <tr><td>Potvrdi lozinku: </td><td><input type = 'password' id='potvpass' name = 'potvpassword' size = '16' onkeyup = 'provjera();'></td></tr>
                <tr><td>Datum osnivanja preduzeća: </td><td><input type = 'date' name = 'datumOsn'></td></tr>
                <tr><td>Mjesto preduzeća: </td><td><input type = 'text' name = 'mjestoPred' size = '16'></td></tr>
                <tr><td colspan='2'><input type = 'hidden' id = 'skri' name = 'skriveno'></td></tr>
                <tr><td>E-mail: </td><td><input type = 'text' id='mejl' name = 'mail' size = '20' onchange='provjeraMejl();'></td></tr><br/>
                <tr><td colspan='2'><center><div class="g-recaptcha" data-sitekey="6Ld-JasZAAAAANfECr7m0QkjwRkcloQrjpedbDrD"></center></div></td></tr>
                <tr><td colspan='2'><center><input type = 'submit' class = 'button' name = 'potvrda' value = 'Potvrdi registraciju'></center></td></tr>
                </table>
            </form>
            <div id='loz'>
                <h3>Lozinka mora zadovoljavati sledece :</h3>
                <p id="pocetno" class="invalid"> <b>Počinje slovom</b></p>
                <p id="specijalan" class="invalid"><b>Bar jedan specijalan znak(npr. @,$)</b> </p>
                <p id="veliko" class = "invalid"> <b>Bar jedno veliko slovo:</b></p>
                <p id="broj" class="invalid"><b>Bar jedan broj</b></p>
                <p id="duzina" class="invalid"><b>Minimalno 7 karaktera</b></p>
            </div>
            <div id='poruka' class = 'skriveno'>
            </div><br/><br/><br/><br/><br/><br/><br/>
            <a href = 'index.php' class='linkovi'>Vrati se na početnu stranu</a>
        </center>
        </div>
        <div id='footer'>
            COPYRIGHT
        </div>
<script>
            
    var polje = document.getElementById("pass");
    var pocetno = document.getElementById("pocetno");
    var specijalan = document.getElementById("specijalan");
    var veliko = document.getElementById("veliko");
    var broj = document.getElementById("broj");
    var duzina = document.getElementById("duzina");
    var poljec = false;
    var pocetnoc = false;
    var specijalanc = false;
    var brojc = false;
    var velikoc = false;
    var duzinac = false;

    polje.onfocus = function() {
    document.getElementById("loz").style.display = "block";
    }

    // W
    polje.onblur = function() {
    document.getElementById("loz").style.display = "none";
    }

    // Kada krene nesto da kuca
    polje.onkeyup = function() {

    // Provjera da li pocinje slovom
    var vrijed = polje.value;
    
    if (vrijed.toLowerCase() != vrijed.toUpperCase())
    {
        pocetno.classList.remove("invalid");
        pocetno.classList.add("valid");
        pocetnoc = true;
    } else {
        pocetno.classList.remove("valid");
        pocetno.classList.add("invalid");
        pocetnoc = false;
    }
 
    // Provjera da li ima specijalan znak
    var znak = /\W/g;
    if(polje.value.match(znak)) {  
        specijalan.classList.remove("invalid");
        specijalan.classList.add("valid");
        specijalanc = true;
    } else {
        specijalan.classList.remove("valid");
        specijalan.classList.add("invalid");
        specijalanc = false;
    }
    // Provjera velikog slova
    var vel = /[A-Z]/g;
    if(polje.value.match(vel)) {  
        veliko.classList.remove("invalid");
        veliko.classList.add("valid");
        velikoc = true;
    } else {
        veliko.classList.remove("valid");
        veliko.classList.add("invalid");
        velikoc = false;
    }

    // Provjera ima li broj
    var numbers = /[0-9]/g;
    if(polje.value.match(numbers)) {  
        broj.classList.remove("invalid");
        broj.classList.add("valid");
        brojc = true;
    } else {
        broj.classList.remove("valid");
        broj.classList.add("invalid");
        brojc = false;
    }
    
    // Duzina
    if(polje.value.length >= 7) {
        duzina.classList.remove("invalid");
        duzina.classList.add("valid");
        duzinac = true;
    } else {
        duzina.classList.remove("valid");
        duzina.classList.add("invalid");
        duzinac = false;
    }
    if(pocetnoc && specijalanc && velikoc && brojc && duzinac)
    {
        document.getElementById('skri').value = 'true';
    }else
    {
        document.getElementById('skri').value = 'false';
    }
    }
        </script>
  

<?php
if(isset($_POST['potvrda']))
{
    if(!empty($_POST['naziv'])  && !empty($_POST['username']) && !empty($_POST['password1']) && !empty($_POST['potvpassword']) && !empty($_POST['datumOsn']) && !empty($_POST['mjestoPred'])  && !empty($_POST['mail']))
    {
        $secretKey = "6Ld-JasZAAAAAELL0J0BFd8JpKcCDST1t3oDJjyI";
        $responseKey = $_POST['g-recaptcha-response'];
        $userIP = $_SERVER['REMOTE_ADDR'];

        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
        $response = file_get_contents($url);
        $response = json_decode($response);

    if ($response->success) 
    {
       
        // Provjera lozinke
        if($_POST['skriveno'] == 'true')
        {
            if($_POST['password1'] == $_POST['potvpassword'])
            {
                // Provjera jedinstvenosti username-a
                $up = "SELECT ime FROM korisnik WHERE username = '".$_POST['username']."'";
                if($konekcija->getRed($up) == 0)
                {
                    $upit = "INSERT INTO korisnik(username, password, ime, datum, mjesto, email, tip, odobren) VALUES ('".$_POST['username']."','".$_POST['password1']."','"
                    .$_POST['naziv']."','".$_POST['datumOsn']."','".$_POST['mjestoPred']."','".$_POST['mail']."','C', 0)";
                    $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                                or die("Greska u upitu: ".$upit);
                    if($rezultat)
                    { 
                        $u = "INSERT INTO kuriri(userPred,brojSlobodnihKurira) VALUES ('".$user."',3)";
                        $r = mysqli_query($konekcija->getVeza(), $u)
                                            or die("Neuspjesan upit: ".$u);
                        echo "<script type='text/javascript'>ispisi('Vaš zahtjev za registraciju je uspješno poslat!');</script>";
                        header("Location: index.php");
                    }
                }else
                {
                    echo "<script type='text/javascript'>ispisi('Ovo korisnicno ime je zauzeto, molimo vas izaberite drugo!');</script>";
                }
            }else
            {
                echo "<script type='text/javascript'>ispisi('Lozinke se ne poklapaju');</script>";
            }
        }else
        {
            echo "<script type='text/javascript'>ispisi('Neispravan format lozinke');</script>";
        }
    }else
    {
        echo "<script type='text/javascript'>ispisi('Neuspjesna verifikacija!');</script>";  
    }
}else
{
        echo "<script type='text/javascript'>ispisi('Sva polja su obavezna!');</script>";  
}     
}  
?>
  </body>
</html>