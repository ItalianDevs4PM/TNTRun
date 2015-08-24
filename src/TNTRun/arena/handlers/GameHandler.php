<?php
namespace TNTRun\arena\handlers;

use TNTRun\arena\Arena;
use TNTRun\Main;
use pocketmine\Player;

class GameHandler{
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
