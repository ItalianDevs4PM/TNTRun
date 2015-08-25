<?php
namespace TNTRun\arena\status;

use TNTRun\arena\Arena;
use pocketmine\Player;

class PlayersManager{
    
    private $arena;
    /** @var Player[] */
    private $players, $spectators;
    
    public function __construct(Arena $arena){
        $this->arena = $arena;
    }
    
    public function isInArena(Player $player){
        $player = strtolower($player->getName());
        return isset($this->players[$player]) or isset($this->players[$player]);
    }
    
    public function getPlayersCount(){
        return count($this->players);
    }
    
    public function getPlayers(){
        return $this->players;
    }

    /**
     * @return Player[]
     */
    public function getAllPlayers(){
        return array_merge($this->players, $this->spectators);
    }
    
    public function addPlayer(Player $player){
        $this->players[strtolower($player->getName())] = $player;
    }
    
    public function removePlayer(Player $player){
        $player = strtolower($player->getName());
        if(isset($this->players[$player])){
            unset($this->players[$player]);
        }
        if(isset($this->spectators[$player])){
            unset($this->spectators[$player]);
        }
    }

    public function isPlaying(Player $player){
        return isset($this->players[strtolower($player->getName())]);
    }

    public function isSpectator(Player $player){
        return isset($this->spectators[strtolower($player->getName())]);
    }
    
    public function addSpectator(Player $player){
        $this->spectators[strtolower($player->getName())] = $player;
    }
    
    public function removeSpectator(Player $player){
        if(isset($this->spectators[strtolower($player->getName())])){
            unset($this->spectators[strtolower($player->getName())]);
        }
    }
    
    public function getSpectators(){
        return $this->spectators;
    }

}

