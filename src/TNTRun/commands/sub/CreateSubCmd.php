<?php

namespace TNTRun\commands\sub;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use TNTRun\arena\Arena;
use TNTRun\commands\SubCmd;

class CreateSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(!($sender instanceof Player)){
            $sender->sendMessage(TextFormat::YELLOW . "Please run this command in game!");
            return true;
        }
        if(!$sender->hasPermission("tntrun.addfloor")){
            $sender->sendMessage(TextFormat::RED . "You don't have permission to use this command!");
            return true;
        }
        if(!isset($this->getMain()->selection[strtolower($sender->getName())]["pos1"])){
            $sender->sendMessage(TextFormat::RED . "Please specify pos 1 first");
            return true;
        }
        if(!isset($this->getMain()->selection[strtolower($sender->getName())]["pos2"])){
            $sender->sendMessage(TextFormat::RED . "Please specify pos 2 first");
            return true;
        }
        if($this->getMain()->selection[strtolower($sender->getName())]["pos1"]["level"] !== $this->getMain()->selection[strtolower($sender->getName())]["pos2"]["level"]){
            $sender->sendMessage(TextFormat::RED . "Positions are in different levels");
            return true;
        }
        if(!isset($this->getMain()->selection[strtolower($sender->getName())]["floors"])){
            $sender->sendMessage(TextFormat::RED . "Select floors first");
            return true;
        }
        if(!isset($args[0])){
            $sender->sendMessage(TextFormat::RED . "Please specify an arena name");
            return true;
        }
        $this->getMain()->arenas[strtolower($args[0])] = new Arena($this->getMain(), [
            "name" => $args[0],
            "pos1" => [
                "x" => $this->getMain()->selection[strtolower($sender->getName())]["pos1"]["x"],
                "z" => $this->getMain()->selection[strtolower($sender->getName())]["pos1"]["z"]
            ],
            "pos2" => [
                "x" => $this->getMain()->selection[strtolower($sender->getName())]["pos2"]["x"],
                "z" => $this->getMain()->selection[strtolower($sender->getName())]["pos2"]["z"]
            ],
            "floors" => $this->getMain()->selection[strtolower($sender->getName())]["floors"],
            "levelName" => $this->getMain()->selection[strtolower($sender->getName())]["pos1"]["level"],
            "spawn" => ["x" => $sender->getFloorX(), "y" => $sender->getFloorY(), "z" => $sender->getFloorZ()] //todo setspawn subcmd
        ]);
        $sender->sendMessage(TextFormat::GREEN . "Arena created. Spawn pos set to current location");
        return true;
    }

}