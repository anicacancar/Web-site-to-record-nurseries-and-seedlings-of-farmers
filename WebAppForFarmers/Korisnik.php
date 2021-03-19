<?php
    class Korisnik
    {
        protected $username;
        protected $lozinka;
        protected $konekcija;
        protected $tip;
        protected $odobren;

        public function __construct($kon)
        {
            $this->konekcija = $kon;
        }

        public function logovanje($user, $pass)
        {
            $upit = "SELECT * FROM korisnik WHERE username='".$user."'";
            $rezultat = $this->konekcija->getRed($upit);

            if($rezultat!=NULL)
            {
                $upit1 = "SELECT * FROM korisnik WHERE username='".$user."' AND password = '".$pass."'";
                $rezultat1 = $this->konekcija->getRed($upit1);
                if($rezultat1 != NULL)
                {
                    if($rezultat1['odobren'] == 1)
                    {
                        $this->username = $user;
                        $this->pass = $pass;
                        $this->tip = $rezultat['tip'];

                        return 1;
                    }else
                    {
                        return 2;
                    }
                }else 
                {
                    return 3;
                }
            }else
            {
                return 4;
            }
        }

        public function getTip()
        {
            return $this->tip;
        }
    }
?>