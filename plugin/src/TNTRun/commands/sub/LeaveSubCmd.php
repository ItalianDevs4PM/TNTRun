<?php

namespace TNTRun\commands\sub;

use pocketmine\utils\TextFormat;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use TNTRun\commands\SubCmd;

class LeaveSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(!($sender instanceof Player)){
            $sender->sendMessage(TextFormat::YELLOW . "Please use this command in game!");
        }
        foreach($this->getMain()->arenas as $arena){
            if($arena->getPlayerManager()->isInArena($sender)){
                $arena->getPlayerHandler()->leavePlayer($sender);
                $sender->teleport($this->getMain()->getLobby());
                $sender->sendMessage(TextFormat::GREEN . "You have leaved the match. Teleporting to lobby...");
                return true;
            }
        }
        $sender->sendMessage(TextFormat::YELLOW . "You are not in arena!");
        return true;
    }

}
