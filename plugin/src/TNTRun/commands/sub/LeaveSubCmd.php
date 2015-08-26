<?php

namespace TNTRun\commands\sub;

use pocketmine\utils\TextFormat;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use TNTRun\commands\SubCmd;
use TNTRun\Main;
use TNTRun\arena;

class LeaveSubCmd extends SubCmd{
    private $tntRun;

    public function __construct(Main $tntRun){
        $this->tntRun = $tntRun;
    }

    public function execute(CommandSender $sender, array $args){
        if(!($sender instanceof Player)){
            $sender->sendMessage(TextFormat::YELLOW . "Please use this command in game!");
        }
        foreach($this->tntRun->arenas as $arena){
            if($arena->getPlayerManager()->isInArena($sender)){
                $arena->getPlayerHandler()->leavePlayer($sender);
                $level = $this->getMain()->getConfig()->get("level");
                $sender->teleport($level->getSafeSpawn());
                $sender->sendMessage(TextFormat::GREEN . "You have leaved the match. Teleporting to lobby...");
            }else{
                $sender->sendMessage(TextFormat::YELLOW . "You are not in arena!");
            }
            return true;
        }
        return true;
    }
}
