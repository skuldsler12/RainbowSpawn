<?php

namespace Skuld;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
class Main extends PluginBase implements Listener{
       
        public function onEnable(){
                $this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getServer()->getLogger()->info("¡RainbowSpawnProtect Cargado!");
		$this->Data = new Config($this->getDataFolder() . "vips.json", Config::JSON);
               
        }
        public function onPlayerLogin(PlayerJoinEvent $event){
                $playername = $event->getPlayer()->getName();
                $entra = false;
                $maxUSR = 0;
                $usrActv = count($this->getServer()->getOnlinePlayers());
                if($this->checkData($playername)){
			$rank = $this->getRank($playername);
		}else{
			//create rank data
		}
                    
		/*$this->getServer()->getLogger()->info("¡Player entrando!");
                foreach ($viplist as $k => $v) {
                       if ($k === $playername) {
                               if ($v) {
                               $entra = $v; 
                               }
                       }
                }*/#unnecesary
                if ($entra) {
                        $event->getPlayer()->teleport($this->getServer()->getDefaultLevel()->getSafeSpawn());
                        $usrActv += 1;
                } else {
                        if ($usrActv <$maxUSR) {
                                $event->getPlayer()->teleport($this->getServer()->getDefaultLevel()->getSafeSpawn());
                                $usrActv += 1;
                        }else{
                                //$event->getPlayer()->kick("Servidor completo... Prueba en 10 minutos.",true,"Servidor completo... Prueba en 10 minutos.");
                                $event->setCancelled();
                        }
                }
                
		
        }
	
	public function checkData($username) {
		return $this->Data->exists($username);
	}
        
	public function getRank($username) {
		return $this->Data->get($username);
	}
	
        public function onPlayerQuit(PlayerQuitEvent $event){
                $usrActv -= 1;
        }
       
}
