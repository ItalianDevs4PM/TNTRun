<?php

namespace TNTRun\tasks;

use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\scheduler\PluginTask;
use TNTRun\Main;

class AddfloorTask extends PluginTask{

    private $pos1;
    private $pos2;
    private $level;
    private $blocks;
    private $interval;

    public function __construct(Main $tntrun, array $pos1, array $pos2, Level $level, $id, $blocks = 50, $interval = 10){
        parent::__construct($tntrun);
        $this->pos1 = $pos1;
        $this->pos2 = $pos2;
        $this->level = $level;
        $this->blocks = $blocks;
        $this->interval = $interval;
        $this->tntrun = $tntrun;
    }
    public function onRun($tick){
        $blocks = 0;
        for($x = $this->pos1[0]; $x <= $this->pos2[0]; $x++){
            for($y = $this->pos1[1]; $y <= $this->pos2[1]; $y++){
                for($z = $this->pos1[2]; $z <= $this->pos2[2]; $z++){
                    $block = $this->getMain()->getConfig()->get("block");
                    $this->level->setBlock(new Vector3($x, $y, $z), Block::get($block));
                    $blocks += 1;
                    if($blocks >= $this->blocks){
                        $this->getOwner()->getServer()->getScheduler()->scheduleDelayedTask($this, $this->interval);
                        return;
                    }
                    $this->pos1[2]++;
                }
                $this->pos1[1]++;
            }
            $this->pos1[0]++;
        }
    }
