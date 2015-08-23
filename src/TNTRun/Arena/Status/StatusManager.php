<?php
namespace TNTRun\Arena\Status;

use TNTRun\Main;
use TNTRun\Arena\Handlers;
use TNTRun\Arena;

class StatusManager{
    /** @var Arena */
    private $arena;
    /** @var bool */
    private $enabled = false, $starting = false, $running = false, $regenerating = false;
        
    public function __construct(Arena $arena){
        $this->arena = $arena;
    }
    
    public function isEnabled(){
        return $this->enabled;
    }
    
    public function enableArena(){
        $this->enabled = true;
    }
    
    public function disableArena(){
        $this->enabled = false;
    }
    
    public function isStarting(){
        return $this->starting;
    }
    
    public function setStarting(bool $status = true){
        $this->starting = $status;
    }
    
    public function isRunning(){
        return $this->running;
    }
    
    public function setRunning(bool $status = true){
        $this->running = $status;
    }
    
    public function isRegenerating(){
        return $this->regenerating;
    }
    
    public function setRegenerating(bool $status = true){
        $this->regenerating = $status;
    }
}