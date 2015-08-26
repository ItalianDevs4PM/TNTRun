<?php

namespace TNTRun;

use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginBase;
use TNTRun\arena\Arena;
use TNTRun\commands\TNTRunCommand;
use TNTRun\stats\MySQLStatsProvider;
use TNTRun\stats\SQLiteStatsProvider;

class Main extends PluginBase{

    /** @var \TNTRun\stats\StatsProvider */
    private $stats;
    /** @var Arena[] */
    public $arenas = [];
    public $selection = [];
    /** @var SignHandler */
    private $signHandler;

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getLogger()->info(TextFormat::GREEN."TNTRun Enabled!");
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
        $this->signHandler = new SignHandler($this);
        $this->loadArenas();
    }

    public function getSign(){
        return $this->signHandler;
    }

    public function getStats(){
        return $this->stats;
    }

    public function onLoad(){
        $this->getLogger()->info(TextFormat::YELLOW."Loading TNTRun...");
    }

    public function onDisable(){
        $this->getLogger()->info(TextFormat::RED."TNTRun Disabled");
        $this->getConfig()->save();
        $this->saveArenas();
    }

    public function getSubCommands(){
        return $this->getFile()."src/". __NAMESPACE__."/commands/sub/";
    }

    public function getLobby(){
        $level = $this->getServer()->getLevelByName($this->getConfig()->get("lobby"));
        return $level !== null ? $level->getSafeSpawn() : $this->getServer()->getDefaultLevel()->getSafeSpawn();
    }

    private function loadArenas(){
        if(file_exists($this->getDataFolder()."arenas.yml")){
            $arenas = yaml_parse_file($this->getDataFolder()."arenas.yml");
            foreach($arenas as $data){
                $this->arenas[strtolower($data["name"])] = new Arena($this, $data);
            }
        }
    }

    private function saveArenas(){
        $save = [];
        foreach($this->arenas as $arena){
            $str = $arena->getStructureManager();
            $spawn = $str->getSpawn();
            $save[] = ["name" => $arena->getName(),
                "pos1" => [
                    "x" => $str->getPos1()["x"],
                    "z" => $str->getPos1()["z"]
                ],
                "pos2" => [
                    "x" => $str->getPos2()["x"],
                    "z" => $str->getPos2()["z"]
                ],
                "floors" => $str->getFloors(),
                "levelName" => $str->getLevelName(),
                "spawn" => ["x" => $spawn->x, "y" => $spawn->y, "z" => $spawn->z]
            ];
        }
        yaml_emit_file($this->getDataFolder()."arenas.yml", $save);
    }

}
