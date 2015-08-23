<?php

namespace TNTRun/Command;

use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;

class Command extends PluginBase{

public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
		switch($cmd->getName()){
	
	$block = $this->getConfig()->get("block");
	
	case "tr help":
	$sender->sendMessage(TextFormat::GREEN . "----Help For TnTRun----");
	$sender->sendMessage(TextFormat::GREEN . "/tr help for help");
	$sender->sendMessage(TextFormat::GREEN . "/tr stats for statistics");
	$sender->sendMessage(TextFormat::GREEN . "/tr leave for exit the match");
	$sender->sendMessage(TextFormat::GREEN . "/tr about info for TnTRun");
	break;
	
	case "tr about":
	$sender->sendMessage(TextFormat::GREEN . "----TnTRun About----");
	$sender->sendMessage(TextFormat::GREEN . "For play click the sign");
	$sender->sendMessage(TextFormat::GREEN . "Run on the ".$block);
	$sender->sendMessage(TextFormat::GREEN . "Maked BY ItaDevs4PM");
}
