<?php

namespace TNTRun\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\utils\TextFormat;
use TNTRun\Main;

class TNTRunCommand extends Command implements PluginIdentifiableCommand{
    /** @var Main */
    public $tntRun;
    /** @var SubCmd[] */
    public $subCommands = [];

    public function __construct(Main $tntRun){
        parent::__construct("tntrun", "TNTRun main command", "/tntrun help", ["tr"]);
        $this->tntRun = $tntRun;
        $this->setPermission("tntrun.command");

        foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->getPlugin()->getSubCommands())) as $obj){
            /** @var \SplFileObject $obj */
            if($obj->getExtension() !== "php"){
                continue;
            }
            $class = $obj->getBasename(".php"); //rimuove estensione .php
            $className = "\\".__NAMESPACE__."\\sub\\".$class;
            $this->subCommands[strtolower(substr($class, 0, -6))] = new $className($this->tntRun);
        }
    }

    public function execute(CommandSender $sender, $label, array $args){
        if(!isset($args[0])){
            $args[0] = "help";
        }
        $sub = array_shift($args);
        if(isset($this->subCommands[strtolower($sub)])){
            if(!$sender->hasPermission("tntrun.".strtolower($sub))){
                $sender->sendMessage($this->tntRun->getMessageManager()->getMessage("error.no-permissions"));
                $sender->sendMessage(TextFormat::RED . "You don't have permission to use this command!");
                return true;
            }
            return $this->subCommands[strtolower($sub)]->execute($sender, $args);
        }
        $sender->sendMessage($this->tntRun->getMessageManager()->getMessage("error.argument"));
        return true;
    }

    public function getSubCommands(){
        return $this->subCommands;
    }

    /** @return Main */
    public function getPlugin(){
        return $this->tntRun;
    }
}