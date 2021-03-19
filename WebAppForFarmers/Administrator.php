<?php
    class Administrator extends Korisnik
    {

        public function logovanjeAdmin($user)
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
       
        public function obrisi($user,$konekcija)
        {
            $upit = "DELETE FROM korisnik WHERE username='".$user."'";
            $rezultat = mysqli_query($konekcija->getVeza(),$upit)
                or die( "Nije uspio upit:".$upit);
            if($rezultat)  echo "Uspjesno obrisan".$user;
        }

        public function odobri($user,$konekcija)
        {
            $upit = "UPDATE korisnik SET odobren=1 WHERE username='".$user."'";
            $rezultat = mysqli_query($konekcija->getVeza(),$upit)
                or die( "Nije uspio upit:".$upit);
                if($rezultat) echo "Uspjesno odobren".$user;

        }

        public function azuriraj($konekcija, $user, $ime, $prezime, $lozinka, $datum, $mjesto, $mail, $tel)
        {

            $up = "SELECT tip FROM korisnik WHERE username = '".$user."'";
            $rez =  mysqli_query($konekcija->getVeza(),$up)
                     or die( "Nije uspio upit:".$up);
            if($rez == 'P')
            {
                if($ime != '')    
                {
                    $upit1 ="UPDATE korisnik SET ime='".$ime."' WHERE username='".$user."'";
            
                    $rezultat1 = mysqli_query($konekcija->getVeza(),$upit1)
                       or die( "Nije uspio upit:".$upit1);
                }   
                if($prezime != '')    
                {
                    $upit1 ="UPDATE korisnik SET prezime='".$prezime."' WHERE username='".$user."'";
            
                    $rezultat1 = mysqli_query($konekcija->getVeza(),$upit1)
                       or die( "Nije uspio upit:".$upit1);
                }  
                if($lozinka != '')    
                {
                    $upit1 ="UPDATE korisnik SET password='".$lozinka."' WHERE username='".$user."'";
            
                    $rezultat1 = mysqli_query($konekcija->getVeza(),$upit1)
                       or die( "Nije uspio upit:".$upit1);
                }  
                if($datum != '')    
                {
                    $upit1 ="UPDATE korisnik SET datum='".$datum."' WHERE username='".$user."'";
            
                    $rezultat1 = mysqli_query($konekcija->getVeza(),$upit1)
                       or die( "Nije uspio upit:".$upit1);
                }  
                if($mjesto != '')    
                {
                    $upit1 ="UPDATE korisnik SET mjesto='".$mjesto."' WHERE username='".$user."'";
            
                    $rezultat1 = mysqli_query($konekcija->getVeza(),$upit1)
                       or die( "Nije uspio upit:".$upit1);
                }  
                if($tel != '')    
                {
                    echo "usao";
                    $upit1 ="UPDATE korisnik SET telefon='".$tel."' WHERE username='".$user."'";
            
                    $rezultat1 = mysqli_query($konekcija->getVeza(),$upit1)
                       or die( "Nije uspio upit:".$upit1);
                }  
                if($mail != '')    
                {
                    $upit1 ="UPDATE korisnik SET email='".$mail."' WHERE username='".$user."'";
            
                    $rezultat1 = mysqli_query($konekcija->getVeza(),$upit1)
                       or die( "Nije uspio upit:".$upit1);
                }  
            }else
            {
                if($ime != '')    
                {
                    $upit1 ="UPDATE korisnik SET ime='".$ime."' WHERE username='".$user."'";
            
                    $rezultat1 = mysqli_query($konekcija->getVeza(),$upit1)
                       or die( "Nije uspio upit:".$upit1);
                }     
                if($lozinka != '')    
                {
                    $upit1 ="UPDATE korisnik SET password='".$lozinka."' WHERE username='".$user."'";
            
                    $rezultat1 = mysqli_query($konekcija->getVeza(),$upit1)
                       or die( "Nije uspio upit:".$upit1);
                }  
                if($datum != '')    
                {
                    $upit1 ="UPDATE korisnik SET datum='".$datum."' WHERE username='".$user."'";
            
                    $rezultat1 = mysqli_query($konekcija->getVeza(),$upit1)
                       or die( "Nije uspio upit:".$upit1);
                }  
                if($mjesto != '')    
                {
                    $upit1 ="UPDATE korisnik SET mjesto='".$mjesto."' WHERE username='".$user."'";
            
                    $rezultat1 = mysqli_query($konekcija->getVeza(),$upit1)
                       or die( "Nije uspio upit:".$upit1);
                }  
                if($mail != '')    
                {
                    $upit1 ="UPDATE korisnik SET email='".$mail."' WHERE username='".$user."'";
            
                    $rezultat1 = mysqli_query($konekcija->getVeza(),$upit1)
                       or die( "Nije uspio upit:".$upit1);
                }  
            }
        }

    }
?>