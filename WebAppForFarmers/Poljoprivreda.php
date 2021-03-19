<?php
    class Poljoprivrednik extends Korisnik
    {
        public function logovanjePolj($user)
        {
            $upit = "SELECT * FROM korisnik WHERE username='".$user."'";
            $rezultat = $this->konekcija->getRed($upit);

            if($rezultat!=NULL)
            {
                    $this->username = $user;
                    $this->lozinka = $rezultat['password'];
                    $this->odobren = 1;
                    $this->tip = $rezultat['tip'];
            }
        }

        public function brojSadnica($konekcija, $idRasadnik)
        {
            $upit = "SELECT * FROM zasadjene WHERE idRasadnik = ".$idRasadnik;
            $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                        or die("Neuspjesan upit: ".$upit);
            $p = mysqli_num_rows($rezultat);
            return $p;
        }

        public function brojSlobodnih($konekcija, $idRasadnik)
        {
            $upit = "SELECT * FROM rasadnik WHERE id = ".$idRasadnik;
            $rezultat = mysqli_query($konekcija->getVeza(), $upit)
                    or die("Neuspjesan upit: ".$upit);
            $red = mysqli_fetch_array($rezultat);
            $duzina = $red['duzina'];
            $sirina = $red['sirina'];

            $pom = ($duzina * $sirina) - $this->brojSadnica($konekcija, $idRasadnik);
            return $pom;
        }

     
    
        public function smanjiTemp($konekcija, $idRasadnik, $kol)
        {
            $upit = "SELECT temperatura FROM rasadnik WHERE id = ".$idRasadnik;
            $rez = mysqli_query($konekcija->getVeza(), $upit)
                    or die("Neuspjesan upit: ".$upit);
            $red = mysqli_fetch_array($rez);

            $novaTemp = $red['temperatura'] - $kol;
            $upit1 = "UPDATE rasadnik SET temperatura=".$novaTemp." WHERE id=".$idRasadnik;
            $rez1 =  mysqli_query($konekcija->getVeza(), $upit1)
                     or die("Neuspjesan upit: ".$upit1);
            
        }
        public function smanjiNivo($konekcija, $idRasadnik, $kol)
        {
            $upit = "SELECT nivo FROM rasadnik WHERE id = ".$idRasadnik;
            $rez = mysqli_query($konekcija->getVeza(), $upit)
                    or die("Neuspjesan upit: ".$upit);
            $red = mysqli_fetch_array($rez);

            $noviNivo = $red['nivo'] - $kol;
            $upit1 = "UPDATE rasadnik SET nivo=".$noviNivo." WHERE id=".$idRasadnik;
            $rez1 =  mysqli_query($konekcija->getVeza(), $upit1)
                     or die("Neuspjesan upit: ".$upit1);
            
        }
    }
?>

