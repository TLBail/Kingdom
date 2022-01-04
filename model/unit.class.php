<?php


class Units
{

    private $name;
    private $nombre;

    public function __construct($name, $nombre)
    {
        $this->name = $nombre;
        $this->nombre = $nombre;
    }


    public function getName()
    {
        return $this->name;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
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
