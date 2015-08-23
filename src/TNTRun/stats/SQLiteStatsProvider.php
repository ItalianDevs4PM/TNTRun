<?php

namespace TNTRun\stats;


use TNTRun\Main;

class SQLiteStatsProvider{

    public function __construct(Main $tntRun){
        $this->tntRun = $tntRun;
        $this->db = new \SQLite3($this->tntRun->getDataFolder()."stats.db", SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
        $this->db->exec("CREATE TABLE IF NOT EXISTS tntstats (name TEXT PRIMARY KEY, matches INTEGER, wins INTEGER)");
    }

    public function register($playerName){
        $this->db->exec("INSERT INTO players (name, matches, wins) VALUES ('".$this->db->escapeString(trim(strtolower($playerName)))."', 0, 0)");
    }

    public function addMatch($playerName){
        $this->db->exec("UPDATE players SET matches = matches + 1 WHERE name = '".$this->db->escapeString(trim(strtolower($playerName)))."'");
    }

    public function addWin($playerName){
        $this->db->exec("UPDATE players SET wins = wins + 1 WHERE name = '".$this->db->escapeString(trim(strtolower($playerName)))."'");
    }

    public function getStats($playerName){
        $result = $this->db->query("SELECT * FROM players WHERE name = '".$this->db->escapeString(trim(strtolower($playerName)))."'");
        if($result instanceof \SQLiteResult){
            $assoc = $result->fetch(SQLITE_ASSOC);
            if(isset($assoc["name"]) and $assoc["name"] === $this->db->escapeString(trim(strtolower($playerName)))){
                return $assoc;
            }
        }
        return null;
    }

    public function close(){
        $this->db->close();
    }

}