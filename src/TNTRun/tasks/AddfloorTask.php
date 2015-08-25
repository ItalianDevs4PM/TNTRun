<?php

namespace TNTRun\tasks;

use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\scheduler\PluginTask;
use TNTRun\Main;

class AddfloorTask extends PluginTask
{

    private $pos1, $pos2, $floor, $level, $blocks = 50, $interval = 10;

    public function __construct(Main $tntRun, array $pos1, array $pos2, $floor, Level $level){
        parent::__construct($tntRun);
        $this->pos1 = $pos1;
        $this->pos2 = $pos2;
        $this->level = $level;
        $this->floor = $floor;
        $this->tntRun = $tntRun;
    }
    public function onRun($tick){
        $blocks = 0;
        for($x = $this->pos1["x"]; $x <= $this->pos2["x"]; $x++){
            for($z = $this->pos1["z"]; $z <= $this->pos2["z"]; $z++){
                $block = $this->tntRun->getConfig()->get("block-id");
                $this->level->setBlock(new Vector3($x, $this->floor, $z), Block::get($block));
                $blocks += 1;
                if($blocks >= $this->blocks){
                    $this->getOwner()->getServer()->getScheduler()->scheduleDelayedTask($this, $this->interval);
                    return;
                }
                $this->pos1["z"]++;
            }
            $this->pos1["x"]++;
        }
    }
}
