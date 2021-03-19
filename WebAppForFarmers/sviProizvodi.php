<?php
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // ISPIS SVIH PROIZVODA
    $up1 = "SELECT * FROM proizvod WHERE usernameProiz = '".$_SESSION['username']."'";
    $rez1 = mysqli_query($konekcija->getVeza(), $up1)
            or die("Neuspjesan upit: ".$rez1);
    echo "<h3>Ponuda vaseg preduzeca:</h3>";
    if(mysqli_num_rows($rez1) > 0)
    {
        echo "
                <center><table class='tabela'>
                <thead>
                <tr>
                    <td>Naziv:</td>
                    <td>Detalji:</td>
                </tr></thead><tbody>
                            ";
    }
    while($red1 = mysqli_fetch_array($rez1))
    {
        
        echo "
            <tr>
                <td>".$red1['naziv']."</td>";
        echo "<td><a href = 'ProizvodPrik.php?id=".$red1['idProiz']."'>Detalji</a></td>
                </tr>";
    }

    if(mysqli_num_rows($rez1) > 0)
    {       
            echo"</tbody>
                </table></center></div>
        ";
    }
?>