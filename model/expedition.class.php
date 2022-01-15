<?php


class Expedition
{

    private $id;
    private $dateDepart;
    private $tempsPourArriver;
    private $playerId;
    private $units;

    public function __construct($id, $dateDepart, $tempsPourArriver, $playerId)
    {
        $this->id = $id;
        $this->dateDepart = $dateDepart;
        $this->tempsPourArriver = $tempsPourArriver;
        $this->playerId = $playerId;
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
