<?php

namespace TNTRun\manager;

use pocketmine\block\Block;
use pocketmine\item\Item;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\tile\Sign;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use TNTRun\arena\Arena;
use TNTRun\Main;

class SignHandler{
    /** @var Main */
    private $tntRun;
    /** @var Config */
    private $signs;

    //[$var => ["arena" => "string", "direction" => "ofSign", "n_players" => "number of players to start the game", "time" => "time limit for arena(seconds)" ]];

    public function __construct(Main $tntRun){
        $this->signs = new Config($tntRun->getDataFolder()."/resources/signs.yml", Config::YAML);
        $this->reload();
    }

    public function newSign(Position $pos, array $data){
        $this->signs->set($this->posToString($pos), $data);
        $this->signs->save();

        $this->spawnSign($pos, $data);
    }

    public function removeSign(Position $pos){
        $this->signs->remove($this->posToString($pos));
        $this->signs->save();
    }

    public function touchSign(Position $pos, Player $player){
        if(!$this->isExists($pos)) {
            return;
        }
        $arena = $this->getSign($pos)["arena"];
        if(!$this->tntRun->arenas[$arena]->getPlayerHandler()->canJoin($player)){
            $player->sendMessage("You can not join to this match");
            return;
        }
        $this->tntRun->arenas[$arena]->getPlayerHandler()->spawnPlayer($player);
    }

    public function getSign($var){
        if($var instanceof Position){
            $pos = $this->posToString($var);
            if($this->signs->exists($pos))
                return $this->signs->get($pos);
        }
        if($var instanceof Arena){
            foreach($this->signs->getAll() as $pos => $c){
                if($c["arena"] == $var->getName())
                    return $c;
            }
        }
        return false;
    }

    public function isExists(Position $pos){
        return $this->signs->exists($this->posToString($pos));
    }

    private function spawnSign(Position $pos, $get = false){
        if(!$get || !is_array($get))
            $get = $this->signs->get($this->posToString($pos));

        if($pos->level->getBlockIdAt($pos->x, $pos->y, $pos->z) !== Item::SIGN_POST && $pos->level->getBlockIdAt($pos->x, $pos->y, $pos->z) !== Item::WALL_SIGN){
            if($pos->level->getBlockIdAt($pos->x, $pos->y - 1, $pos->z) !== Item::AIR && $pos->level->getBlockIdAt($pos->x, $pos->y - 1, $pos->z) !== Item::WALL_SIGN)
                $pos->level->setBlock($pos, Block::get(Item::SIGN_POST, $get["direction"]), true, true);
            else{
                $direction = 3;
                if($pos->level->getBlockIdAt($pos->x - 1 , $pos->y, $pos->z) !== Item::AIR)
                    $direction = 5;
                elseif($pos->level->getBlockIdAt($pos->x + 1 , $pos->y, $pos->z) !== Item::AIR)
                    $direction = 4;
                elseif($pos->level->getBlockIdAt($pos->x , $pos->y, $pos->z + 1) !== Item::AIR)
                    $direction = 2;
                $pos->level->setBlock($pos, Block::get(Item::WALL_SIGN, $direction), true, true);
            }
        }

        if(isset($this->tntRun->arenas[$get["arena"]])){
            $arena = $this->tntRun->arenas[$get["arena"]];

            $lines = ["[TNT Run]", TextFormat::ITALIC.$get["arena"], TextFormat::DARK_GREEN.$arena->getStatusManager()->toString(), count($arena->getPlayerManager()->getAllPlayers())."/".$get["n_players"]];
        }else
            $lines = ["[TNT Run]", TextFormat::RED."Arena", $get["arena"], TextFormat::RED."Not loaded"];

        $tile = $pos->getLevel()->getTile($pos);
        if($tile instanceof Sign){
            $tile->setText(... $lines);
        }
    }

    public function reload($pos = false){
        if(count($this->signs->getAll()) <= 0) {
            return;
        }
        if($pos && $pos instanceof Position){
            $this->spawnSign($pos);
            return;
        }
        foreach($this->signs->getAll() as $var => $c){
            $this->spawnSign($this->posToString($var), $c); //fixme $var not a position
        }
    }

    public function reloadSign(Arena $arena){
        foreach($this->signs->getAll() as $var => $c){
            if($c["arena"] === $arena->getName()){
                $this->spawnSign($this->posFromString($var), $c);
                break;
            }
        }
    }

    private function posToString(Position $pos){
        $rPos = $pos->round();
        return $rPos->x.":".$rPos->y.":".$rPos->z.":".str_replace(" ", "%", $pos->getLevel()->getName());
    }

    private function posFromString($pos){
        $e = explode(":", $pos);
        $level = $this->tntRun->getServer()->getLevelByName(str_replace("%", " ", $e[3]));
        return new Position($e[0], $e[1], $e[2], $level);
    }
}
