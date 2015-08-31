<?php

namespace TNTRun;

use pocketmine\Player;
use TNTRun\Main;

class PlayerData{
    /** @var Main */
    private $tntRun;
    /** @var array of Player*/
    private $players;

    public function __construct(Main $tntRun){
        $this->tntRun = $tntRun;
    }

    public function storePlayer(Player $player){
        $this->players[$player->getName()] = [
                "inventory" => serialize($player->getInventory()->getContents()),
                "armor" => serialize($player->getInventory()->getArmorContents()),
                "spawn" => serialize($player->getPosition()),
                "gamemode" => $player->getGamemode()
            ];
        $player->setGamemode(0);
        $player->getInventory()->clearAll();
    }

    public function restorePlayer(Player $player){
        $get = $this->players[$player->getName()];
        $player->setGamemode($get["gamemode"]);
        $player->getInventory()->setContents(unserialize($get["inventory"]));
        $player->getInventory()->setArmorContents(unserialize($get["armor"]));
        $player->teleport(unserialize($get["spawn"]));
        unset($this->players[$player->getName()]);
    }
}
