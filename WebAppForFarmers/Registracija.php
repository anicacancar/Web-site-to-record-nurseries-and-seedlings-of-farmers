<?php
    session_start();
    if(isset($_GET['Registracija']))
    {
        if(isset($_GET['tip']))
        {
            $_SESSION['tip'] = $_GET['tip'];
            if($_GET['tip'] == 'polj')
            {
                header("Location: RegistracijaPolj.php");
            }else
            {
                header("Location: RegistracijaPred.php");
            }
        }
    }
?>

<html>
    <head>
       <link rel="stylesheet" type="text/css" href="stil.css">    </head>
    <body>
        <div id='header'>
            REGISTRACIJA
        </div>
        <div id='menu'>
        <div id = 'sadr'>
            <br/><br/><br/><br/><br/><br/>
            <form name = 'reg' method = 'GET' action = '<?php echo $_SERVER['PHP_SELF'];?>'>
            <p class='naslov'>Izaberite tip korisnika za registraciju:</p><br/>
              <span id='box'>  <input type = 'radio' name = 'tip' value = 'polj'>Poljoprivrednik
                <input type = 'radio' name = 'tip' value = 'pred'>Preduzeće</span><br/><br/><br/><br/>
                <input type = 'submit' class = 'button' name = 'Registracija' value = 'Potvrdi'>
            </form>
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
            <a href='index.php' class='linkovi'>Vrati se na pocetnu stranu</a>
        </div>
        </div>
        <div id = 'footer'>
            COPYRIGHT
        </div>
    </body>
</html>