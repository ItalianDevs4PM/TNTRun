<?php

namespace TNTRun;

use pocketmine\block\Block;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\tile\Sign;
use pocketmine\utils\TextFormat;

class EventListener implements Listener{

    private $tntRun;

    public function __construct(Main $tntRun){
        $this->tntRun = $tntRun;
    }

    public function onSign(PlayerInteractEvent $event){
        if($event->getBlock()->getId() === Block::SIGN_POST or $event->getBlock()->getId() === Block::WALL_SIGN){
            $tile = $event->getBlock()->getLevel()->getTile($event->getBlock());
            if($tile instanceof Sign){
                if(strtolower(TextFormat::clean($tile->getText()[0])) === "[tntrun]"){
                    //todo: handle join
                }
            }
        }
    }

}