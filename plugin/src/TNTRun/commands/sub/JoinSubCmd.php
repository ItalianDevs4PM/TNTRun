<?php

namespace TNTRun\commands\sub;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use TNTRun\commands\SubCmd;

class JoinSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(!($sender instanceof Player)){
            $sender->sendMessage($this->getMessage("error.in-game"));
            return true;
        }
        if(!isset($args[0])){
            $sender->sendMessage($this->getMessage("commands.join.error.valid"));
            return true;
        }
        if(!isset($this->getMain()->arenas[strtolower($args[0])])){
            $sender->sendMessage($this->getMessage("commands.join.error.exists", ["ARENA" => $args[0]]));
            return true;
        }
        $inGame = false;
        foreach($this->getMain()->arenas as $arena){
            if($arena->getPlayerManager()->isPlaying($sender)){
                $inGame = true;
                break;
            }
        }
        if($inGame){
            $sender->sendMessage($this->getMessage("commands.join.error.finish"));
            return true;
        }
        if($this->getMain()->arenas[strtolower($args[0])]->getPlayerManager()->isPlaying($sender)){
            $sender->sendMessage($this->getMessage("commands.join.error.already"));
            return true;
        }
        $this->getMain()->arenas[strtolower($args[0])]->getPlayerHandler()->spawnPlayer($sender);
        return true;
    }

    public function getInfo(){
        return $this->getMessage("commands.join.info");
    }
}
