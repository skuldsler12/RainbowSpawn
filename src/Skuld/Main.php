<?php

namespace Skuld;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\plugin\PluginBase;
class Main extends PluginBase implements Listener{
       
        public function onLoad(){
                $this->getLogger()->info("onLoad() has been called!");
                
        }
        public function onDisable(){
                $this->getLogger()->info("onDisable() has been called!");
        }
        public function onEnable(){
                $this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getServer()->getLogger()->info("¡RainbowSpawnProtect Cargado!");
               
        }
        public function onPlayerLogin(PlayerLoginEvent $event){
                $playername = $event->getPlayer()->getName();
                $entra = false;
                $maxUSR = 0;
                $usrActv = count($this->getServer()->getOnlinePlayers());
                $viplist = loadJsonVipList();
                    
		$this->getServer()->getLogger()->info("¡Player entrando!");
                foreach ($viplist as $k => $v) {
                       if ($k === $playername) {
                               if ($v) {
                               $entra = $v; 
                               }
                       }
                }
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
        public function  loadJsonVipList()
        {
                $string = file_get_contents("/vips.json");
                $json_a = json_decode($string, true);
                return $json_a;
        }
        public function onPlayerQuit(PlayerQuitEvent $event){
                $usrActv -= 1;
        }
       
}