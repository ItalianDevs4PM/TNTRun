<?php
namespace TNTRun\Arena;

use TNTRun\Main;
use TNTRun\Arena\Handlers;

class Arena{
    /** @var string */
    private $name;
    /** @var Main */
    private $tntRun;
    /** @var GameHandler */
    private $gameHandler;
    /** @var PlayerHandler */
    private $playerHandler;
    /** @var StatusManager */
    private $statusManager;
    /** @var PlayerManager */
    private $playerManager;
    
    public function __construct(string $name, Main $tntRun){
        $this->tntRun = $tntRun;
        $this->name = $name;
        
        $this->gameHandler = new GameHandlers($tntRun, $this);  
        $this->playerHandler = new Handlers\PlayerHandler($tntRun, $this);
        
        $this->statusManager = new StatusManager($this);
        $this->playerManager = new PlayerManager($this);       
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
}