<?php
namespace TNTRun\arena;

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
    /** @var StructureManager */
    private $structureManager;
    
    public function __construct(Main $tntRun, array $data){
        $this->tntRun = $tntRun;
        $this->name = $data["name"];
        
        $this->gameHandler = new GameHandler($tntRun, $this);
        $this->playerHandler = new PlayerHandler($tntRun, $this);
        
        $this->statusManager = new StatusManager($this);
        $this->playerManager = new PlayersManager($this);
        $this->structureManager = new StructureManager($this->tntRun, $data);
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

    public function getStructureManager(){
        return $this->structureManager;
    }
}
