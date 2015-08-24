<?php

namespace TNTRun\commands\sub;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use TNTRun\commands\SubCmd;

class LobbySubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(!($sender instanceof Player)){
            $sender->sendMessage("Please run this command in game");
            return true;
        }
        $level = $this->tntRun->getServer()->getLevelByName($this->tntRun->getConfig()->get("lobby"));
        if($level !== null){
            $sender->teleport($level->getSafeSpawn());
            $sender->sendMessage("Teleported to lobby");
        }else{
            $sender->sendMessage("Lobby level isn't loaded or doesn't exist");
        }
        return true;
    }

}