<?php

namespace TNTRun\commands\sub;

use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use TNTRun\commands\SubCmd;

class JoinSubCmd extends SubCmd{
    private $tntRun;

    public function execute(CommandSender $sender, array $args){
        if(!($sender instanceof Player)){
            $sender->sendMessage(TextFormat::YELLOW . "Please run this command in game!");
            return true;
        }
        foreach($this->getMain()->arenas as $arena){
        if(!isset($args[0])) {
            $sender->sendMessage(TextFormat::YELLOW . "Please specify a valid arena name!");
             }
            if($arena->getPlayerManager()->isInArena($sender) && $arena->getPlayerManager()->isPlaying($sender)){
                $sender->sendMessage(TextFormat::RED . "You are already in arena!");
            }else{
                $sender->teleport($this->tntRun->arenas[$args[0]]);
                $arena->getPlayerHandler()->spawnPlayer($sender);
                return true;
            }
        }
        return true;
    }
}
