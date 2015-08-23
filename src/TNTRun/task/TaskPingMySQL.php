<?php

namespace TNTRun\Task;

use TNTRun\Main;
use pocketmine\scheduler\PluginTask;

class TaskPingMySQL extends PluginTask{
    /** @var Main */
    private $tntRun;
        
    public function __construct(Main $main){
        parent::__construct($main);
	
        $this->main = $main;
    }
        
    public function onRun($currentTick){
        $this->tntRun->getStats()->ping();
    }
}