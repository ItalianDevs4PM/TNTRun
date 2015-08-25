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
        if(!isset($this->getMain()->selection[strtolower($sender->getName())]["pos1"])){
            $sender->sendMessage(TextFormat::RED . "Please specify pos 1 first");
            return true;
        }
        if(!isset($this->getMain()->selection[strtolower($sender->getName())]["pos2"])){
            $sender->sendMessage(TextFormat::RED . "Please specify pos 2 first");
            return true;
        }
        if($this->getMain()->selection[strtolower($sender->getName())]["pos1"]["level"] !== $this->getMain()->selection[strtolower($sender->getName())]["pos2"]["level"]){
            $sender->sendMessage(TextFormat::RED . "Positions are in different levels");
            return true;
        }
        $this->getMain()->getServer()->getScheduler()->scheduleDelayedTask(new AddfloorTask(
            $this->getMain(),
            $this->getMain()->selection[strtolower($sender->getName())]["pos1"],
            $this->getMain()->selection[strtolower($sender->getName())]["pos2"],
            $sender->getFloorY(),
            $sender->getLevel()
            ), 10
        );
        $sender->sendMessage(TextFormat::GREEN . "Floor created");
        unset($this->getMain()->selection[strtolower($sender->getName())]);
        return true;
    }
}
