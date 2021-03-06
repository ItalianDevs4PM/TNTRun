<?php

namespace TNTRun\commands\Sub;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use TNTRun\commands\SubCmd;

class SetMaxPlayersSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(!($sender instanceof Player)){
            $sender->sendMessage($this->getMessage("error.in-game"));
            return true;
        }
        if(!(isset($args[0]))){
            $sender->sendMessage($this->getMessage("commands.setmaxplayers.error.number"));
            return true;
        }else{
            if(is_numeric($args[0])){
                foreach($this->getMain()->arenas as $arena) {
                    if($arena->getPlayerManager()->isInArena($sender)) {
                        $arena->getStructureManager()->setMaxPlayers($args[0]);
                        $sender->sendMessage($this->getMessage("commands.setmaxplayers.set", ["NUM" => $args[0]]));
                        return true;
                    }
                }
            }
        }
        $sender->sendMessage($this->getMessage("commands.setmaxplayers.error.arena"));
        return true;
    }

    public function getInfo(){
        return $this->getMessage("commands.setmaxplayers.info");
    }
}
