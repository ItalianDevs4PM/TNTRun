<?php

namespace TNTRun\commands\Sub;

use pocketmine\Player;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use TNTRun\commands\SubCmd;

class SetMinPlayersSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(!($sender instanceof Player)){
            $sender->sendMessage(TextFormat::YELLOW . "Please run this command in-game!");
            return true;
        }
        if(!(isset($args[1]))){
            $sender->sendMessage(TextFormat::YELLOW . "Please specify a valid number!");
        }else{
            if(is_numeric($args[1])){
                foreach($this->getMain()->arenas as $arena) {
                    if($arena->getPlayerManager()->isInArena($sender)) {
                        $arena->getStructureManager()->setMinPlayers($args[1]);
                    }
                }
            }
        }
        return true;
    }
}
