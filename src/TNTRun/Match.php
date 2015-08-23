<?php 

namespace TNTRun\Match;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

global pongame1 = [];
global pongame2 = [];
class Match extends PluginBase{

public function onPlayerInteract(PlayerInteract $e){
$player = $e->getPlayer();
$block = $e->getBlock()->getId();
if($player->hasPermission("tntrun.signjoin") or $player->hasPermission("tntrun.*")){
if($block == 63 or $block == 68){
}
}
}
}
