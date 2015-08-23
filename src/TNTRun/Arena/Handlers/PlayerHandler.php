<?php
namespace TNTRun\Arena\Handlers;

use TNTRun\Match\Arena;
use \pocketmine\Player;

class PlayerHandler{
    /** @var Main */
    private $tntRun;
    /** @var Arena */
    private $arena;
    
    public function __construct(Main $tntRun,  Arena $arena){
        $this->tntRun = $tntRun;
        $this->arena = $arena;
        
    }
    
    public function spawnPlayer(){}
    
    public function spectatePlayer(Player $player){
        
        
    }
    
    public function leavePlayer(Player $player){}
    
    
    
}