<?php
    class Konekcija
    {
        private $veza;

        public function __construct($DB_HOST, $DB_USER, $DB_PASS, $DB_BASE)
        {
            $this->veza = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_BASE)
                        or die("Neuspjesna konekcija: ".mysqli_connect.error());
            
        }

        public function getRed($upit)
        {
            $rezultat = mysqli_query($this->veza, $upit)
                      or die("Greska u upitu ".$upit);
            
            if(mysqli_num_rows($rezultat)!=0)
            {
                $red = mysqli_fetch_array($rezultat);
                return $red;
            }
            else
            {
                return 0;
            }
        }

        public function getVeza()
        {
            return $this->veza;
        }
    }

?>