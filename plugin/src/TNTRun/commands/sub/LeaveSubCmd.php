<?php

namespace TNTRun\commands\sub;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use TNTRun\commands\SubCmd;

class LeaveSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(!($sender instanceof Player)){
            $sender->sendMessage($this->getMessage("error.in-game"));
            return true;
        }
        foreach($this->getMain()->arenas as $arena){
            if($arena->getPlayerManager()->isInArena($sender)){
                $arena->getPlayerHandler()->leavePlayer($sender);
                $sender->teleport($this->getMain()->getLobby());
                $sender->sendMessage($this->getMessage("commands.leave.lefts"));
                return true;
            }
        }
        $sender->sendMessage($this->getMessage("commands.leave.error"));
        return true;
    }

    public function getInfo(){
        return $this->getMessage("commands.leave.info");
    }
}
