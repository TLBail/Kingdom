<?php


/*
valeur de type:
Bois
Pierre
Nourriture
Villageois

*/

class Ressource
{

    private $type;
    private $amount;

    public function __construct($type, $amount)
    {
        $this->type = $type;
        $this->amount = $amount;
    }


    public function getType()
    {
        return $this->type;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function addAmount($amount){
        $this->amount += $amount;
    }
}
