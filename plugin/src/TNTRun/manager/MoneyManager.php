<?php
namespace TNTRun\manager;

use pocketmine\plugin\Plugin;

class MoneyManager{
    /** @var Plugin */
    private $PocketMoney = false, $EconomyS = false, $MassiveEconomy = false;

    public function __construct(Main $tntRun){
        if($tntRun->getServer()->getPluginManager()->getPlugin("PocketMoney") instanceof Plugin){
            $version = explode(".", $tntRun->getServer()->getPluginManager()->getPlugin("PocketMoney")->getDescription()->getVersion());
            if($version[0] < 4){
                $tntRun->getLogger()->critical("The version of PocketMoney is too old! Please update PocketMoney to version 4.0.1");
                $tntRun->getServer()->shutdown();
            }
            $this->PocketMoney = $tntRun->getServer()->getPluginManager()->getPlugin("PocketMoney");
        }

        elseif($tntRun->getServer()->getPluginManager()->getPlugin("EconomyAPI") instanceof Plugin){
            $version = explode(".", $tntRun->getServer()->getPluginManager()->getPlugin("EconomyAPI")->getDescription()->getVersion());
            if($version[0] < 2){
                $tntRun->getLogger()->critical("The version of EconomyAPI is too old! Please update EconomyAPI to version 2.0.8");
                $tntRun->getServer()->shutdown();
            }
            $this->EconomyS = $tntRun->getServer()->getPluginManager()->getPlugin("EconomyAPI");
        }

        elseif($tntRun->getServer()->getPluginManager()->getPlugin("MassiveEconomy") instanceof Plugin)
            $this->MassiveEconomy = $tntRun->getServer()->getPluginManager()->getPlugin("MassiveEconomy");

        else{
            $tntRun->getLogger()->critical("This plugin to work needs the plugin PocketMoney or EconomyS or MassiveEconomy.");
            $tntRun->getServer()->shutdown();
        }
    }

    /**
     * @param type $player
     * @param type $value
     * @return boolean
     */
    public function addMoney($player, $value){
        if($this->PocketMoney) $this->PocketMoney->setMoney($player, $this->getMoney($player) + $value);
        elseif($this->EconomyS) $this->EconomyS->setMoney($player, $this->getMoney($player) + $value);
        elseif($this->MassiveEconomy) $this->MassiveEconomy->setMoney($player, $this->getMoney($player) + $value);
        return false;
    }

}