<?php

namespace TNTRun\commands\sub;

use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use TNTRun\commands\SubCmd;

class HelpSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(isset($args[0])){
            $args[0] = strtolower($args[0]);
            if($args[0] === "cmds"){
                foreach($this->getMain()->getCommands()->getSubCommands() as $cmd)
                    $sender->sendMessage($cmd->getInfo());
                return true;
            }

            if($this->getMain()->getCommands()->getSubCommands()[$args[0]] instanceof SubCmd){
                $sender->sendMessage($this->getMain()->getCommands()->getSubCommands()[$args[0]]->getInfo());
                return true;
            }
        }
        $sender->sendMessage($this->getMain()->getTag().TextFormat::GREEN."---TNTRun---");
        foreach($this->getMain()->getCommands()->getSubCommands() as $cmd => $c){
            $sender->sendMessage($this->getMain()->getTag().TextFormat::AQUA."/tr ".$cmd. " = ".str_replace($this->getMain()->getTag(), "", $c->getInfo()));
        }
        $sender->sendMessage($this->getMain()->getTag().TextFormat::GREEN."Developed BY @ItalianDevs4PM");
        return true;
    }

    public function getInfo(){
        return $this->getMessage("commands.help.info");
    }
}
