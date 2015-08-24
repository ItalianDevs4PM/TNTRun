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
        $this->arena->getPlayerManager()->addPlayer($player);
        $player->teleport($this->arena->getStructureManager()->getSpawn());
        $player->sendMessage("You are now in arena: ".$this->arena->getName());
    }
    
    public function spectatePlayer(Player $player){
        $this->arena->getPlayerManager()->addSpectator($player);
        $player->teleport($this->arena->getStructureManager()->getSpawn());
        $player->setGamemode(Player::SPECTATOR);
        $player->sendMessage("You are now spectating in arena: ".$this->arena->getName());
    }
    
    public function leavePlayer(Player $player){
        $this->arena->getPlayerManager()->removePlayer($player);
        if($player->isOnline()){
            $player->sendMessage("You left the arena ".$this->arena->getName());
            $player->teleport($this->tntRun->getLobby());
        }
    }
    
    
    
}
