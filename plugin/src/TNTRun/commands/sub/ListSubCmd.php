<?php

namespace TNTRun\commands\sub;

use pocketmine\command\CommandSender;
use TNTRun\commands\SubCmd;

class ListSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        $ret = "";
        foreach($this->getMain()->arenas as $name => $class){
            if($ret !== "")
                $ret .= ", ";
            $ret .= $name;
        }
        $sender->sendMessage($this->getMessage("commands.list.arenas", ["COUNT" => count($this->getMain()->arenas)]));
        if(count($this->getMain()->arenas) !== 0)
            $sender->sendMessage($this->getMain()->getTag().$ret);
    }

    public function getInfo(){
        return $this->getMessage("commands.list.info");
    }
}