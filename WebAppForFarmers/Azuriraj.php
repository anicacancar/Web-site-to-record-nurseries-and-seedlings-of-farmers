<?php
    if(isset($_GET['kor']))
    {
        $korisnik = $_GET['kor'];
    }else
    {
        $korisnik = $_GET['username'];
    }
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    require_once('Korisnik.php');
    require_once('Administrator.php');
    $admin = new Administrator($konekcija);
    $admin->logovanjeAdmin($_SESSION['username']);
        
    // Obrada azuriranja
    if(isset($_GET['potvrda']))
    {
        $user = $_GET['username'];
        $ime = $_GET['ime'];
        $prezime = $_GET['prezime'];
        $lozinka = $_GET['password1'];
        $datum = $_GET['datumRodj'];
        $mjesto = $_GET['mjestoRodj'];
        $tel = $_GET['tel1'];
        $mail = $_GET['mail'];
        if($user!='')
        {
            if($ime!='' || $prezime!='' || $lozinka!='' || $datum!='' || $mjesto!='' || $mail!='' || $tel!='') 
            {
               $admin->azuriraj($konekcija, $user, $ime, $prezime, $lozinka, $datum, $mjesto, $mail, $tel); 
            }
        }
     header("Location: Admin.php");

    }

    $upit = "SELECT * FROM korisnik WHERE username = '".$korisnik."'";
    $rez = mysqli_query($konekcija->getVeza(), $upit)
            or die("Greska u upitu: ".$upit);
    $red = mysqli_fetch_array($rez)
            or die("Nije uspio da uzme red!");
    echo
    "
    <html>
     <head>
          <link rel='stylesheet' type='text/css' href='stil.css'>
     </head>
    <body>
        <div id = 'header'>
            Azuriranje postojeceg korisnika
        </div>
        <div id = 'menu'>
          <center>
              <br/><br/><br/>
              <p class ='naslov'>Azuriranje korisnika:</p>
              <table>
              <form name = 'Azuriraj' method = 'GET' action = '#'>
                 <tr><td>Korisničko ime:</td> <td><input type = 'text' name = 'username' value = ".$red['username']." readonly></td> <br/></tr>
                 <tr><td>Ime(naziv firme):</td><td><input type = 'text' name = 'ime' value = ".$red['ime']."></td></tr>  
                  <tr><td>Prezime:</td><td><input type = 'text' name = 'prezime' value = ".$red['prezime']."></td></tr>
                  <tr><td>Lozinka:</td><td><input type = 'password' name = 'password1' value = ".$red['password']."></td></tr>
                  <tr><td>Datum rodjenja:</td><td> <input type = 'date' name = 'datumRodj' value = ".$red['datum']."></td></tr>
                  <tr><td>Mjesto rodjenja:</td><td><input type = 'text' name = 'mjestoRodj' value = ".$red['mjesto']."></td></tr> 
                  <tr><td>Telefon:</td><td><input type = 'text' name = 'tel1' value = ".$red['telefon']."></td></tr>
                  <tr><td>E-mail:</td><td><input type = 'text' name = 'mail' value = ".$red['email']."></td><br/></tr> 
                  <tr align = 'center'><td colspan = '2'><br/><br/><br/> <input class='button' type = 'submit' name = 'potvrda' value = 'Azuriraj'></td></tr>
              </form>
              </table>
          </center>
          <br/><br/><br/><br/>
          <a href = 'Admin.php' class='linkovi'>Vrati se na pocetnu stranu</a><br/><br/>
          <a href = 'Logout.php' class='linkovi'>Izloguj se</a>
          </div>
          <div id = 'footer'>
            Copyright
          </div>
      </body>
  </html>
    ";

 

?>