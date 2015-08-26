<?php

namespace TNTRun\commands\sub;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use TNTRun\commands\SubCmd;

class SpectateSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(!($sender instanceof Player)){
            $sender->sendMessage(TextFormat::YELLOW . "Please run this command in game!");
            return true;
        }
        if(!isset($args[0])){
            $sender->sendMessage(TextFormat::YELLOW . "Please specify a valid arena name!");
        }
        foreach($this->getMain()->arenas as $arena){
            if($arena->getPlayerManager()->isPlaying($sender)){
                $sender->sendMessage(TextFormat::RED . "You can't spectate,you are in game!");
            }else{
                $arena->getPlayerHandler()->spectatePlayer($sender);
            }
        }
        return true;
    }
}
