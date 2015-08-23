<?php
namespace TNTRun\Arena\Handlers;

use TNTRun\Match\Arena;
use pocketmine\Player;

class Handler{
    /** @var Main */
    private $tntRun;
    /** @var Arena */
    private $arena;
    
    public function __construct(Main $tntRun, Arena $arena){
        $this->tntRun = $tntRun;
        $this->arena = $arena;
    }
    
    public function runArenaCountDown(){  
        
    }
    
    public function stopArenaCountDown(){
        
    }
    
    public function startArena(){
        
    }
    
    public function stopArena(){
        
    }
    
    public function handlePlayer(Player $player){
        
    }
    
    public function startArenaRegen(){
        
    }
    
    public function startEnding(Player $player){
        
    }
    
}
