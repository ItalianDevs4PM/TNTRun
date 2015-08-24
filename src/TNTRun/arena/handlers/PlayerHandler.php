<?php
namespace TNTRun\arena\handlers;

use TNTRun\arena\arena;
use TNTRun\Main;
use pocketmine\Player;

class PlayerHandler{
    /** @var Main */
    private $tntRun;
    /** @var Arena */
    private $arena;
    
    public function __construct(Main $tntRun, Arena $arena){
        $this->tntRun = $tntRun;
        $this->arena = $arena;
    }
    
    public function spawnPlayer(Player $player){

    }
    
    public function spectatePlayer(Player $player){
        
    }
    
    public function leavePlayer(Player $player){

    }
    
    
    
}
