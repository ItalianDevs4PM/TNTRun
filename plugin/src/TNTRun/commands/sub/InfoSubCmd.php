<?php

namespace TNTRun\commands\sub;

use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use TNTRun\commands\SubCmd;

class InfoSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        $sender->sendMessage(TextFormat::GREEN."----TnTRun About----");
        $sender->sendMessage(TextFormat::GREEN."To play click the sign");
        $sender->sendMessage(TextFormat::GREEN."Developed BY ItalianDevs4PM");
        return true;
    }

}
