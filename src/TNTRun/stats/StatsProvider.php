<?php

namespace TNTRun\stats;

interface StatsProvider{

    /**
     * @param string $playerName
     */
    public function register($playerName);

    /**
     * @param string $playerName
     */
    public function addMatch($playerName);

    /**
     * @param string $playerName
     */
    public function addWin($playerName);

    /**
     * @param string $playerName
     * @return array|null
     */
    public function getStats($playerName);

    public function close();

}