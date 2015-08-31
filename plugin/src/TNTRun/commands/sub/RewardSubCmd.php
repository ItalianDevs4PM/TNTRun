<?php

namespace TNTRun\commands\sub;


use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use TNTRun\commands\SubCmd;

class RewardSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(!isset($args[0]) || !is_numeric($args[0])){
            $sender->sendMessage(TextFormat::RED . "Please specify a valid value of money!");
            return true;
        }
        $this->getMain()->getConfig()->set("money-reward", $args[0]);
        $this->getMain()->getConfig()->save();
        $sender->sendMessage(TextFormat::GREEN ."The award in money is now ".$args[0]);
        return true;
    }
}