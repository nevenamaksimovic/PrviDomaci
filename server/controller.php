<?php
include "korisnikServis.php";
include "broker.php";
include "kreditServis.php";
include "zahtevServis.php";
class Controller{

    private $korisnikServis;
    private $zahtevServis;
    private $kreditServis;

    public function __construct(){
        $this->korisnikServis=new KorisnikServis(Broker::getBroker());
        $this->kreditServis=new KreditServis(Broker::getBroker());
        $this->zahtevServis=new ZahtevServis(Broker::getBroker());
    }

    public function izvrsi(){
        $akcija=($_SERVER['REQUEST_METHOD']=="POST")?$_POST["akcija"]:$_GET["akcija"];
        try {
           
            if($akcija=="vratiKorisnike"){
                return $this->vratiOdgovor($this->korisnikServis->vratiSve());
            }
            if($akcija=="vratiKredite"){
                return $this->vratiOdgovor($this->kreditServis->vratiSve());
            }
            if($akcija=="vratiZahteve"){
                return $this->vratiOdgovor($this->zahtevServis->vratiSve());
            }
            if($akcija=='kreirajKorisnika'){
                $this->korisnikServis->kreiraj($_POST["ime"],$_POST["prezime"],$_POST["prosekPrimanja"],$_POST["period"]);
                return  $this->vratiOdgovor(null);
            }
            if($akcija=='kreirajZahtev'){
                $this->zahtevServis->kreiraj($_POST["kredit"],$_POST["korisnik"],$_POST["iznos"],$_POST["period"]);
                return  $this->vratiOdgovor(null);
            }
            if($akcija=='izmeniKorisnika'){
                $this->korisnikServis->izmeni($_POST['id'],$_POST["ime"],$_POST["prezime"],$_POST["prosekPrimanja"],$_POST["period"]);
                return $this->vratiOdgovor(null);
            }
            if($akcija=='obrisiKorisnika'){
                $this->korisnikServis->obrisi($_POST['id']);
                return $this->vratiOdgovor(null);
            }
            return $this->vratiGresku("Metoda nije podrzana");
        } catch (Exception $ex) {
            return $this->vratiGresku($ex->getMessage());
        }
    }
     private function vratiOdgovor($podaci){
        if(!isset($podaci)){
            return[
                "status"=>true,
            ];
        }
        return[
            "status"=>true,
            "data"=>$podaci
        ];
    }
     private function vratiGresku($greska){
        return[
            "status"=>false,
            "error"=>$greska
        ];
    }
}

$controller=new Controller();

?>