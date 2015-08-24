<?php
namespace TNTRun\arena\handlers;

use pocketmine\block\Block;
use pocketmine\math\Vector3;
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
        $block = Block::get($this->tntRun->getConfig()->get("block"));
        $level = $this->tntRun->getServer()->getLevelByName($this->arena->getLevelName());
        foreach($this->arena->getFloors() as $floorY){
            for($x = $this->arena->getPos1()["x"]; $x <= $this->arena->getPos2()["x"]; $x++){
                for($z = $this->arena->getPos1()["z"]; $z <= $this->arena->getPos2()["z"]; $z++){
                    $level->setBlock(new Vector3($x, $floorY, $z), $block);
                }
            }
        }
        $this->arena->getStatusManager()->setRegenerating(false);
    }
    
    public function startEnding(Player $player){
        
    }
    
}
