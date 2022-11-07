<?php

class Broker{
   
    private $mysqli;
    private static $broker;
    
    
    
    private function __construct(){
        $this->mysqli = new mysqli("localhost", "root", "", "banka_iteh");
        $this->mysqli->set_charset("utf8");
    }

    public static function getBroker(){
        if(!isset($broker)){
            $broker=new Broker();
        }
        return $broker;
    }
    
    function izvrsiCitanje($upit){
        $rezultat=$this->mysqli->query($upit);
       
        if(!$rezultat){
          throw new Exception($this->mysqli->error);
        }
        $rez=[];
            while($red=$rezultat->fetch_object()){
                $rez[]=$red;
            }
        return $rez;
    }
    function izvrsiIzmenu($upit){
        $rezultat=$this->mysqli->query($upit);
    
        if(!$rezultat){
           throw new Exception($this->mysqli->error);
        }
       
    }
   
}

?>
