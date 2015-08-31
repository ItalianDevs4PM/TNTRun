<?php
namespace TNTRun\arena\handlers;

use TNTRun\arena\Arena;
use TNTRun\Main;
use pocketmine\Player;
use TNTRun\tasks\AddfloorTask;
use TNTRun\tasks\CountDownTask;
use TNTRun\tasks\GameTask;

class GameHandler{

    /** @var Main */
    private $tntRun;
    /** @var Arena */
    private $arena;
    /** @var int */
    private $countDownTaskId;
    /** @var int */
    private $countDownSeconds;
    /** @var int */
    private $gameTaskId;
    /** @var  int */
    private $gameMinutes;
    
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
                $this->stopArenaCountDown();
            }
        }
    }
    
    public function stopArenaCountDown(){
        $this->tntRun->getServer()->getScheduler()->cancelTask($this->countDownTaskId);
        if($this->arena->getPlayerManager()->getPlayersCount() >= $this->tntRun->getConfig()->get("min-players")){
            $this->startArena();
        }else{
            foreach($this->arena->getPlayerManager()->getAllPlayers() as $player){
                $player->sendMessage("There aren't enough players to begin the match");
            }
            $this->startArenaCountDown();
        }
    }
    
    public function startArena(){
        $this->arena->getStatusManager()->setRunning();
        $this->gameMinutes = $this->tntRun->getConfig()->get("game-minutes");
        foreach($this->arena->getPlayerManager()->getAllPlayers() as $player) {
            $player->sendMessage("The match is started!");
            $this->tntRun->getStats()->addMatch($player->getName());
        }
        $this->gameTaskId = $this->tntRun->getServer()->getScheduler()->scheduleDelayedRepeatingTask(new GameTask($this->tntRun, $this->arena), 1200, 1200)->getTaskId();
    }

    public function runGame(){
        if($this->gameMinutes > 0){
            foreach($this->arena->getPlayerManager()->getAllPlayers() as $player){
                $player->sendMessage("The match will end in " . $this->gameMinutes);
            }
        }else{
            $this->stopArena();
        }
    }

    public function stopArena(){
        foreach($this->arena->getPlayerManager()->getAllPlayers() as $player){
            $this->arena->getPlayerHandler()->leavePlayer($player);
            $player->sendMessage("The match is finished.");
            $this->tntRun->getStats()->addWin($player->getName());
            if($this->tntRun->getConfig()->get("money-reward") > 0){
                $this->tntRun->getMoneyManager()->addMoney($player->getName(), $this->tntRun->getConfig()->get("money-reward"));
            }
            $player->sendMessage("Congratulations you won the match!");
        }
        $this->arena->getStatusManager()->setRunning(false);
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
        $this->arena->getStatusManager()->setRegenerating(false);
    }
    
}
