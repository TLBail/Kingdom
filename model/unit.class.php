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
        $this->timeRemainingAmelioration = $this->nbToAdd * ((this->getWoodCost()+$this->getStoneCost())/2500*6);
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

    public function setNumberToAdd($number)
    {
        $this->nbToAdd += $number;
    }

    public function getWoodCost()
    {

        switch ($this->name) {
            case 'Chasseur':
                return 3000;

            default:
                return 0;
        }
    }

    public function getStoneCost()
    {

        switch ($this->name) {
            case 'Chasseur':
                return 1000;

            default:
                return 0;
        }
    }

    public function getLife()
    {
        switch ($this->name) {
            case 'Chasseur':
                return 4800;

            default:
                return 0;
        }
    }
}
