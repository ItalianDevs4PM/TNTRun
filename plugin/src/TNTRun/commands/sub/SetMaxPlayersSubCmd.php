<?php

namespace TNTRun\commands\Sub;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use TNTRun\commands\SubCmd;

class SetMaxPlayersSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(!($sender instanceof Player)){
            $sender->sendMessage(TextFormat::YELLOW . "Please run this command in-game!");
            return true;
        }
        if(!(isset($args[2]))){
            $sender->sendMessage(TextFormat::YELLOW . "Please specify a valid number!");
        }else{
            if(is_numeric($args[2])){
                foreach($this->getMain()->arenas as $arena) {
                    if($arena->getPlayerManager()->isInArena($sender)) {
                        $arena->getStructureManager()->setMaxPlayers($args[2]);
                    }
                }
            }
        }
        return true;
    }
}