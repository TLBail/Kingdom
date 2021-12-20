<?php

/*
valeur de type :
Scierie
Carriere
Ferme
EntrepotDeBois
EntrepotDePierre
Silo
Maison
Immeuble => spécial consomme de la nourriture 

*/

class Batiment
{

    const SERVERSPEED = 10; // 1 = très long 5 = normal 10 = Super rapide 20  = SPPEEDDDDDDDRUN

    private $type;
    private $standardProduction;
    private $level;

    public function __construct($type, $standardProduction, $level)
    {
        $this->type = $type;
        $this->standardProduction = $standardProduction;
        $this->level = $level;
    }


    public function getType()
    {
        return $this->type;
    }

    public function getStandardProduction()
    {
        return $this->standardProduction;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getWoodCostForNextLevel()
    {

        switch ($this->type) {
            case 'Scierie':
                return 60 * pow(1.5, $this->level);
                break;
            case 'Carriere':
                return 48 * pow(1.6, $this->level);
                break;
            case 'Ferme':
                return 225 * pow(1.5, $this->level);
                break;
            case 'EntrepotDeBois':
                return 1000 * pow(2, $this->level);
                break;
            case 'EntrepotDePierre':
                return 500 * pow(2, $this->level);
                break;
            case 'Silo':
                return 1000 * pow(2, $this->level);
                break;
            case 'Maison':
                return 75 * pow(1.5, $this->level);
                break;
            case 'Immeuble':
                return 900 * pow(1.8, $this->level);
                break;
            default:
                return 0;
                break;
        }
    }

    public function getPierreCostForNextLevel()
    {

        switch ($this->type) {
            case 'Scierie':
                return 15 * pow(1.5, $this->level);
                break;
            case 'Carriere':
                return 24 * pow(1.6, $this->level);
                break;
            case 'Ferme':
                return 75 * pow(1.5, $this->level);
                break;
            case 'EntrepotDePierre':
                return 250 * pow(2, $this->level);
                break;
            case 'Silo':
                return 1000 * pow(2, $this->level);
                break;
            case 'Maison':
                return 30 * pow(1.5, $this->level);
                break;
            case 'Immeuble':
                return 360 * pow(1.8, $this->level);
                break;
            default:
                return 0;
                break;
        }
    }

    public function getNourritureCostForNextLevel()
    {
        switch ($this->type) {
            case 'Immeuble':
                return 180 * pow(1.8, $this->level);
                break;
            default:
                return 0;
                break;
        }
    }

    public function getRessourceRatePerHour()
    {

        $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
        $path .= "/model/ressource.class.php";
        include_once($path);


        switch ($this->type) {
            case 'Scierie':
                return new Ressource('Bois', 30 * self::SERVERSPEED * $this->level * pow(1.1, $this->level));
                break;
            case 'Carriere':
                return new Ressource('Pierre', 20 * self::SERVERSPEED * $this->level * pow(1.1, $this->level));
                break;
            case 'Ferme':
                return new Ressource('Nourriture', 10 * self::SERVERSPEED * $this->level * pow(1.1, $this->level));
                break;
            case 'Maison':
                return new Ressource('Villageois', 20 * $this->level * pow(1.1, $this->level));
                break;
            case 'Immeuble':
                return new Ressource('Villageois', 30 * $this->level * pow(1.1, $this->level));
                break;
            default:
                return null;
                break;
        }
    }

    public function getTotalVillageoisCost()
    {

        $path = $_SERVER['DOCUMENT_ROOT'] . "/projet";
        $path .= "/model/ressource.class.php";
        include_once($path);


        switch ($this->type) {
            case 'Scierie':
                return 10 * $this->level * pow(1.1, $this->level);
                break;
            case 'Carriere':
                return 10 * $this->level * pow(1.1, $this->level);
                break;
            case 'Ferme':
                return 20 * $this->level * pow(1.1, $this->level);
                break;
            default:
                return 0;
                break;
        }
    }


    public function getStorageCapacity()
    {

        switch ($this->type) {
            case 'EntrepotDeBois':
                return 5000 * floor(2.5 * exp(20 / 33 * $this->level));
                break;
            case 'EntrepotDePierre':
                return 5000 * floor(2.5 * exp(20 / 33 * $this->level));
                break;
            case 'Silo':
                return 5000 * floor(2.5 * exp(20 / 33 * $this->level));
                break;
            default:
                return 0;
                break;
        }
    }
}
