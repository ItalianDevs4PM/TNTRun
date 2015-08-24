<?php

namespace TNTRun;

use pocketmine\block\Block;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\tile\Sign;
use pocketmine\utils\TextFormat;
use pocketmine\event\entity\EntityMotionEvent;
use pocketmine\event\block\BlockBreakEvent;

class EventListener implements Listener{

    private $tntRun;

    public function __construct(Main $tntRun){
        $this->tntRun = $tntRun;
    }

    public function onTouch(PlayerInteractEvent $event){
        if($event->getBlock()->getId() === Block::SIGN_POST or $event->getBlock()->getId() === Block::WALL_SIGN){
            $tile = $event->getBlock()->getLevel()->getTile($event->getBlock());
            if($tile instanceof Sign){
                if(strtolower(TextFormat::clean($tile->getText()[0])) === "[tntrun]"){
                    //todo: handle join
                }
            }
        }
    }
    
    public function onMove(EntityMotionEvent $event){
        
        
    }
    
    public function onBreak(BlockBreakEvent $event){
        
    }
    
    

}