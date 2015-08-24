<?php

namespace TNTRun\commands;

use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class InfoSubCmd extends SubCmd{

    public function execute(CommandSender $sender, array $args){
        $sender->sendMessage(TextFormat::GREEN."----TnTRun About----");
        $sender->sendMessage(TextFormat::GREEN."To play click the sign");
        $sender->sendMessage(TextFormat::GREEN."Developed BY ItaDevs4PM");
        return true;
    }

}