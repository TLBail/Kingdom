<?php


class Batiment
{

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
}
