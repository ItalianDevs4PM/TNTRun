<?php

namespace TNTRun\tasks;

use TNTRun\Main;
use pocketmine\scheduler\PluginTask;
use TNTRun\stats\MySQLStatsProvider;

class TaskPingMySQL extends PluginTask{
    /** @var Main */
    private $tntRun;
        
    public function __construct(Main $tntRun){
        parent::__construct($tntRun);
	
        $this->tntRun = $tntRun;
    }
        
    public function onRun($currentTick){
        /** @var MySQLStatsProvider $stats */
        $stats = $this->tntRun->getStats();
        $stats->ping();
    }
}