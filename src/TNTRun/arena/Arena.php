<?php
namespace TNTRun\arena;

use pocketmine\level\Position;
use TNTRun\arena\handlers\GameHandler;
use TNTRun\arena\handlers\PlayerHandler;
use TNTRun\arena\status\PlayersManager;
use TNTRun\arena\status\StatusManager;
use TNTRun\Main;

class Arena{
    /** @var string */
    private $name, $levelName;
    /** @var Main */
    private $tntRun;
    /** @var GameHandler */
    private $gameHandler;
    /** @var PlayerHandler */
    private $playerHandler;
    /** @var StatusManager */
    private $statusManager;
    /** @var PlayersManager */
    private $playerManager;
    /** @var array */
    private $pos1, $pos2, $floors, $spawn;
    
    public function __construct($name, Main $tntRun, array $pos1, array $pos2, array $floors, $levelName, array $spawn){
        $this->tntRun = $tntRun;
        $this->name = $name;
        
        $this->gameHandler = new GameHandler($tntRun, $this);
        $this->playerHandler = new PlayerHandler($tntRun, $this);
        
        $this->statusManager = new StatusManager($this);
        $this->playerManager = new PlayersManager($this);

        $this->pos1 = ["x" => min($pos1["x"], $pos2["x"]), "z" => min($pos1["z"], $pos2["z"])];
        $this->pos2 = ["x" => max($pos1["x"], $pos2["x"]), "z" => max($pos1["z"], $pos2["z"])];
        $this->floors = $floors;
        sort($this->floors);
        $this->levelName = $levelName;
        $this->spawn = $spawn;
    }
    
    public function getName(){
        return $this->name;
    }
        
    public function getGameHandler(){
        return $this->gameHandler;
    }
    
    public function getPlayerHandler(){
        return $this->playerHandler;
    }

    public function getStatusManager(){
        return $this->statusManager;
    }
    
    public function getPlayerManager(){
        return $this->playerManager;
    }

    public function getPos1(){
        return $this->pos1;
    }

    public function getPos2(){
        return $this->pos2;
    }

    public function getFloors(){
        return $this->floors;
    }

    public function getLowestFloorY(){
        return $this->floors[0];
    }

    public function getHighestFloorY(){
        return $this->floors[count($this->floors) - 1];
    }

    public function getLevelName(){
        return $this->levelName;
    }

    public function getSpawn(){
        return new Position($this->spawn["x"], $this->spawn["y"], $this->spawn["z"], $this->tntRun->getServer()->getLevelByName($this->levelName));
    }
}
