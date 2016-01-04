<?php

namespace TNTRun\commands\sub;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use TNTRun\commands\SubCmd;

class SetArenaSpawnSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(!($sender instanceof Player)){
            $sender->sendMessage($this->getMessage("error.in-game"));
            return true;
        }
        foreach($this->getMain()->arenas as $arena){
            if($arena->getPlayerManager()->isInArena($sender)){
                $x = $sender->getFloorX();
                $y = $sender->getFloorY();
                $z = $sender->getFloorZ();
                $arena->getStructureManager()->setSpawn($x, $y, $z);
                $sender->sendMessage($this->getMessage("commands.setarenaspawn.set", ["POS" => "$x, $y, $z"]));
                return true;
            }
        }
        $sender->sendMessage($this->getMessage("commands.setarenaspawn.error"));
        return true;
    }

    public function getInfo(){
        return $this->getMessage("commands.setarenaspawn.info");
    }
}
