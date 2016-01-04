<?php

namespace TNTRun\commands\sub;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use TNTRun\arena\Arena;
use TNTRun\commands\SubCmd;

class CreateSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        if(!($sender instanceof Player)){
            $sender->sendMessage($this->getMessage("error.in-game"));
            return true;
        }
        if(!isset($this->getMain()->selection[strtolower($sender->getName())]["pos1"])){
            $sender->sendMessage($this->getMessage("commands.create.error.pos1"));
            return true;
        }
        if(!isset($this->getMain()->selection[strtolower($sender->getName())]["pos2"])){
            $sender->sendMessage($this->getMessage("commands.create.error.pos1"));
            return true;
        }
        if($this->getMain()->selection[strtolower($sender->getName())]["pos1"]["level"] !== $this->getMain()->selection[strtolower($sender->getName())]["pos2"]["level"]){
            $sender->sendMessage($this->getMessage("commands.create.error.pos"));
            return true;
        }
        if(!isset($this->getMain()->selection[strtolower($sender->getName())]["floors"])){
            $sender->sendMessage($this->getMessage("commands.create.error.floor"));
            return true;
        }
        if(!isset($args[0])){
            $sender->sendMessage($this->getMessage("commands.create.error.arena"));
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
            "spawn" => ["x" => $sender->getFloorX(), "y" => $sender->getFloorY(), "z" => $sender->getFloorZ()]
        ]);
        $sender->sendMessage($this->getMessage("commands.create.error.arena"));
        unset($this->getMain()->selection[strtolower($sender->getName())]);
        return true;
    }

    public function getInfo(){
        return $this->getMessage("commands.create.info");
    }

}