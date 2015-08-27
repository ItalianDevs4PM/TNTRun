<?php
/**
 * Created by PhpStorm.
 * User: Nikola
 * Date: 27/08/2015
 * Time: 18:44
 */

namespace TNTRun\manager;


class MessageManager{

    /** @var Main */
    private $tntRun;

    public function __construct(Main $tntRun){
        $this->tntRun = $tntRun;
    }


}