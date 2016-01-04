<?php

namespace TNTRun\arena;

use pocketmine\level\Position;
use TNTRun\Main;

class StructureManager{
    /** @var  Main */
    private $tntRun;
    /** @var array */
    private $pos1, $pos2, $floors, $spawn;
    /** @var int */
    private $minPlayer, $maxPlayer;
    
    public function __construct(Main $tntRun, array $data){
        $this->tntRun = $tntRun;

        $this->pos1 = ["x" => min($data["pos1"]["x"], $data["pos2"]["x"]), "z" => min($data["pos1"]["z"], $data["pos2"]["z"])];
        $this->pos2 = ["x" => max($data["pos1"]["x"], $data["pos2"]["x"]), "z" => max($data["pos1"]["z"], $data["pos2"]["z"])];
        $this->floors = $data["floors"];
        sort($this->floors);
        $this->levelName = $data["levelName"];
        $this->spawn = $data["spawn"];
        $this->minPlayer = isset($data["min_player"]) ? $data["min_player"] : 0;
        $this->maxPlayer = isset($data["max_player"]) ? $data["max_player"] : 1;
    }
    
    public function getPos1(){
        return $this->pos1;
    }

    public function getPos2(){
        return $this->pos2;
    }

    public function getFloors(){
        return $this->floors;
    }

    public function getLowestFloorY(){
        return $this->floors[0];
    }

    public function getHighestFloorY(){
        return $this->floors[count($this->floors) - 1];
    }

    public function getLevelName(){
        return $this->levelName;
    }

    public function getSpawn(){
        return new Position($this->spawn["x"], $this->spawn["y"], $this->spawn["z"], $this->tntRun->getServer()->getLevelByName($this->levelName));
    }

    public function getMaxPlayer(){
        return $this->maxPlayer;
    }

    public function getMinPlayer(){
        return $this->minPlayer;
    }

    public function setMaxPlayers($maxPlayer){
    $this->maxPlayer = $maxPlayer;
}

    public function setMinPlayers($minPlayer){
        $this->minPlayer = $minPlayer;
    }

    public function setSpawn($x, $y, $z){
        $this->spawn["x"] = $x;
        $this->spawn["y"] = $y;
        $this->spawn["z"] = $z;
    }
}
