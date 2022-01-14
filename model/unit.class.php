<?php


class Unit
{

    private $name;
    private $number;
    private $timeRemainingAmelioration;
    private $dateTimeAtLastUpdate;
    private $nbToAdd;

    public function __construct($name, $number, $timeRemainingAmelioration, $nbToAdd, $dateTimeAtLastUpdate)
    {
        $this->name = $name;
        $this->number = $number;
        $this->timeRemainingAmelioration = $timeRemainingAmelioration;
        $this->dateTimeAtLastUpdate = $dateTimeAtLastUpdate;
        $this->nbToAdd = $nbToAdd;
    }

    public function timeRemainingGenerate()
    {
        $this->timeRemainingAmelioration = $this->nbToAdd * (($this->getWoodCost() + $this->getStoneCost()) / 2500 * 6);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getTimeRemainingAmelioration()
    {
        return $this->timeRemainingAmelioration;
    }

    public function setNumber($number)
    {
        $this->number = $number;
    }

    public function getNbToAdd()
    {
        return $this->nbToAdd;
    }

    public function setNumberToAdd($number)
    {
        $this->nbToAdd += $number;
    }

    public function getWoodCost()
    {

        switch ($this->name) {
            case 'chasseur':
                return 3000;
            case 'chevalier':
                return 6000;
            case 'templier':
                return 20000;

            default:
                return 0;
        }
    }

    public function getStoneCost()
    {

        switch ($this->name) {
            case 'chasseur':
                return 1000;
            case 'chevalier':
                return 4000;
            case 'templier':
                return 7000;

            default:
                return 0;
        }
    }

    public function getLife()
    {
        switch ($this->name) {
            case 'chasseur':
                return 4800;
            case 'chevalier':
                return 12000;
            case 'chevalier':
                return 32400;

            default:
                return 0;
        }
    }
}
