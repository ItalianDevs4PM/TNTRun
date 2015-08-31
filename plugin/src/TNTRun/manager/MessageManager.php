<?php

namespace TNTRun\manager;

use pocketmine\command\ConsoleCommandSender;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use TNTRun\Main;

class MessageManager{
    /** @var Main */
    private $tntRun;
    /** @var string */
    private $tag = TextFormat::RED."[TNT Run] ".TextFormat::WHITE;
    /** @var array */
    private $messages;

    /*
     * Example of messages.yml
     * @url https://github.com/PocketMine/SimpleAuth/blob/master/resources/messages.yml
     */

    public function __construct(Main $tntRun){
        $this->tntRun = $tntRun;
        $this->messages = $this->parseMessages((new Config($tntRun->getDataFolder()."/resources/messages.yml", Config::YAML))->getAll());
    }

    private function parseMessages(array $messages){
        $result = [];
        foreach($messages as $key => $value){
            if(is_array($value)){
                foreach($this->parseMessages($value) as $k => $v){
                    $result[$key . "." . $k] = $v;
                }
            }else{
                $result[$key] = $value;
            }
        }
        return $result;
    }

    public function send($player, $message, $toReplace = false){
        if(!($player instanceof Player) && !($player instanceof ConsoleCommandSender))
            return;

        if(isset($this->messages[$message])){
            $message = $this->messages[$message];
            if($toReplace){
                if(is_array($toReplace)){
                    foreach($toReplace as $index => $replace){
                        $message = str_replace("%".$index."%", $replace, $message);
                    }
                }else{
                    $message = str_replace("%1%", $toReplace, $message);
                }
            }
            $player->sendMessage($this->tag.$message);
        }else {
            $this->tntRun->getServer()->broadcastMessage($this->tag . TextFormat::RED . "The message '".$message."' does not found!");
        }
    }

    public function sendMessage(Player $player, $message){
        $player->sendMessage($this->tag.$message);
    }

    public function get($message){
        return isset($this->messages[$message]) ? $this->messages[$message] : " ";
    }

    public function getTag(){
        return $this->tag;
    }
}