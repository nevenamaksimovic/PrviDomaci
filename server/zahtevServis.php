<?php

class ZahtevServis{

    private $broker;

    public function __construct($b){
        $this->broker=$b;
    }
    public function vratiSve(){
        return $this->broker->izvrsiCitanje("select z.*, kr.naziv as 'naziv_kredita', kr.kamatna_stopa as 'stopa', z.iznos*POWER(1+kr.kamatna_stopa/100,z.period_otplate/12) as 'ukupno', k.ime, k.prezime from zahtev z inner join kredit kr on (z.kredit=kr.id) inner join korisnik k on (z.korisnik=k.id)");
    }
    public function kreiraj($kreditId,$korisnikId,$iznos,$period){

       
        $kredit=$this->broker->izvrsiCitanje("select * from kredit where id=".$kreditId)[0];
        $korisnik=$this->broker->izvrsiCitanje("select * from korisnik where id=".$korisnikId)[0];
        if($iznos<$kredit->minimalni_iznos){
            throw new Exception('Iznos je manji od minimalnog');
        }
        if($iznos>$kredit->maksimalni_iznos){
            throw new Exception('Iznos je veci od maksimalnog');
        }
        if($period<$kredit->minimalni_period){
            throw new Exception('Period je manji od minimalnog');
        }
        if($period>$kredit->maksimalni_period){
            throw new Exception('Period je veci od maksimalnog');
        }
        $status='PRIHVATLJIV';
        if($korisnik->prosek_primanja<$kredit->minimun_primanja){
            $status='NEPRIHVATLJIV';
        }
        if($korisnik->period_zaposlenja<$kredit->minimum_zaposlen){
            $status='NEPRIHVATLJIV';
        }
        $query="insert into zahtev(korisnik,kredit,iznos,period_otplate,status) values (".$korisnikId.",".$kreditId.",".$iznos.",".$period.",'".$status."')";
        $this->broker->izvrsiIzmenu($query);
    }

    

}

?>