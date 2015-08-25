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
        $this->getMain()->selection[strtolower($sender->getName())]["floors"][] = $sender->getFloorY();
        $sender->sendMessage(TextFormat::GREEN . "Floor created at ".$sender->getFloorY());
        return true;
    }
}
