<?php

namespace TNTRun\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use TNTRun\Main;

class TNTRunCommand extends Command implements PluginIdentifiableCommand{

    /**@var Main*/
    public $tntRun;
    /**@var SubCmd[]*/
    public $subCommands = [];

    public function __construct(Main $tntRun){
        parent::__construct("tntrun", "TNTRun main command", "/tntrun cmds", ["tr"]);
        $this->tntRun = $tntRun;
        $this->setPermission("tntrun.command");

        foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->getPlugin()->getCommandsPath())) as $file => $obj){
            if($file === "TNTRunCommand.php" or $file === "SubCmd.php" or $file === ".." or $file === "."){
                continue;
            }
            $class = substr($file, 0, strlen($file) - 4); //rimuove estensione .php
            $this->subCommands[strtolower(substr($class, 0, strlen($class) - 6))] = new $class($this);
        }
    }

    public function execute(CommandSender $sender, $label, array $args){
        if(!isset($args[0])){
            $args[0] = "info";
        }
        $sub = array_shift($args);
        if(isset($this->subCommands[strtolower($sub)])){
            return $this->subCommands[strtolower($sub)]->execute($sender, $args);
        }
        $sender->sendMessage("Strange argument ".$sub.". Please use /tr info");
        return true;
    }

    /**@return Main*/
    public function getPlugin(){
        return $this->tntRun;
    }

}