<?php

namespace TNTRun\commands;

use pocketmine\command\CommandSender;
use TNTRun\Main;

abstract class SubCmd{

    public $tntRun;

    public function __construct(Main $tntRun){
        $this->tntRun = $tntRun;
    }

    public abstract function execute(CommandSender $sender, array $args);

}