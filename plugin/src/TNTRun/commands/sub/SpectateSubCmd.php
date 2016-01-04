<?php

namespace TNTRun\commands\sub;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use TNTRun\commands\SubCmd;

class SpectateSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(!($sender instanceof Player)){
            $sender->sendMessage($this->getMessage("error.in-game"));
            return true;
        }
        if(!isset($args[0])){
            $sender->sendMessage($this->getMessage("commands.spectate.valid"));
        }

        if(!isset($this->getMain()->arenas[strtolower($args[0])])){
            $sender->sendMessage($this->getMessage("commands.spectate.exists", ["ARENA" => $args[0]]));
            return true;
        }
        foreach($this->getMain()->arenas as $arena){
            if($arena->getPlayerManager()->isPlaying($sender)){
                $sender->sendMessage($this->getMessage("commands.spectate.in-game"));
                return true;
            }
        }
        if($this->getMain()->arenas[strtolower($args[0])]->getPlayerManager()->isInArena($sender)){
            $sender->sendMessage($this->getMessage("commands.spectate.already"));
            return true;
        }
        $this->getMain()->arenas[strtolower($args[0])]->getPlayerHandler()->spectatePlayer($sender);
        return true;
    }

    public function getInfo(){
        return $this->getMessage("commands.spectate.info");
    }
}
