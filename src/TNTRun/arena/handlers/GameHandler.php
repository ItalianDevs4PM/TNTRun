<?php
namespace TNTRun\arena\handlers;

use TNTRun\arena\Arena;
use TNTRun\Main;
use pocketmine\Player;
use TNTRun\tasks\CountDownTask;

class GameHandler{
    /** @var Main */
    private $tntRun;
    /** @var Arena */
    private $arena;
    /** @var int */
    private $countDownTaskId;
    /** @var int */
    private $countDownSeconds = 30;
    
    public function __construct(Main $tntRun, Arena $arena){
        $this->tntRun = $tntRun;
        $this->arena = $arena;
    }

    public function startArenaCountDown(){
        $this->countDownTaskId = $this->tntRun->getServer()->getScheduler()->scheduleDelayedRepeatingTask(new CountDownTask($this->tntRun, $this->arena), 20, 20)->getTaskId();
        $this->arena->getStatusManager()->setStarting();
    }
    
    public function runArenaCountDown(){  
        $this->countDownSeconds--;
        if($this->countDownSeconds > 0){
            foreach($this->arena->getPlayerManager()->getAllPlayers() as $p){
                $p->sendMessage("Match starting in ".$this->countDownSeconds);
            }
        }else{
            $this->stopArenaCountDown();
        }
    }
    
    public function stopArenaCountDown(){
        $this->tntRun->getServer()->getScheduler()->cancelTask($this->countDownTaskId);
        if($this->arena->getPlayerManager()->getPlayersCount() >= $this->tntRun->getConfig()->get("min-players")){
            $this->startArena();
            $this->arena->getStatusManager()->setStarting(false);
        }else{
            foreach($this->arena->getPlayerManager()->getAllPlayers() as $p){
                $p->sendMessage("There aren't enough players to begin the match");
            }
            $this->startArenaCountDown();
        }
    }
    
    public function startArena(){
        $this->arena->getStatusManager()->setRunning();
        //todo
    }
    
    public function stopArena(){
        //todo
        $this->arena->getStatusManager()->setRunning(false);
        $this->startArenaRegen();
    }
    
    public function handlePlayer(Player $player){
        
    }
    
    public function startArenaRegen(){
        $this->arena->getStatusManager()->setRegenerating();
        //todo
        $this->arena->getStatusManager()->setRegenerating(false);
    }
    
    public function startEnding(Player $player){
        
    }
    
}
