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
        $this->tntRun->getPlayerData()->storePlayer($player);
        $this->arena->getPlayerManager()->addPlayer($player);
        $player->teleport($this->arena->getStructureManager()->getSpawn());
        $player->sendMessage("You are now in arena: ".$this->arena->getName());
    }
    
    public function spectatePlayer(Player $player){
        if($this->arena->getPlayerManager()->getPlayersCount() === 1 and $this->arena->getStatusManager()->isRunning()){
            $this->arena->getGameHandler()->stopArena();
        }
        $this->tntRun->getPlayerData()->storePlayer($player);
        $this->arena->getPlayerManager()->addSpectator($player);
        $player->teleport($this->arena->getStructureManager()->getSpawn());
        $player->setGamemode(Player::SPECTATOR);
        $player->sendMessage("You are now spectating in arena: ".$this->arena->getName());
    }
    
    public function leavePlayer(Player $player){
        $this->arena->getPlayerManager()->removePlayer($player);
        if($player->isOnline()){
            $player->sendMessage("You left the arena ".$this->arena->getName());
            $this->tntRun->getPlayerData()->restorePlayer($player);
        }
        if($this->arena->getPlayerManager()->getPlayersCount() === 1 and $this->arena->getStatusManager()->isRunning()){
            $this->arena->getGameHandler()->stopArena();
        }
    }
    
    public function leaveSpectator(Player $player){
        $this->arena->getPlayerManager()->removeSpectator($player);
        if($player->isOnline()){
            $player->sendMessage("You are no longer spectating the arena ".$this->arena->getName());
            $this->tntRun->getPlayerData()->restorePlayer($player);
        }
    }

    public function canJoin(Player $player){
        return ($this->arena->getPlayerManager()->getPlayersCount() < $this->arena->getStructureManager()->getMaxPlayer()) and !$this->arena->getStatusManager()->isStarting() and !$this->arena->getStatusManager()->isRunning();
    }
}
