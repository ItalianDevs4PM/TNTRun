<?php

namespace TNTRun/Main;

use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener{

public function onEnable(){
$this->getServer()->getPluginManage()->registerEvents($this, $this);
$this->getLogger()->info(TextFormat::GREEN . "TNTRun Enabled!");
$this->saveDefaultConfig();
}

public function onLoad(){
$this->getLogger->info(TextFormat::YELLOW . "Loading TNTRun...");
}

public function onDisable(){
$this->getLogger()->info(TextFormat::RED . "TNTRun Disabled");
$this->getConfig()->save();
}
}
