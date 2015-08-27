<?php
namespace TNTRun\arena\status;

use TNTRun\arena\Arena;

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
        $this->update();
    }
    
    public function disableArena(){
        $this->enabled = false;
    }
    
    public function isStarting(){
        return $this->starting;
    }
    
    public function setStarting($status = true){
        $this->starting = $status;
        $this->update();
    }
    
    public function isRunning(){
        return $this->running;
    }
    
    public function setRunning($status = true){
        $this->running = $status;
        $this->update();
    }
    
    public function isRegenerating(){
        return $this->regenerating;
    }
    
    public function setRegenerating($status = true){
        $this->regenerating = $status;
        $this->update();
    }

    private function update(){
        $this->arena->getMain()->getSign()->reloadSign($this->arena);
    }

    public function toString(){
        if($this->isEnabled())
            return "Enabled";
        if($this->isStarting())
            return "Starting";
        if($this->isRunning())
            return "Running";
        if($this->isRegenerating())
            return "Regenerating";
        return "UNKNOW";
    }

}
