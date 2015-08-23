<?php

namespace TNTRun\stats;

use TNTRun\Main;

class SQLiteStatsProvider{
    /** @var Main */
    private $tntRun;
    /** @var mysqli */
    private $db;
    
    public function __construct(Main $tntRun){
        $this->tntRun = $tntRun;
        
        if(file_exists($tntRun->getDataFolder()."stats.db"))
            $this->db = new \SQLite3($tntRun->getDataFolder()."stats.db", SQLITE3_OPEN_READWRITE);
        else
            $this->db = new \SQLite3($tntRun->getDataFolder()."stats.db", SQLITE3_OPEN_CREATE|SQLITE3_OPEN_READWRITE);
        
        $this->db->exec("CREATE TABLE IF NOT EXISTS tntstats (name TEXT PRIMARY KEY, matches INTEGER, wins INTEGER)");
    }

    public function register($playerName){
        if(is_null($this->getStats($playerName)))
            $this->db->exec("INSERT INTO tntstats (name, matches, wins) VALUES ('".$this->db->escapeString(trim(strtolower($playerName)))."', 0, 0)");
    }

    public function addMatch($playerName){
        $this->db->exec("UPDATE tntstats SET matches = matches + 1 WHERE name = '".$this->db->escapeString(trim(strtolower($playerName)))."'");
    }

    public function addWin($playerName){
        $this->db->exec("UPDATE tntstats SET wins = wins + 1 WHERE name = '".$this->db->escapeString(trim(strtolower($playerName)))."'");
    }

    public function getStats($playerName){
        $playerName = trim(strtolower($playerName));
        $result = $this->db->query("SELECT * FROM tntstats WHERE name = '".$this->db->escapeString($playerName)."'");
        if($result instanceof \SQLiteResult){
            $assoc = $result->fetch(SQLITE_ASSOC);
            if(isset($assoc["name"]) and $assoc["name"] === $this->db->escapeString($playerName)){
                return $assoc;
            }
        }
        return null;
    }

    public function close(){
        $this->db->close();
    }
}