<?php

namespace TNTRun\commands\Sub;

use pocketmine\Player;
use pocketmine\command\CommandSender;
use TNTRun\commands\SubCmd;

class SetMinPlayersSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(!($sender instanceof Player)){
            $sender->sendMessage($this->getMessage("error.in-game"));
            return true;
        }
        if(!(isset($args[1]))){
            $sender->sendMessage($this->getMessage("commands.setminplayers.error.number"));
            return true;
        }else{
            if(is_numeric($args[0])){
                foreach($this->getMain()->arenas as $arena) {
                    if($arena->getPlayerManager()->isInArena($sender)) {
                        $arena->getStructureManager()->setMinPlayers($args[0]);
                        $sender->sendMessage($this->getMessage("commands.setminplayers.set", ["NUM" => $args[0]]));
                        return true;
                    }
                }
            }
        }
        $sender->sendMessage($this->getMessage("commands.setminplayers.error.arena"));
        return true;
    }

    public function getInfo(){
        return $this->getMessage("commands.setminplayers.info");
    }
}
