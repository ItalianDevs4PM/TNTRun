<?php

namespace TNTRun;

use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use TNTRun\commands\TNTRunCommand;
use TNTRun\stats\MySQLStatsProvider;
use TNTRun\stats\SQLiteStatsProvider;

class Main extends PluginBase implements Listener{
    /** @var \TNTRun\stats\StatsProvider */
    private $stats;

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info(TextFormat::GREEN . "TNTRun Enabled!");
        $this->saveDefaultConfig();
        $this->getServer()->getCommandMap()->register("tntrun", new TNTRunCommand($this));
        switch(strtolower($this->getConfig()->get("stats-provider"))){
            case "sqlite3":
                $this->stats = new SQLiteStatsProvider($this);
                break;
            case "mysql":
                $this->stats = new MySQLStatsProvider($this);
                break;
            default:
                $this->stats = new SQLiteStatsProvider($this);
                break;
        }
    }
    
    /**
     * @return StatsProvider
     */
    public function getStats(){
        return $this->stats;
    }

    public function onLoad(){
        $this->getLogger()->info(TextFormat::YELLOW . "Loading TNTRun...");
    }

    public function onDisable(){
        $this->getLogger()->info(TextFormat::RED . "TNTRun Disabled");
        $this->getConfig()->save();
    }

    public function getCommandsPath(){
        return $this->getFile()."/src/". __NAMESPACE__."/commands/";
    }
}
