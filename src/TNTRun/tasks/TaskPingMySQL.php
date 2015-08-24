<?php

namespace TNTRun\tasks;

use TNTRun\Main;
use pocketmine\scheduler\PluginTask;

class TaskPingMySQL extends PluginTask{
    /** @var Main */
    private $tntRun;
        
    public function __construct(Main $tntRun){
        parent::__construct($tntRun);
	
        $this->tntRun = $tntRun;
    }
        
    public function onRun($currentTick){
        $this->tntRun->getStats()->ping();
    }
}