<?php

namespace TNTRun;

use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use TNTRun\Main;

class SignHandler{
    /** @var Main */
    private $tntRun;

    //private $test = [$var => ["arena" => "string", "direction" => "ofSign" ]];

    public function __construct(Main $tntRun){
        $this->signs = new Config($tntRun->getDataFolder()."/resources", Config::YAML);
        $this->reload();
    }

    public function newSign(Position $pos, array $data){
    }

    public function touchSign(Player $player){
        $sign = $this->getSign($player->getPosition());
        if(!$sign)
            return;
    }

    private function getSign(Position $pos){
        $pos = $this->posToString($pos);
        if(!$this->signs->exists($pos))
            return false;
        return $this->signs->get($pos);
    }

    private function spawnSign(Position $pos, $get = false){
        if(!$get || !isset($get))
            $get = $this->signs->get($this->posFromString($pos));

        if($pos->level->getBlockIdAt($pos->x, $pos->y, $pos->z) != Item::SIGN_POST && $pos->level->getBlockIdAt($pos->x, $pos->y, $pos->z) != Item::WALL_SIGN){
            if($pos->level->getBlockIdAt($pos->x, $pos->y - 1, $pos->z) != Item::AIR && $pos->level->getBlockIdAt($pos->x, $pos->y - 1, $pos->z) != Item::WALL_SIGN)
                $pos->level->setBlock($pos, Block::get(Item::SIGN_POST, $get["direction"]), true, true);
            else{
                $direction = 3;
                if($pos->level->getBlockIdAt($pos->x - 1 , $pos->y, $pos->z) != Item::AIR)
                    $direction = 5;
                elseif($pos->level->getBlockIdAt($pos->x + 1 , $pos->y, $pos->z) != Item::AIR)
                    $direction = 4;
                elseif($pos->level->getBlockIdAt($pos->x , $pos->y, $pos->z + 1) != Item::AIR)
                    $direction = 2;
                $pos->level->setBlock($pos, Block::get(Item::WALL_SIGN, $direction), true, true);
            }
        }

        if(isset($this->tntRun->arenas[$get["name"]])){
            $arena = $this->tntRun->arenas[$get["name"]];

            $status = "";
            $players = "";

            $lines = ["[TNT Run]", TextFormat::ITALIC.$get["arena"], TextFormat::DARK_GREEN.$status, $players];
        }else
            $lines = ["[TNT Run]", TextFormat::RED."Arena", $get["arena"], TextFormat::RED."Not loaded"];


        $tile = $pos->getLevel()->getTile($pos);
        if($tile instanceof Sign){
            $tile->setText(... $lines);
        }
    }

    public function reload(){
        if(count($this->signs) <= 0)
            return false;

        foreach($this->signs->getAll() as $var => $c){

        }
    }

    private function posToString(Position $pos){
        $pos->round();
        $level = str_replace(" ", "%", $pos->getLevel());
        return $pos->x.":".$pos->y.":".$pos->z.":".$level;
    }

    private function posFromString($pos){
        $e = explode(":", $pos);
        $level = str_replace("%", " ", $e[3]);
        return new Position($e[0], $e[1], $e[2], $level);
    }
}
