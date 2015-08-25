<?php

namespace TNTRun\tasks;

use pocketmine\scheduler\PluginTask;
use TNTRun\arena\Arena;
use TNTRun\Main;

class CountDownTask extends PluginTask{

    public function __construct(Main $tntRun, Arena $arena){
        parent::__construct($tntRun);

        $this->tntRun = $tntRun;
        $this->arena = $arena;
    }

    public function onRun($tick){
        $this->arena->getGameHandler()->runArenaCountDown();
    }

}