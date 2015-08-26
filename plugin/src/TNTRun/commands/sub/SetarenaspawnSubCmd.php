<?php

namespace TNTRun\commands\sub;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use TNTRun\commands\SubCmd;

class SetarenaspawnSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(!($sender instanceof Player)){
            $sender->sendMessage(TextFormat::YELLOW . "Please run this command in game!");
            return true;
        }
        foreach($this->getMain()->arenas as $arena){
            if($sender->hasPermission("tntrun.setarenaspawn")){
                $x = $sender->getFloorX();
                $y = $sender->getFloorY();
                $z = $sender->getFloorZ();
                $arena->getStructureManager()->setSpawn($x, $y, $z);
                $sender->sendMessage(TextFormat::GREEN . "Arena's spawn set to $x, $y, $z");
            }
        }
        return true;

    }
}
