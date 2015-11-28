<?php

namespace TNTRun\manager;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use TNTRun\Main;

class MessageManager{
    /** @var Main */
    private $tntRun;
    /** @var string */
    private $tag;
    /** @var Config */
    private $messages;

    /*
     * Example of messages.yml
     * @url https://github.com/PocketMine/SimpleAuth/blob/master/resources/messages.yml
     */

    public function __construct(Main $tntRun){
        $this->tntRun = $tntRun;
        $this->tntRun->saveResource("messages.yml");
        $this->messages = new Config($this->tntRun->getDataFolder()."messages.yml", Config::YAML);
        $this->tag = $this->messages->get("prefix");
    }

    public function translateAndFormat($key, ...$args){
        $message = $this->messages->getNested($key, false);
        if(!$message){
            $this->tntRun->getServer()->getLogger()->warning("TntRun translation for ".$key." not found in messages.yml");
            return "";
        }
        foreach($args as $k => $str){
            $message = str_replace("%".$k, $str, $message);
        }
        $message = $this->tag.$message;
        return $this->translateColors($message);
    }

    public function translateColors($message, $escape = "&"){
        $message = str_replace($escape."0", TextFormat::BLACK, $message);
        $message = str_replace($escape."1", TextFormat::DARK_BLUE, $message);
        $message = str_replace($escape."2", TextFormat::DARK_GREEN, $message);
        $message = str_replace($escape."3", TextFormat::DARK_AQUA, $message);
        $message = str_replace($escape."4", TextFormat::DARK_RED, $message);
        $message = str_replace($escape."5", TextFormat::DARK_PURPLE, $message);
        $message = str_replace($escape."6", TextFormat::GOLD, $message);
        $message = str_replace($escape."7", TextFormat::GRAY, $message);
        $message = str_replace($escape."8", TextFormat::DARK_GRAY, $message);
        $message = str_replace($escape."9", TextFormat::BLUE, $message);
        $message = str_replace($escape."a", TextFormat::GREEN, $message);
        $message = str_replace($escape."b", TextFormat::AQUA, $message);
        $message = str_replace($escape."c", TextFormat::RED, $message);
        $message = str_replace($escape."d", TextFormat::LIGHT_PURPLE, $message);
        $message = str_replace($escape."e", TextFormat::YELLOW, $message);
        $message = str_replace($escape."f", TextFormat::WHITE, $message);

        $message = str_replace($escape."k", TextFormat::OBFUSCATED, $message);
        $message = str_replace($escape."l", TextFormat::BOLD, $message);
        $message = str_replace($escape."m", TextFormat::STRIKETHROUGH, $message);
        $message = str_replace($escape."n", TextFormat::UNDERLINE, $message);
        $message = str_replace($escape."o", TextFormat::ITALIC, $message);
        $message = str_replace($escape."r", TextFormat::RESET, $message);

        return $message;
    }

    public function getTag(){
        return $this->tag;
    }
}