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
        if($sender->hasPermission("tntrun.addfloor")){
            $pos1 = [$this->getMain()->selection[$sender->getName()]["pos1"][0], $this->getMain()->selection[$sender->getName()]["pos1"][1], $this->getMain()->selection[$sender->getName()]["pos1"][2]];
            $pos2 = [$this->getMain()->selection[$sender->getName()]["pos2"][0], $this->getMain()->selection[$sender->getName()]["pos2"][1], $this->getMain()->selection[$sender->getName()]["pos2"][2]];
            $this->getMain()->getServer()->getScheduler()->scheduleDelayedTask(new AddfloorTask($this->getMain(), $pos1, $pos2, $this->getMain()->selection[$sender->getName()]["pos1"][3], $args[0]), 10);
            return true;
        }else{
            $sender->sendMessage(TextFormat::RED . "You don't have permission to use this command!");
        }
        return true;
    }
}
