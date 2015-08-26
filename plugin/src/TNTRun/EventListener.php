<?php

namespace TNTRun;

use pocketmine\block\Block;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector3;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\utils\TextFormat;
use TNTRun\tasks\UnsetBlockTask;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerKickEvent;

class EventListener implements Listener{
    
    /** @var Main */
    private $tntRun;

    public function __construct(Main $tntRun){
        $this->tntRun = $tntRun;
    }

    public function onTouch(PlayerInteractEvent $event){
        if($event->getBlock()->getId() === Block::SIGN_POST || $event->getBlock()->getId() === Block::WALL_SIGN){
            $this->tntRun->getSign()->touchSign($event->getPlayer());
            $this->tntRun->getSign()->reload($event->getBlock());
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
            if($arena->getPlayerManager()->isPlaying($event->getEntity())){
                $arena->getPlayerHandler()->leavePlayer($event->getEntity());
                return;
            }
        }
    }
    
    public function onBreak(BlockBreakEvent $event){
        if($event->getBlock()->getId() === Block::SIGN_POST || $event->getBlock()->getId() === Block::WALL_SIGN){
            if($this->tntRun->getSign()->isExists($event->getBlock())){
                if($event->getPlayer()->hasPermission("tntrun.create")){
                    $this->tntRun->getSign()->removeSign($event->getBlock());
                }else{
                    $event->getPlayer()->sendMessage(TextFormat::RED . "You don't have permission to use this command!");
                }
                return;
            }
        }
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

    public function onJoin(PlayerJoinEvent $event){
        $this->tntRun->getStats()->register($event->getPlayer()->getName());
    }

    /**
     * For documentation
     * Lines for Sign
     * [TNT Run]
     * arena_name
     * number of min players
     * time
     */

    public function signCreate(SignChangeEvent $event){
        $line = $event->getLines();
        $error = false;
        if(str_replace([" ", "[", "]", "/"], "", strtolower(trim($line[0]))) != "tntrun"){
            return;
        }
        if(!$event->getPlayer()->hasPermission("tntrun.create"))
            return;
        if(!is_numeric($line[2])){
            $error[] = "<Number_of_players> is not numeric";
        }else{
            if($line[2] <= 0)
                $error[] = "<Number_of_players> must be greater than 0";
        }

        if(!is_numeric($line[3])){
            $error[] = "<Time> is not numeric";
        }else{
            if($line[3] <= 0)
                $error[] = "<Time> must be greater than 0";
        }

        if(!$error){
            $this->tntRun->getSign()->newSign($event->getBlock(), ["arena" => trim($line[1]), "direction" => $event->getBlock()->getDamage(), "n_players" => $line[2], "time" => $line[3]]);
            $event->getPlayer()->sendMessage("[TNTRun] ".TextFormat::DARK_GREEN."The Sign was created successfully!");
        }else{
            foreach($error as $e){
                $event->getPlayer()->sendMessage("[TNTRun] ".TextFormat::DARK_RED.$e);
            }
            $event->setCancelled();
        }
    }
}
