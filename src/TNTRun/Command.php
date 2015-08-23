<?php

namespace TNTRun\Command;

use pocketmine\utils\TextFormat;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginIdentifiableCommand;

class Command extends Command implements PluginIdentifiableCommand{
    private $main;

    public function __construct(Main $main){
        parent::__construct("tr", "MiniGame", "/tr <command> <value>");
        $this->main = $main;
    }
    
    public function execute(CommandSender $sender, $label, array $args){    
        if(!isset($args) || !isset($args[0])) 
            $args[0] = "help";
        
        switch(strtolower($args[0])){
            case "help":
                $sender->sendMessage(TextFormat::GREEN . "----Help For TnTRun----");
                $sender->sendMessage(TextFormat::GREEN . "/tr help for help");
                $sender->sendMessage(TextFormat::GREEN . "/tr stats for statistics");
                $sender->sendMessage(TextFormat::GREEN . "/tr leave for exit the match");
                $sender->sendMessage(TextFormat::GREEN . "/tr about info for TnTRun");
            return;

            case "about":
                $block = $this->getConfig()->get("block");
                $sender->sendMessage(TextFormat::GREEN . "----TnTRun About----");
                $sender->sendMessage(TextFormat::GREEN . "For play click the sign");
                $sender->sendMessage(TextFormat::GREEN . "Run on the ".$block);
                $sender->sendMessage(TextFormat::GREEN . "Maked BY ItaDevs4PM");
            return;
        }
        $sender->sendMessage(TextFormat::RED . "Comando non esiste");
    }
}
