<?php 

namespace TNTRun\Match;

use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\Player;
use TNTRun\Main;
//use pocketmine\event\player\PlayerMoveEvent;

class Arena{

    public function __construct(Main $tntRun, $levelName, array $pos1, array $pos2, array $floors){
        $this->tntRun = $tntRun;
        $this->levelName = $levelName;
        $this->pos1 = [min($pos1["x"], $pos2["x"]), min($pos1["z"], $pos2["z"])];
        $this->pos2 = [max($pos1["x"], $pos2["x"]), max($pos1["z"], $pos2["z"])];
        $this->floors = $floors;
        sort($this->floors);
        $this->game = false;
        $this->players = [];
    }

    public function isInside(Player $player){
        return ($player->getLevel()->getName() === $this->levelName and
            $player->x >= $this->pos1["x"] and
            $player->x <= $this->pos2["x"] and
            $player->z >= $this->pos1["z"] and
            $player->z <= $this->pos2["z"] and
            $player->y >= $this->floors[0] and
            $player->y <= $this->floors[count($this->floors) - 1] + 1
        );
    }

    public function getFloor(Player $player){
        foreach($this->floors as $key => $floorY){
            if($player->getFloorY() === $floorY + 1){
                return $key;
            }
        }
        return null;
    }

    public function resetBlocks(){
        $block = Block::get($this->tntRun->getConfig()->get("block"));
        $level = $this->tntRun->getServer()->getLevelByName($this->levelName);
        foreach($this->floors as $floorY){
            for($x = $this->pos1["x"]; $x <= $this->pos2["x"]; $x++){
                for($z = $this->pos1["z"]; $z <= $this->pos2["z"]; $z++){
                    $level->setBlock(new Vector3($x, $floorY, $z), $block);
                }
            }
        }
    }

}

/*
public function onPlayerInteract(PlayerInteract $e){
    $player = $e->getPlayer();
    $id = $e->getBlock()->getId();
    if($player->hasPermission("tntrun.signjoin") or $player->hasPermission("tntrun.*")){
        if($id == 63 or $block == 68){
        }
    }
}*/

/*
public function OnMove(PlayerMoveEvent $e){
$id = $e->getBlock()->getId();
$blocktoair = $e->getBlock();
$blockname = $this->getConfig()->get("block");
$block =  $event->getPlayer()->getLevel()->getBlock($event->getPlayer()->floor();
if($id == $block){
}
}
*/
