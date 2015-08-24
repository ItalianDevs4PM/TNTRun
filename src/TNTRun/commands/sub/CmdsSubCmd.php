<?php

namespace TNTRun\commands\sub;

use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use TNTRun\commands\SubCmd;

class CmdsSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        $sender->sendMessage(TextFormat::GREEN."----Help For TnTRun----");
        $sender->sendMessage(TextFormat::GREEN."/tr cmds to see this list");
        $sender->sendMessage(TextFormat::GREEN."/tr stats for statistics");
        $sender->sendMessage(TextFormat::GREEN."/tr leave to exit the match");
        $sender->sendMessage(TextFormat::GREEN."/tr info for TnTRun informations");
        return true;
    }

}