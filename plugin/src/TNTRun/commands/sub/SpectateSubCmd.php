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
            $sender->sendMessage(TextFormat::RED . "Please specify a valid arena name!");
        }

        if(!isset($this->getMain()->arenas[strtolower($args[0])])){
            $sender->sendMessage(TextFormat::RED . "The arena ".$args[0]." does not exist");
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
            $sender->sendMessage(TextFormat::RED . "You can't spectate, you are in game!");
            return true;
        }
        if($this->getMain()->arenas[strtolower($args[0])]->getPlayerManager()->isInArena($sender)){
            $sender->sendMessage(TextFormat::RED . "You are already in that arena");
            return true;
        }
        $this->getMain()->arenas[strtolower($args[0])]->getPlayerHandler()->spectatePlayer($sender);
        return true;
    }
}
