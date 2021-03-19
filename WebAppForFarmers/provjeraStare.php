<?php
session_start();
require_once('config.inc.php');
require_once('Konekcija.php');
$konekcija = new Konekcija(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$up = "SELECT ime FROM korisnik WHERE username = '".$_SESSION['username']."' AND password = '".$_GET['old']."'";
if($konekcija->getRed($up) == 0)
{
    echo 'Stara lozinka nije ispravna!';
}else
{
    echo '';
}

?>