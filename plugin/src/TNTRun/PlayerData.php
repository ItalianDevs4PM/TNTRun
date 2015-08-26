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
                "inventory" => $player->getInventory(),
                "armor" => $player->getInventory()->getArmorContents(),
                "spawn" => $player->getPosition()
            ];
    }

    public function restorePlayer(Player $player){
        $get = $this->players[$player->getName()];
        $player->getInventory()->addItem($get["inventory"]);
        $player->getInventory()->setArmorContents($get["armor"]);
        $player->teleport($get["spawn"]);
        unset($this->players[$player->getName()]);
    }
}
