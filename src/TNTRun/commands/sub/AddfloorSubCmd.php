<?php

namespace TNTRun\commands\Sub;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use TNTRun\commands\SubCmd;
use pocketmine\level\Level;
use TNTRun\tasks\AddfloorTask;

class AddfloorSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(!($sender instanceof Player)){
            $sender->sendMessage(TextFormat::YELLOW . "Please run this command in game!");
            return true;
        }
        if(!$sender->hasPermission("tntrun.addfloor")){
            $sender->sendMessage(TextFormat::RED . "You don't have permission to use this command!");
            return true;
        }
        /*$this->getMain()->getServer()->getScheduler()->scheduleDelayedTask(new AddfloorTask(
            $this->getMain(),
            $this->getMain()->selection[strtolower($sender->getName())]["pos1"],
            $this->getMain()->selection[strtolower($sender->getName())]["pos2"],
            $sender->getFloorY(),
            $sender->getLevel()
            ), 10
        );*/
        $this->getMain()->selection[strtolower($sender->getName())]["floors"][] = $sender->getFloorY();
        $sender->sendMessage(TextFormat::GREEN . "Floor created");
        return true;
    }
}
