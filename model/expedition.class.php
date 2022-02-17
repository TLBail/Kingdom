<?php


class Expedition
{

    private $id;
    private $dateDepart;
    public $tempsPourArriver;
    private $playerId;
    private $position;
    private $units;


    public function __construct($id, $dateDepart, $tempsPourArriver, $position, $playerId)
    {
        $this->id = $id;
        $this->dateDepart = $dateDepart;
        $this->tempsPourArriver = $tempsPourArriver;
        $this->playerId = $playerId;
        $this->position = $position;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getDateDepart()
    {
        return $this->dateDepart;
    }

    public function getTempsPourArriver()
    {
        return $this->tempsPourArriver;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getPlayerId()
    {
        return $this->playerId;
    }

    public function setUnits($units)
    {
        $this->units = $units;
    }

    public function getUnits()
    {
        return $this->units;
    }
}
