<?php

namespace TNTRun\commands;

use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class CmdsSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        $sender->sendMessage(TextFormat::GREEN."----Help For TnTRun----");
        $sender->sendMessage(TextFormat::GREEN."/tr help for help");
        $sender->sendMessage(TextFormat::GREEN."/tr stats for statistics");
        $sender->sendMessage(TextFormat::GREEN."/tr leave for exit the match");
        $sender->sendMessage(TextFormat::GREEN."/tr about info for TnTRun");
        return true;
    }

}