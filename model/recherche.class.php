<?php



class Recherche
{
    const SERVERSPEED = 10; // 1 = très long 5 = normal 10 = Super rapide 20  = SPPEEDDDDDDDRUN
    const COMPOST = 'compost';
    const OUTIL = 'outil';
    const HYDRAULIQUE = 'hydraulique';

    private $type;
    private $level;
    private $timeRemainingAmelioration;

    public function __construct($type, $level, $timeRemainingAmelioration)
    {
        $this->type = $type;
        $this->level = $level;
        $this->timeRemainingAmelioration = $timeRemainingAmelioration;
    }


    public function getType()
    {
        return $this->type;
    }


    public function getLevel()
    {
        return $this->level;
    }

    public function getTimeRemainingAmelioration()
    {
        return $this->timeRemainingAmelioration;
    }

    public function getWoodCostForNextLevel()
    {

        switch ($this->type) {
            case 'hydraulique':
                return 60 * pow(1.5, $this->level);
                break;
            case 'outil':
                return 48 * pow(1.6, $this->level);
                break;
            case 'compost':
                return 225 * pow(1.5, $this->level);
                break;
            default:
                return 0;
                break;
        }
    }

    public function getPierreCostForNextLevel()
    {

        switch ($this->type) {
            case 'hydraulique':
                return 15 * pow(1.5, $this->level);
                break;
            case 'outil':
                return 24 * pow(1.6, $this->level);
                break;
            case 'compost':
                return 75 * pow(1.5, $this->level);
                break;
            default:
                return 0;
                break;
        }
    }

    public function getBonus()
    {

        switch ($this->type) {
            case 'hydraulique':
                return 4 * sqrt(0.5 * $this->level);
                break;
            case 'outil':
                return 4 * sqrt(0.5 * $this->level);
                break;
            case 'compost':
                return 4 * sqrt(0.5 * $this->level);
                break;
            default:
                return 4 * sqrt(0.5 * $this->level);
                break;
        }
    }

    public function getNourritureCostForNextLevel()
    {
        switch ($this->type) {
            default:
                return 0;
                break;
        }
    }



    public function getUpgradeTimeForNextLevelInSeconde()
    {
        $timeInHour = ($this->getWoodCostForNextLevel() + $this->getPierreCostForNextLevel()) / (2500 * 5 * self::SERVERSPEED);
        return $timeInHour * 60 * 60;
    }
}
