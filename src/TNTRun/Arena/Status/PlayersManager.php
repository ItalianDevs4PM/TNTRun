<?php
namespace TNTRun\Arena\Status;

use TNTRun\Main;
use TNTRun\Arena\Handlers;
use TNTRun\Arena;
use pocketmine\Player;
class PlayersManager{
    
    private $arena;
    /** @var array */    
    private $players, $spectators;
    
    public function __construct(Arena $arena){
        $this->arena = $arena;
    }
    
    public function isInArena(Player $player){
        $player = strtolower($player->getName());
        if(isset($this->players[$player]))
            return true;
        if(isset($this->spectators[$player]))
            return true;
        return false;
    }
    
    public function getPlayersCount(){
        return count($this->players);
    }
    
    public function getPlayers(){
        return $this->players;
    }
    
    public function getAllPlayers(){
        return array_merge($this->players, $this->spectators);
    }
    
    public function addPlayer(Player $player){
        $this->players[strtolower($player->getName())] = $player;        
    }
    
    public function removePlayer(Player $player){
        $player = strtolower($player->getName());
        if(isset($this->players[$player]))
            unset($this->players[$player]);
        if(isset($this->spectators[$player]))
            unset($this->spectators[$player]);
    }
    
    public function isSpectator(Player $player){
        if(isset($this->spectators[$player]))
            return true;
        return false;
    }
    
    public function addSpectator(Player $player){
        $this->spectators[strtolower($player->getName())] = $player;        
    }
    
    public function removeSpectator(Player $player){
        if(isset($this->spectators[$player]))
            unset($this->spectators[$player]);    
    }
    
    public function getSpectators(){
        return $this->spectators;
    }
}

