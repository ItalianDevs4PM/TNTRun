<?php
namespace TNTRun\arena\status;

use TNTRun\arena\Arena;
use pocketmine\Player;

class PlayersManager{
    /** @var Arena */
    private $arena;
    /** @var Player[] */
    private $players, $spectators;
    
    public function __construct(Arena $arena){
        $this->arena = $arena;
    }
    
    public function isInArena(Player $player){
        $player = strtolower($player->getName());
        return isset($this->players[$player]) or isset($this->spectators[$player]);
    }
    
    public function getPlayersCount(){
        return count($this->players);
    }
    
    public function getPlayers(){
        return array_values($this->players);
    }

    public function getAllPlayers(){
        return array_merge(array_values($this->players), array_values($this->spectators));
    }
    
    public function addPlayer(Player $player){
        foreach($this->players as $name => $plr){
            $plr->sendMessage("The player ".$player->getName()." has joined the match!");
        }
        $this->players[strtolower($player->getName())] = $player;
        $this->update();
    }

    private function update(){
        $this->arena->getMain()->getSign()->reloadSign($this->arena);
    }

    public function removePlayer(Player $player){
        $player = strtolower($player->getName());
        if(isset($this->players[$player])){
            unset($this->players[$player]);
        }
        if(isset($this->spectators[$player])){
            unset($this->spectators[$player]);
        }
        $this->update();
    }

    public function isPlaying(Player $player){
        return isset($this->players[strtolower($player->getName())]);
    }

    public function isSpectator(Player $player){
        return isset($this->spectators[strtolower($player->getName())]);
    }
    
    public function addSpectator(Player $player){
        unset($this->players[strtolower($player->getName())]);
        $this->spectators[strtolower($player->getName())] = $player;
        $this->update();
    }
    
    public function removeSpectator(Player $player){
        if(isset($this->spectators[strtolower($player->getName())])){
            unset($this->spectators[strtolower($player->getName())]);
        }
        $this->update();
    }
    
    public function getSpectators(){
        return array_values($this->spectators);
    }
}

