
<?php

class KorisnikServis{

    private $broker;

    public function __construct($b){
        $this->broker=$b;
    }
    public function vratiSve(){
        return $this->broker->izvrsiCitanje("select * from korisnik");
    }
    public function kreiraj($ime,$prezime,$prosekPrimanja,$period){
        $this->broker->izvrsiIzmenu("insert into korisnik(ime,prezime,prosek_primanja,period_zaposlenja) values('".$ime."','".$prezime."',".$prosekPrimanja.",".$period.")");
    }
    public function izmeni($id,$ime,$prezime,$prosekPrimanja,$period){
         $this->broker->izvrsiIzmenu("update korisnik set ime='".$ime."', prezime='".$prezime."', prosek_primanja=".$prosekPrimanja." ,  period_zaposlenja=".$period." where id=".$id);
    }
    public function obrisi($id){
        $this->broker->izvrsiIzmenu("delete from korisnik where id=".$id); 
    }
}

?>