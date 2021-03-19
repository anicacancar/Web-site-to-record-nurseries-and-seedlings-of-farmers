<?php
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
    }
    
    echo "<h3>Prikaz detaljnih informacija o proizvodu</h3>";
    $upit = "SELECT * FROM komentari WHERE idProizv = ".$id;
    $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                or die("Neuspjesan upit: ".$upit);
    if(mysqli_num_rows($rezultat) > 0)
    {
        echo "
            <table class='kom' border=1>
                <tr>
                    <td>Korisnicko ime:</td>
                    <td>Komentar:</td>
                    <td>Ocijena:</td>
                </tr>";
    }
    while($red = mysqli_fetch_array($rezultat))
    {
        echo "
            <tr>
                <td>".$red['komentarisao']."</td>
                <td>".$red['komentar']."</td>
                <td>".$red['ocijena']."</td>
            </tr>
        ";
    }

    if(mysqli_num_rows($rezultat) > 0)
    {
        echo "
            </table><br/>
        ";
    }
    echo "Unesite komentar:<br/> 
    <textarea rows='3' id = 'komentar'></textarea><br/>
    Unesite ocijenu:<br/>
    <input type='number' id='ocijena'><br/><br/>
    <button class = 'button' onclick='ostaviKom(".$id.");'>Dodaj komentar</button>"

  

?>

