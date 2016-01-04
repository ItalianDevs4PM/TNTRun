<?php

namespace TNTRun\commands\sub;

use pocketmine\command\CommandSender;
use TNTRun\commands\SubCmd;

class RewardSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(!isset($args[0]) || !is_numeric($args[0])){
            $sender->sendMessage($this->getMessage("commands.reward.error"));
            return true;
        }
        $this->getMain()->getConfig()->set("moneyreward", $args[0]);
        $this->getMain()->getConfig()->save();
        $sender->sendMessage($this->getMessage("commands.reward.award", ["AWARD" => $args[0]]));
        return true;
    }

    public function getInfo(){
        return $this->getMessage("commands.reward.info");
    }
}