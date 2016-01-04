<?php

namespace TNTRun\commands\sub;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use TNTRun\commands\SubCmd;

class LobbySubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(!($sender instanceof Player)){
            $sender->sendMessage($this->getMessage("error.in-game"));
            return true;
        }
        foreach($this->getMain()->arenas as $arena){
            if($arena->getPlayerManager()->isInArena($sender)){
                if($arena->getPlayerManager()->isPlaying($sender)){
                    $arena->getPlayerHandler()->leavePlayer($sender);
                }else{
                    $arena->getPlayerHandler()->leaveSpectator($sender);
                }
                break;
            }
        }
        $level = $this->getMain()->getServer()->getLevelByName($this->getMain()->getConfig()->get("lobby"));
        if($level !== null){
            $sender->teleport($level->getSafeSpawn());
            $sender->sendMessage($this->getMessage("commands.lobby.teleport"));
        }else{
            $sender->sendMessage($this->getMessage("commands.lobby.error"));
        }
        return true;
    }

    public function getInfo(){
        return $this->getMessage("commands.lobby.info");
    }

}
