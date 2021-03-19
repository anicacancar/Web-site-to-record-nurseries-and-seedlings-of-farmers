
<html>
    <head>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
         <link rel="stylesheet" type="text/css" href="stil.css">
    </head>
    <body>
    <script>
        function ispisi(poruka)
        {
            document.getElementById('poruka').className = 'prikazi';
            document.getElementById('poruka').innerHTML = poruka;
        }
    </script>
    <div id = 'header'>
        Dobrodošli na stranicu za prijavljivanje:
    </div>
    <?php
        session_start();
        echo "
        <div id='poruka' class='skriveno'></div>
        ";
    if(isset($_POST['username']) && isset($_POST['pass']) && isset($_POST['potvrda']))
    {
            unset($_SESSION['kor']);
            require_once('config.inc.php');
            require_once('Konekcija.php');

            $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            require_once('Korisnik.php');
            $korisnik = new Korisnik($konekcija);

            $fleg = $korisnik->logovanje($_POST['username'], $_POST['pass']);
            if($fleg == 1)
            {
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['tip'] = $korisnik->getTip();
                if($_SESSION['tip'] == 'A')
                {
                    header("Location: Admin.php");
                }elseif($_SESSION['tip'] == 'P')
                {
                    header("Location: Poljoprivrednik.php");
                }elseif($_SESSION['tip'] == 'C')
                {
                    header("Location: Preduzece.php");
                }
            }elseif($fleg == 2)
            {
                echo "
                    <script type='text/javascript'>
                     ispisi('Administrator i dalje nije odobrio Vaš zahtjev!'); 
                    </script>
                ";
            }elseif($fleg == 3)
            {
                $_SESSION['kor'] = $_POST['username'];
                echo "
                <script type='text/javascript'>
                    ispisi('Molimo unesite ispravnu lozinku!');
                </script>
            ";
            }else
            {
                echo "
                <script type='text/javascript'>
                    ispisi('Neuspjesno logovanje, ne postoje vasi kredencijali!');
                </script>
            ";
            }
        }
        ?>
    <div id = 'menu'>
        <br/><br/><br/><br/><br/><br/><br/><br/>
        <p class='naslov'>Logovanje:</p>
        <form name = 'mojaforma' method = 'POST' action = '<?php echo $_SERVER['PHP_SELF'];?>'>
        <table align='center'><tr>
        <td>Korisničko ime:</td>
        <td><input type = 'text' name = 'username' size = '16' value = '<?php if(isset($_SESSION['kor'])) echo "".$_SESSION['kor']?>'></td></tr>
        <tr><td>Lozinka:</td>
        <td><input type = 'password' name = 'pass' size = '16'></td></tr></table><br/><br/>
        <input type = 'submit' class='button' name = 'potvrda' value = 'ULOGUJ SE'><br/><br/>
        </form>
        <br/>
        <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
        Nemate nalog? <a href = 'Registracija.php' class='linkovi'>Registruj se</a>
    </div>
    <div id='footer'>
        COPYRIGHT
    </div>
    </body>
</html>

