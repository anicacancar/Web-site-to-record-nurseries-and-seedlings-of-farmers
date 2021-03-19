<html>
<head>
    <link rel="stylesheet" type = "text/css" href="stil.css">
</head>
<body>
    <div id = 'header'>
        Dobrošli na stranicu preduzeća
    </div>
    <div id='menu'>
<script>
function sortirajDatum()
{

}
</script>


<?php
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if(isset($_GET['dir']))
    {
        $upit = "SELECT * FROM narudzbine WHERE preduzece='".$_SESSION['username']."' AND (status='NIJE ISPORUCENA' OR status = 'NA CEKANJU') ORDER BY datum ASC";
        $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                    or die("Neuspjesan upit: ".$upit);
    }else
    {
        $upit = "SELECT * FROM narudzbine WHERE preduzece='".$_SESSION['username']."' AND (status='NIJE ISPORUCENA' OR status = 'NA CEKANJU')";
        $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                    or die("Neuspjesan upit: ".$upit);
    }
    // Ispis porudzbina
    if(mysqli_num_rows($rezultat) > 0)
    {
        echo "<center><p class='naslov'>Pristigle narudžbine:</p>
                <table class='tabela'>
                <thead>
                <tr>
                    <td>Porucio:</td>
                    <td>Proizvodi:</td>
                    <td ><a href='Preduzece.php?dir=datum'> Datum porucivanja:</a></td>
                    <td>Status porudzbine:</td>
                    <td>Prihvatanje/Odbacivanje:</td>
                </tr>
                </thead><tbody> ";
    }
    while($red = mysqli_fetch_array($rezultat))
    {
        $up1 = "SELECT p.naziv FROM sadrzajNar s, proizvod p WHERE s.idNar = ".$red['idNarudzbine']." AND s.idPro = p.idProiz AND p.usernameProiz='".$_SESSION['username']."'";
        $rez1 = mysqli_query($konekcija->getVeza(), $up1)
                or die("Neuspjesan upit: ".$up1);
        
        echo "
            <tr id = 'pom'>
                <td>".$red['porucio']."</td>
                <td>";
        while($r1 = mysqli_fetch_array($rez1))
        {
            echo $r1['naziv']."<br/>";
        }
        echo "  </td>
                <td>".$red['datum']."</td>
                <td>".$red['status']."</td>
                ";
        if($red['status'] == 'NIJE ISPORUCENA')
        {
                echo "
                <td><button class='button' onClick = 'prihvati(".$red['idNarudzbine'].");')>Prihvati</button><button class='button' onClick = 'odbaci(".$red['idNarudzbine'].");'>Odbaci</button></td>";    
        }else
        {
          echo "  <td><button class = 'button' onClick = 'prihvati(".$red['idNarudzbine'].");')>Uposli kurira</button></td>";
        }
        echo  "</tr>";
    }

    if(mysqli_num_rows($rezultat) > 0)
    {       
         echo"
            </tbody></table>
            <div id = 'dat' class='skriveno'>
            </div></center>
        ";
    }

    $up = "SELECT brojSlobodnihKurira FROM kuriri WHERE userPred = '".$_SESSION['username']."'";
    $rez = mysqli_query($konekcija->getVeza(), $up)
            or die("Neuspjesan upit: ".$up);
    echo "<br/><div id='kuriri'><span id='kur'>SLOBODNI KURIRI: ".mysqli_fetch_array($rez)['brojSlobodnihKurira']."</span><br/><br/><br/>
    <button class='button' onclick = 'prikazProizvoda();'>Prikazi ponudu preduzeća</button><br/><br/><br/>
    <div id='proiz' class = 'skriveno'></div>

    </div>";
    

    $u2 = "SELECT * FROM narudzbine WHERE preduzece='".$_SESSION['username']."' AND status='DOSTAVA U TOKU'";
    $r2 = mysqli_query($konekcija->getVeza(), $u2)
                or die("Neuspjesan upit: ".$u2);
    echo "<p class='naslov'>Poslate narudzbine:<p/>";
    if(mysqli_num_rows($r2) > 0)
    {
        echo "<center>
                <table class = 'tabela'>
                <thead>
                <tr>
                    <td>Broj porudzbine:</td>
                    <td>Porucio:</td>
                    <td>Status porudzbine:</td>
                    <td>Zavrsi dostavu:</td>
                </tr></thead><tbody>
                          ";
    }
    while($red2 = mysqli_fetch_array($r2))
    {
        echo "  <tr>
                    <td>".$red2['idNarudzbine']."</td>
                    <td>".$red2['porucio']."</td>
                    <td>".$red2['status']."</td>
                    <td><button class='button' onclick = 'Zavrsi(".$red2['idNarudzbine'].");'>Zavrsi ovu porudzbinu </button></td>
                </tr>
        ";
    }
    if(mysqli_num_rows($r2) > 0)
    {
        echo "</tbody></table></center>";
    }
    if(isset($_GET['potvrdi']))
    {
        $u = "SELECT ime FROM korisnik WHERE username='".$_SESSION['username']."'";
        $r = mysqli_query($konekcija->getVeza(), $u)
                         or die("Greska u upitu: ".$u);
        $proiz = mysqli_fetch_array($r)['ime'];
        $u1 = "INSERT INTO proizvod(usernameProiz, naziv, proizvodjac, vrijeme, tip, kolicina, cijena) VALUES ('".$_SESSION['username']."','".$_GET['naziv']."','".$proiz."',".$_GET['broj'].",'".$_GET['tip']."',".$_GET['kol'].",".$_GET['cijena'].")";
        $r1 = mysqli_query($konekcija->getVeza(), $u1)
                        or die("Greska u upitu: ".$u1);
        header("Location: Preduzece.php");
    }

?>

<script>
    var selektovan = false;
    var selektovan1 = false;
    var selektovan2 = false;
   function prikazProizvoda()
   {
       if(selektovan1==false)
       {
        selektovan1 = true;
     var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
        {  
            document.getElementById('proiz').className = 'prikazi';
            document.getElementById('proiz').innerHTML = this.responseText;
        }
        };
            xmlhttp.open("GET","sviProizvodi.php",true);
            xmlhttp.send();
    }else
    {
        document.getElementById('proiz').className = 'skriveno';
        selektovan1=false;
    }
   }
   function dodajNoviProizvod()
   {
    if(selektovan2==false)
       {
        selektovan2 = true;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
        {  
            document.getElementById('dod').className = 'prikazi';
            document.getElementById('dod').innerHTML = this.responseText;
        }
        };
            xmlhttp.open("GET","dodajProiz.php",true);
            xmlhttp.send();
    }else
    {
        document.getElementById('dod').className = 'skriveno';
        selektovan2=false;
    }
   }
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
                document.getElementById('skriv').value = 'false';
                document.getElementById('por').innerHTML = 'Molimo vas unesite ispravan format lozinke';
            }
         }

function odbaci(id)
{
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) 
  {  
      alert(this.responseText);
      location.reload();
  }
  };
  xmlhttp.open("GET","sortPred.php?pom=odbaci/"+id,true);
  xmlhttp.send();
}

function prihvati(id)
{
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) 
  {  
    if((this.responseText).trim()=='')
      {
        document.getElementById("dat").className = "skriveno";
        location.reload();
      }else
      {
        document.getElementById("dat").innerHTML = this.responseText;
        document.getElementById("dat").className = "prikazi";
      }
  }
  };
  xmlhttp.open("GET","sortPred.php?pom=prihvati/"+id,true);
  xmlhttp.send();
}

function DA(id)
{
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) 
  {  
      if((this.responseText).trim()=='')
      {
        document.getElementById("dat").className = "skriveno";
        location.reload();
      }else
      {
        document.getElementById("dat").innerHTML = this.responseText;
        document.getElementById("dat").className = "prikazi";
      }
  
    }
  };
  xmlhttp.open("GET","prihvPrekoReda.php?pom="+id,true);
  xmlhttp.send();
}
function NE()
{
    location.reload();
    
}
function Zavrsi(id)
{
        var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) 
    {  
         location.reload();
    }
    };
    xmlhttp.open("GET","zavrsiPor.php?id="+id,true);
    xmlhttp.send();
}
</script>
<br/><br/><br/><br/><br/><br/><br/>
<button onclick =  'PromjeniLozinku()'  class = 'button' id='promLoz'>Promjeni lozinku</button><br/>
            <div id='prom' class = 'skriveno'>
            </div><br/>
            <div id='por' class = 'skriveno'>
            </div><br/>
            <div id='desno'>
                <button onclick = 'dodajNoviProizvod();' class='button'>Dodaj novi proizvod</button>
                <div id='dod' class = 'skriveno'>
                </div>
            </div>
            <a href = 'prikazPoslovanja.php' class='linkovi'>Prikazi poslovanje preduzeca</a><br/><br/>
            <a href='Logout.php' class='linkovi'>Izloguj se</a>
</div>
<div id = 'footer'>
    COPYRIGHT
</div>
</body>
</html>