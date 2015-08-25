<?php

namespace TNTRun\commands\sub;

use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use TNTRun\commands\SubCmd;
use pocketmine\Player;
use pocketmine\level\Level;

class Pos1SubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(!($sender instanceof Player)){
            $sender->sendMessage(TextFormat::YELLOW . "Please run this command in game!");
            return true;
        }
        $this->getMain()->selection[$sender->getName()]["pos1"] = [$sender->getFloorX(), $sender->getFloorY(), $sender->getFloorZ(), $sender->getLevel()];
        $sender->sendMessage(TextFormat::GREEN . "Pos 1 set to : ".$sender->getPosition()->floor());
        return true;
    }

}
