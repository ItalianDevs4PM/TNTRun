<?php

namespace TNTRun\manager;

use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use TNTRun\Main;

class MessageManager{
    /** @var Main */
    private $tntRun;
    /** @var Config */
    private $messages;

    public function __construct(Main $tntRun){
        $this->tntRun = $tntRun;
        $this->tntRun->saveResource("messages.yml");
        $this->messages = new Config($this->tntRun->getDataFolder()."messages.yml", Config::YAML);
    }

    public function getMessage($key, $args = []){
        $message = $this->messages->getNested($key, false);
        if(!$message){
            $this->tntRun->getServer()->getLogger()->warning($this->tntRun->getTag()."Translation for ".$key." not found in messages.yml!");
            return "";
        }
        foreach($args as $k => $str)
            $message = str_replace("%".$k, $str, $message);
        return $this->tntRun->getTag().trim($this->translateColors($message));
    }

    public function translateColors($message){
        foreach($this->tntRun->colors as $code => $c)
            $message = str_replace($this->tntRun->getConfig()->get("code").$code, $c, $message);
        return $message;
    }

}