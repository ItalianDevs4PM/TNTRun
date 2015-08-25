<?php

namespace TNTRun;

use pocketmine\block\Block;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector3;
use pocketmine\tile\Sign;
use pocketmine\utils\TextFormat;
use pocketmine\event\block\BlockBreakEvent;
use TNTRun\tasks\UnsetBlockTask;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerKickEvent;

class EventListener implements Listener{
    /** @var type */
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
    
    public function onMove(PlayerMoveEvent $event){
        foreach($this->tntRun->arenas as $arena){
            if($arena->getPlayerManager()->isPlaying($event->getPlayer()) && $arena->getStatusManager()->isRunning()){
                $p = $event->getPlayer();
                $p->getServer()->getScheduler()->scheduleDelayedTask(new UnsetBlockTask($this->tntRun, $p->getLevel()->getBlock(new Vector3($p->getFloorX(), $p->getFloorY() - 1, $p->getFloorZ()))), 40);
                if($p->y < $arena->getStructureManager()->getLowestFloorY()){
                    $arena->getPlayerHandler()->leavePlayer($p);
                }
                return;
            }
        }
    }
    
    public function onDeath(PlayerDeathEvent $event){
        foreach($this->tntRun->arenas as $arena){
            if($arena->getPlayerManager()->isPlaying($event->getPlayer())){
                $arena->getPlayerHandler()->leavePlayer($event->getPlayer());
                return;
            }
        }
    }
    
    public function onBreak(BlockBreakEvent $event){
        foreach($this->tntRun->arenas as $arena){
            if($arena->getPlayerManager()->isInArena($event->getPlayer())){
                $event->setCancelled();
                return;
            }
        }
    }
    
    public function onPlace(BlockPlaceEvent $event){
        foreach($this->tntRun->arenas as $arena){
            if($arena->getPlayerManager()->isInArena($event->getPlayer())){
                $event->setCancelled();
                return;
            }
        }
    }
    
    public function onQuit(PlayerQuitEvent $event){
        foreach($this->tntRun->arenas as $arena){
            if($arena->getPlayerManager()->isInArena($event->getPlayer())){
                $arena->getPlayerManager()->removePlayer($event->getPlayer());
                $arena->getPlayerManager()->removeSpectator($event->getPlayer());
                return;
            }
        }        
    }
    
    public function onKick(PlayerKickEvent $event){
        foreach($this->tntRun->arenas as $arena){
            if($arena->getPlayerManager()->isInArena($event->getPlayer())){
                $arena->getPlayerManager()->removePlayer($event->getPlayer());
                $arena->getPlayerManager()->removeSpectator($event->getPlayer());
                return;
            }
        }  
    }

}
