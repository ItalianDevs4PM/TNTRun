<?php
namespace TNTRun\arena\handlers;

use TNTRun\arena\Arena;
use TNTRun\Main;
use pocketmine\Player;
use TNTRun\tasks\AddfloorTask;
use TNTRun\tasks\CountDownTask;

class GameHandler{

    /** @var Main */
    private $tntRun;
    /** @var Arena */
    private $arena;
    /** @var int */
    private $countDownTaskId;
    /** @var int */
    private $countDownSeconds;
    
    public function __construct(Main $tntRun, Arena $arena){
        $this->tntRun = $tntRun;
        $this->arena = $arena;
    }

    public function startArenaCountDown(){
        $this->countDownSeconds = $this->tntRun->getConfig()->get("countdown");
        $this->countDownTaskId = $this->tntRun->getServer()->getScheduler()->scheduleDelayedRepeatingTask(new CountDownTask($this->tntRun, $this->arena), 20, 20)->getTaskId();
        $this->arena->getStatusManager()->setStarting();
    }
    
    public function runArenaCountDown(){  
        $this->countDownSeconds--;
        if($this->arena->getStatusManager()->isStarting()){
            if($this->countDownSeconds > 0) {
                foreach($this->arena->getPlayerManager()->getAllPlayers() as $p) {
                    $p->sendMessage("Match starting in " . $this->countDownSeconds);
                }
            }else{
                if(count($this->arena->getPlayerManager()->getAllPlayers()) < $this->tntRun->getConfig()->get("min-players")) {
                    $this->stopArenaCountDown();
                }else{
                    $this->arena->getStatusManager()->setRunning();
                    //TODO
                    $this->countDownSeconds = $this->tntRun->getConfig()->get("TODO");
                }
            }
        }else{
            foreach($this->arena->getPlayerManager()->getAllPlayers() as $player) {
                $player->sendMessage("The match will end in " . $this->countDownSeconds);
            }
        }
    }
    
    public function stopArenaCountDown(){
        $this->tntRun->getServer()->getScheduler()->cancelTask($this->countDownTaskId);
        if($this->arena->getPlayerManager()->getPlayersCount() >= $this->tntRun->getConfig()->get("min-players")){
            $this->startArena();
            $this->arena->getStatusManager()->setStarting(false);
        }else{
            foreach($this->arena->getPlayerManager()->getAllPlayers() as $player){
                $player->sendMessage("There aren't enough players to begin the match");
                $this->arena->getPlayerHandler()->leavePlayer($player);
            }
            $this->startArenaCountDown();
        }
    }
    
    public function startArena(){
        $this->arena->getStatusManager()->setRunning();
        foreach($this->arena->getPlayerManager()->getAllPlayers() as $player) {
            $player->sendMessage("The match is started!");
        }
    }
    
    public function stopArena(){
        foreach($this->arena->getPlayerManager()->getAllPlayers() as $player){
            $this->arena->getPlayerHandler()->leavePlayer($player);
        }

        $this->arena->getStatusManager()->setRegenerating();
        $this->startArenaRegen();
    }
    
    public function startArenaRegen(){
        $this->arena->getStatusManager()->setRegenerating();
        $level = $this->tntRun->getServer()->getLevelByName($this->arena->getStructureManager()->getLevelName());
        foreach($this->arena->getStructureManager()->getFloors() as $floorY){
            $this->tntRun->getServer()->getScheduler()->scheduleDelayedTask(new AddfloorTask(
                $this->tntRun,
                $this->arena->getStructureManager()->getPos1(),
                $this->arena->getStructureManager()->getPos2(),
                $floorY,
                $level), 10
            );
        }
        $this->arena->getStatusManager()->setRunning();
    }
    
    public function startEnding(Player $player){
        
    }
    
}
