<?php

namespace TNTRun\tasks;

use pocketmine\block\Block;
use pocketmine\scheduler\PluginTask;
use TNTRun\Main;

class UnsetBlockTask extends PluginTask{

    private $tntRun;
    private $block;

    public function __construct(Main $tntRun, Block $block){
        parent::__construct($tntRun);

        $this->tntRun = $tntRun;
        $this->block = $block;
    }

    public function onRun($tick){
        $this->block->getLevel()->setBlock($this->block, Block::get(Block::AIR));
    }

}