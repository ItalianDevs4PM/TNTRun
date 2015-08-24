<?php

namespace TNTRun\stats;

use TNTRun\Main;
use TNTRun\Task\TaskPingMySQL;

class MySQLStatsProvider implements StatsProvider{
    /** @var Main */
    private $tntRun;
    /** @var \mysqli */
    private $db;
    
    public function __construct(Main $tntRun){
        $this->tntRun = $tntRun;
        $settings = $this->tntRun->getConfig()->get("mysql-settings");
        $this->db = new \mysqli($settings["host"], $settings["username"], $settings["password"], $settings["database"], isset($settings["port"]) ? $settings["port"] : 3306);
        
        if($this->db->connect_error){
            $tntRun->getLogger()->critical("Couldn't connect to MySQL: ".$this->db->connect_error);
            $tntRun->getServer()->shutdown();
            return;
        }
        $this->db->query("CREATE TABLE IF NOT EXISTS tntstats (name VARCHAR(16) PRIMARY KEY, matches INT, wins INT)");
        
        $tntRun->getServer()->getScheduler()->scheduleRepeatingTask(new TaskPingMySQL($tntRun), 600);
    }

    public function register($playerName){
        if(is_null($this->getStats($playerName))){
            $this->db->query("INSERT INTO tntstats (name, matches, wins) VALUES ('".$this->db->escape_string(trim(strtolower($playerName)))."', 0, 0)");
        }
    }

    public function addMatch($playerName){
        $this->db->query("UPDATE tntstats SET matches = matches + 1 WHERE name = '".$this->db->escape_string(trim(strtolower($playerName)))."'");
    }

    public function addWin($playerName){
        $this->db->query("UPDATE tntstats SET wins = wins + 1 WHERE name = '".$this->db->escape_string(trim(strtolower($playerName)))."'");
    }

    public function getStats($playerName){
        $playerName = $this->db->escape_string(trim(strtolower($playerName)));
        $result = $this->db->query("SELECT * FROM tntstats WHERE name = '".$playerName."'");
        if($result instanceof \mysqli_result){
            $assoc = $result->fetch_assoc();
            $result->free();
            if(isset($assoc["name"]) and $assoc["name"] === $playerName){
                return $assoc;
            }
        }
        return null;
    }

    public function close(){
        $this->db->close();
    }
}