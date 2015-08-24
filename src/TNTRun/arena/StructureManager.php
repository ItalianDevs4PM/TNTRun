<?php

namespace TNTRun\arena;

use pocketmine\level\Position;
use TNTRun\Main;

class StructureManager{

    /** @var  Main */
    private $tntRun;
    /** @var array */
    private $pos1, $pos2, $floors, $spawn;   
    
    public function __construct(Main $tntRun, array $data){
        $this->tntRun = $tntRun;

        $this->pos1 = ["x" => min($data["pos1"]["x"], $data["pos2"]["x"]), "z" => min($data["pos1"]["z"], $data["pos2"]["z"])];
        $this->pos2 = ["x" => max($data["pos1"]["x"], $data["pos2"]["x"]), "z" => max($data["pos1"]["z"], $data["pos2"]["z"])];
        $this->floors = $data["floors"];
        sort($this->floors);
        $this->levelName = $data["levelName"];
        $this->spawn = $data["spawn"];
    }
    
    public function isInside(Position $pos){
        return ($pos->getLevel()->getName() === $this->levelName and
            $pos->x >= $this->pos1["x"] and
            $pos->x <= $this->pos2["x"] and
            $pos->z >= $this->pos1["z"] and
            $pos->z <= $this->pos2["z"] and
            $pos->y >= $this->floors[0] and
            $pos->y <= $this->floors[count($this->floors) - 1] + 1
        );
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
}