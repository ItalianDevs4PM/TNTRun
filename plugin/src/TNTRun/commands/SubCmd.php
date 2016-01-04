<?php

namespace TNTRun\commands;

use pocketmine\command\CommandSender;
use TNTRun\Main;

abstract class SubCmd{

    private $tntRun;

    public function __construct(Main $tntRun){
        $this->tntRun = $tntRun;
    }

    public abstract function execute(CommandSender $sender, array $args);

    public abstract function getInfo();

    public function getMessage($key, $args = []){
        return $this->getMain()->getMessageManager()->getMessage($key, $args);
    }

    public function getMain(){
        return $this->tntRun;
    }

}