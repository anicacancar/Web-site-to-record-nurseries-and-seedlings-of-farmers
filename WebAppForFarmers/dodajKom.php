<?php
    session_start();
    require_once('config.inc.php');
    require_once('Konekcija.php');
    $konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    $id = $_GET['id'];
    $kom = $_GET['kom'];
    $ocijena = $_GET['ocijena'];
    $upit2 = "SELECT * FROM komentari WHERE komentarisao='".$_SESSION['username']."' AND idProizv=".$id;
    $rez2 = mysqli_query($konekcija->getVeza(), $upit2)
            or die("Neuspjesan upit: ".$upit2);
     
    $upit3 = "SELECT * FROM narudzbine WHERE porucio='".$_SESSION['username']."' AND status='ISPORUCENA'";
    $rez3 = mysqli_query($konekcija->getVeza(), $upit3)
            or die("Neuspjesan upit: ".$upit3);
    if(mysqli_num_rows($rez2) == 0 && mysqli_num_rows($rez3)>0)
    {
        $upit4 = "INSERT INTO komentari(idProizv, komentarisao, komentar, ocijena) VALUES (".$id.",'".$_SESSION['username']."','".$kom."',".$ocijena.")";
        $rez4 = mysqli_query($konekcija->getVeza(), $upit4)
                or die("Neuspjesan upit: ".$upit4);
                $upit = "SELECT * FROM komentari WHERE idProizv = ".$id;
                $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                            or die("Neuspjesan upit: ".$upit);
                if(mysqli_num_rows($rezultat) > 0)
                {
                    echo "
                        <table border = 1>
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
        echo "Uspjesno ste dodali komentar i ocijenu";          
    }else
    {
        echo "<h5>Nemate pravo komentarisanja jer ste vec komentarisali<br/> ili niste porucili ovaj proizvod!</h5>";
        $upit = "SELECT * FROM komentari WHERE idProizv = ".$id;
        $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                    or die("Neuspjesan upit: ".$upit);
        if(mysqli_num_rows($rezultat) > 0)
        {
            echo "
                <table border = 1>
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
                  

    }
?>